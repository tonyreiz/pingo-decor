<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tabela utilizada para autenticação
    protected $table = 'tbl_funcionario';

    // Chave primária
    protected $primaryKey = 'id_funcionario';

    // Datas personalizadas da tabela
    const CREATED_AT = 'data_criacao_funcionario';
    const UPDATED_AT = 'data_atualizacao_funcionario';
    // Campos permitidos
    protected $fillable = [
        'nome_usuarios',
        'email_usuarios',
        'senha_usuarios',
        'foto_usuarios',
        'nivel_usuarios',
        'status_usuarios',
    ];

        // Campos ocultos
    protected $hidden = [
        'senha_funcionario',
    ];

    /**
     * Conversões automáticas
     */
    protected function casts(): array
    {
        return [
            'senha_funcionario' => 'hashed',
        ];
    }

    /**
     * Campo utilizado pelo Laravel como senha.
     */
    public function getAuthPasswordName(): string
    {
        return 'senha_funcionario';
    }

    /**
     * Retorna a senha criptografada.
     */
    public function getAuthPassword(): string
    {
        return $this->senha_funcionario;
    }
}
