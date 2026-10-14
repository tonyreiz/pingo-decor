<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depoimento extends Model
{
    use HasFactory;

    protected $table = 'tbl_depoimento';

    protected $primaryKey = 'id_depoimento';

    const CREATED_AT = 'data_criacao_depoimento';
    const UPDATED_AT = 'data_atualizacao_depoimento';

    protected $fillable = [
        'id_cliente',
        'titulo_depoimento',
        'descricao_depoimento',
        'nota_depoimento',
        'status_depoimento',
    ];

    public function cliente()
    {
        return $this->belongsTo(
            Cliente::class,
            'id_cliente',
            'id_cliente'
        );
    }
}
