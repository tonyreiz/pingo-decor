<?php

namespace Tests\Feature;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use DatabaseTransactions;

    private string $testStoragePath;

    private string $testToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testToken = bin2hex(random_bytes(6));
        $this->testStoragePath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'pingo-de-cor-tests-'.$this->testToken;

        File::ensureDirectoryExists($this->testStoragePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'views');
        $this->app->useStoragePath($this->testStoragePath);
        config()->set('view.compiled', $this->testStoragePath.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'views');

        Storage::fake('public');

        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            if (config('database.connections.sqlite.database') !== ':memory:') {
                throw new \LogicException('Os testes SQLite dos CRUDs exigem DB_DATABASE=:memory:.');
            }

            $this->createLegacySchema();

            return;
        }

        if ($driver !== 'mysql') {
            throw new \LogicException("Driver de testes não suportado: {$driver}.");
        }
    }

    protected function tearDown(): void
    {
        Storage::forgetDisk('public');
        File::deleteDirectory($this->testStoragePath);

        parent::tearDown();
    }

    #[DataProvider('crudResources')]
    public function test_admin_crud_lifecycle(string $resource): void
    {
        $case = $this->crudCase($resource);
        $indexRoute = "admin.{$case['route']}.index";

        $this->get(route($indexRoute))
            ->assertOk()
            ->assertSee($case['heading']);

        $this->post(route("admin.{$case['route']}.store"), $case['create'])
            ->assertRedirect(route($indexRoute))
            ->assertSessionHas('sucesso');

        $row = DB::table($case['table'])
            ->where($case['lookup'], $case['create'][$case['lookup']])
            ->first();

        $this->assertNotNull($row);
        $id = $row->{$case['key']};

        if ($resource === 'cliente') {
            $this->assertTrue(Hash::check($case['create']['senha_cliente'], $row->senha_cliente));
            $this->assertNotSame($case['create']['senha_cliente'], $row->senha_cliente);
        }

        $oldImage = null;

        if ($case['image'] !== null) {
            $oldImage = $row->{$case['image']};
            Storage::disk('public')->assertExists($oldImage);
        }

        $this->get(route($indexRoute))
            ->assertOk()
            ->assertSee($case['create'][$case['lookup']])
            ->assertSee('name="_token"', false)
            ->assertSee('name="_method" value="PUT"', false)
            ->assertSee('name="_method" value="DELETE"', false);

        $this->put(route("admin.{$case['route']}.update", $id), $case['update'])
            ->assertRedirect(route($indexRoute))
            ->assertSessionHas('sucesso');

        $updated = DB::table($case['table'])->where($case['key'], $id)->first();

        $this->assertNotNull($updated);
        $this->assertSame($case['update'][$case['lookup']], $updated->{$case['lookup']});

        $newImage = null;

        if ($case['image'] !== null) {
            $newImage = $updated->{$case['image']};
            $this->assertNotSame($oldImage, $newImage);
            Storage::disk('public')->assertMissing($oldImage);
            Storage::disk('public')->assertExists($newImage);
        }

        $this->delete(route("admin.{$case['route']}.destroy", $id))
            ->assertRedirect(route($indexRoute))
            ->assertSessionHas('sucesso');

        $this->assertDatabaseMissing($case['table'], [$case['key'] => $id]);

        if ($newImage !== null) {
            Storage::disk('public')->assertMissing($newImage);
        }

        if (isset($case['cleanup_client'])) {
            DB::table('tbl_cliente')->where('id_cliente', $case['cleanup_client'])->delete();
        }
    }

    #[DataProvider('invalidStorePayloads')]
    public function test_each_crud_rejects_an_empty_store_payload(
        string $route,
        string $table,
        array $requiredFields,
    ): void {
        $rowCount = DB::table($table)->count();
        $indexRoute = "admin.{$route}.index";

        $this->from(route($indexRoute))
            ->post(route("admin.{$route}.store"), [])
            ->assertRedirect(route($indexRoute))
            ->assertSessionHasErrors($requiredFields);

        $this->assertSame($rowCount, DB::table($table)->count());
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public static function crudResources(): array
    {
        return [
            'banner' => ['banner'],
            'cliente' => ['cliente'],
            'contato' => ['contato'],
            'publicacoes' => ['publicacoes'],
            'projetos' => ['projetos'],
            'orcamento' => ['orcamento'],
        ];
    }

    public static function invalidStorePayloads(): array
    {
        return [
            'banner' => ['banner', 'tbl_banner', ['titulo_banner', 'imagem_banner', 'status_banner']],
            'cliente' => [
                'cliente',
                'tbl_cliente',
                ['nome_cliente', 'email_cliente', 'senha_cliente', 'foto_cliente', 'status_cliente'],
            ],
            'contato' => [
                'contato',
                'tbl_contato',
                [
                    'nome_contato',
                    'nome_companheiro_contato',
                    'nome_idade_criancas_contato',
                    'email_contato',
                    'telefone_contato',
                    'cidade_bairro_contato',
                    'profissao_contato',
                    'origem_contato',
                    'ajuda_contato',
                    'metragem_contato',
                    'quantidades_ambientes_contato',
                    'trimestre_gestacao_contato',
                    'prazo_contato',
                    'detalhes_contato',
                ],
            ],
            'publicacoes' => [
                'publicacoes',
                'tbl_publicacoes',
                [
                    'titulo_publicacoes',
                    'descricao_publicacoes',
                    'imagem_publicacoes',
                    'link_publicacoes',
                    'data_publicacoes',
                ],
            ],
            'projetos' => ['projetos', 'tbl_projetos', ['nome_projetos', 'imagem_projetos', 'status_projetos']],
            'orcamento' => [
                'orcamento',
                'tbl_orcamento',
                [
                    'id_cliente',
                    'titulo_orcamento',
                    'valor_total_orcamento',
                    'prazo_execucao_orcamento',
                    'status_orcamento',
                ],
            ],
        ];
    }

    private function crudCase(string $resource): array
    {
        return match ($resource) {
            'banner' => [
                'route' => 'banner',
                'table' => 'tbl_banner',
                'key' => 'id_banner',
                'lookup' => 'titulo_banner',
                'heading' => 'Banners e destaques',
                'image' => 'imagem_banner',
                'create' => [
                    'titulo_banner' => "Codex Banner {$this->testToken}",
                    'imagem_banner' => $this->fakePng('banner-inicial.png'),
                    'status_banner' => 'Ativo',
                ],
                'update' => [
                    'titulo_banner' => "Codex Banner Atual {$this->testToken}",
                    'imagem_banner' => $this->fakePng('banner-atualizado.png'),
                    'status_banner' => 'Inativo',
                ],
            ],
            'cliente' => [
                'route' => 'cliente',
                'table' => 'tbl_cliente',
                'key' => 'id_cliente',
                'lookup' => 'email_cliente',
                'heading' => 'Clientes',
                'image' => 'foto_cliente',
                'create' => [
                    'nome_cliente' => "Codex Cliente {$this->testToken}",
                    'email_cliente' => "codex.{$this->testToken}@example.test",
                    'senha_cliente' => 'segredo123',
                    'foto_cliente' => $this->fakePng('cliente-inicial.png'),
                    'status_cliente' => 'Ativo',
                ],
                'update' => [
                    'nome_cliente' => "Codex Cliente Atual {$this->testToken}",
                    'email_cliente' => "codex.atual.{$this->testToken}@example.test",
                    'foto_cliente' => $this->fakePng('cliente-atualizado.png'),
                    'status_cliente' => 'Inativo',
                ],
            ],
            'contato' => [
                'route' => 'contato',
                'table' => 'tbl_contato',
                'key' => 'id_contato',
                'lookup' => 'nome_contato',
                'heading' => 'Mensagens / Contatos',
                'image' => null,
                'create' => $this->validContatoPayload(),
                'update' => $this->validContatoPayload([
                    'nome_contato' => "Codex Contato Atual {$this->testToken}",
                    'telefone_contato' => '11911112222',
                    'detalhes_contato' => 'Contato atualizado pelo teste de regressao',
                ]),
            ],
            'publicacoes' => [
                'route' => 'publicacoes',
                'table' => 'tbl_publicacoes',
                'key' => 'id_publicacoes',
                'lookup' => 'titulo_publicacoes',
                'heading' => 'Publicações',
                'image' => 'imagem_publicacoes',
                'create' => [
                    'titulo_publicacoes' => "Codex Publicacao {$this->testToken}",
                    'descricao_publicacoes' => 'Publicacao criada pelo teste automatizado.',
                    'imagem_publicacoes' => $this->fakePng('publicacao-inicial.png'),
                    'link_publicacoes' => 'https://example.test/publicacao-inicial',
                    'data_publicacoes' => '2026-10-01 10:00:00',
                ],
                'update' => [
                    'titulo_publicacoes' => "Codex Publicacao Atual {$this->testToken}",
                    'descricao_publicacoes' => 'Publicacao atualizada pelo teste automatizado.',
                    'imagem_publicacoes' => $this->fakePng('publicacao-atualizada.png'),
                    'link_publicacoes' => 'https://example.test/publicacao-atualizada',
                    'data_publicacoes' => '2026-10-02 11:30:00',
                ],
            ],
            'projetos' => [
                'route' => 'projetos',
                'table' => 'tbl_projetos',
                'key' => 'id_projetos',
                'lookup' => 'nome_projetos',
                'heading' => 'Projetos',
                'image' => 'imagem_projetos',
                'create' => [
                    'nome_projetos' => "Codex Projeto {$this->testToken}",
                    'imagem_projetos' => $this->fakePng('projeto-inicial.png'),
                    'status_projetos' => 'Ativo',
                ],
                'update' => [
                    'nome_projetos' => "Codex Proj Atual {$this->testToken}",
                    'imagem_projetos' => $this->fakePng('projeto-atualizado.png'),
                    'status_projetos' => 'Inativo',
                ],
            ],
            'orcamento' => $this->orcamentoCase(),
            default => throw new \InvalidArgumentException("CRUD desconhecido: {$resource}."),
        };
    }

    private function orcamentoCase(): array
    {
        $clientId = DB::table('tbl_cliente')->insertGetId([
            'nome_cliente' => "Codex Cliente Orcamento {$this->testToken}",
            'email_cliente' => "codex.orcamento.{$this->testToken}@example.test",
            'senha_cliente' => Hash::make('segredo123'),
            'foto_cliente' => 'cliente/teste.png',
            'status_cliente' => 'Ativo',
        ]);

        return [
            'route' => 'orcamento',
            'table' => 'tbl_orcamento',
            'key' => 'id_orcamento',
            'lookup' => 'titulo_orcamento',
            'heading' => 'Lista de orçamentos',
            'image' => null,
            'cleanup_client' => $clientId,
            'create' => [
                'id_cliente' => $clientId,
                'titulo_orcamento' => "Codex Orcamento {$this->testToken}",
                'valor_total_orcamento' => '1250.50',
                'prazo_execucao_orcamento' => '30 dias',
                'observacoes_orcamento' => 'Criado pelo teste automatizado.',
                'status_orcamento' => 'Pendente',
            ],
            'update' => [
                'id_cliente' => $clientId,
                'titulo_orcamento' => "Codex Orc Atual {$this->testToken}",
                'valor_total_orcamento' => '2300.75',
                'prazo_execucao_orcamento' => '45 dias',
                'observacoes_orcamento' => 'Atualizado pelo teste automatizado.',
                'status_orcamento' => 'Aprovado',
            ],
        ];
    }

    private function validContatoPayload(array $overrides = []): array
    {
        return array_replace([
            'nome_contato' => "Codex Contato {$this->testToken}",
            'nome_companheiro_contato' => 'Codex Companheiro',
            'nome_idade_criancas_contato' => 'Crianca - 5 anos',
            'email_contato' => "contato.{$this->testToken}@example.test",
            'telefone_contato' => '11999998888',
            'cidade_bairro_contato' => 'Sao Paulo - Centro',
            'profissao_contato' => 'Pessoa de teste',
            'origem_contato' => 'Indicacao',
            'ajuda_contato' => 'Projeto de quarto',
            'metragem_contato' => '12 m2',
            'quantidades_ambientes_contato' => '1 ambiente',
            'trimestre_gestacao_contato' => 'Nao se aplica',
            'prazo_contato' => '3 meses',
            'detalhes_contato' => 'Registro criado pelo teste de regressao',
        ], $overrides);
    }

    private function fakePng(string $name): UploadedFile
    {
        $contents = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9WlNR5sAAAAASUVORK5CYII=',
            true,
        );

        if ($contents === false) {
            throw new \RuntimeException('Não foi possível preparar a imagem PNG usada no teste.');
        }

        return UploadedFile::fake()->createWithContent($name, $contents);
    }

    private function createLegacySchema(): void
    {
        Schema::create('tbl_banner', function (Blueprint $table): void {
            $table->increments('id_banner');
            $table->string('titulo_banner', 50);
            $table->string('imagem_banner', 255);
            $table->string('status_banner', 10);
            $table->dateTime('data_criacao_banner')->nullable();
            $table->dateTime('data_atualizacao_banner')->nullable();
        });

        Schema::create('tbl_cliente', function (Blueprint $table): void {
            $table->increments('id_cliente');
            $table->string('nome_cliente', 50);
            $table->string('email_cliente', 80)->unique();
            $table->string('senha_cliente', 255);
            $table->string('foto_cliente', 255);
            $table->string('status_cliente', 10);
            $table->dateTime('data_criacao_cliente')->nullable();
            $table->dateTime('data_atualizacao_cliente')->nullable();
        });


        Schema::create('tbl_orcamento', function (Blueprint $table): void {
            $table->increments('id_orcamento');
            $table->unsignedInteger('id_cliente');
            $table->string('titulo_orcamento', 50);
            $table->decimal('valor_total_orcamento', 10, 2);
            $table->text('prazo_execucao_orcamento');
            $table->text('observacoes_orcamento');
            $table->string('status_orcamento', 10);
            $table->dateTime('data_criacao_orcamento')->nullable();
            $table->dateTime('data_atualizacao_orcamento')->nullable();
            $table->foreign('id_cliente')->references('id_cliente')->on('tbl_cliente');
        });

        Schema::create('tbl_projetos', function (Blueprint $table): void {
            $table->increments('id_projetos');
            $table->string('nome_projetos', 30);
            $table->string('imagem_projetos', 255);
            $table->string('status_projetos', 10);
            $table->dateTime('data_criacao_projetos')->nullable();
            $table->dateTime('data_atualizacao_projetos')->nullable();
        });

        Schema::create('tbl_publicacoes', function (Blueprint $table): void {
            $table->increments('id_publicacoes');
            $table->string('titulo_publicacoes', 100);
            $table->text('descricao_publicacoes');
            $table->string('imagem_publicacoes', 255);
            $table->string('link_publicacoes', 255);
            $table->dateTime('data_publicacoes');
            $table->dateTime('data_criacao_publicacoes')->nullable();
            $table->dateTime('data_atualizacao_publicacoes')->nullable();
        });
    }
}
