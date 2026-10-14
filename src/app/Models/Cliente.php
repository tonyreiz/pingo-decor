<?php

namespace App\Models;

use App\Support\PublicImageStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Nome explícito da tabela no banco de dados
    protected $table = 'tbl_cliente';

    // Chave primária personalizada
    protected $primaryKey = 'id_cliente';

    // Define os nomes personalizados das colunas de data/timestamp
    const CREATED_AT = 'data_criacao_cliente';
    const UPDATED_AT = 'data_atualizacao_cliente';

    // Campos que podem ser preenchidos em massa (Mass Assignment)
    protected $fillable = [
        'nome_cliente',
        'email_cliente',
        'senha_cliente',
        'foto_cliente',
        'status_cliente',
    ];

    // Oculta a senha ao converter o modelo para Array ou JSON
    protected $hidden = [
        'senha_cliente',
    ];

    protected function casts(): array
    {
        return [
            'senha_cliente' => 'hashed',
        ];
    }

    public function photoUrl(): string
    {
        return PublicImageStorage::url($this->foto_cliente);
    }

    public function depoimentos()
{
    return $this->hasMany(
        Depoimento::class,
        'id_cliente',
        'id_cliente'
    );
}
}
