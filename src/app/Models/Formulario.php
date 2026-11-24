<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $table = 'tbl_formulario';

    protected $primaryKey = 'id_formulario';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'endereco',
        'profissao',
        'tipo_projeto',
        'metragem',
        'prazo',
        'descricao',
        'observacoes',
        'status_formulario',
        'data_criacao_formulario',
        'data_atualizacao_formulario'
    ];
}
