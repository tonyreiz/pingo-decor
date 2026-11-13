<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AtualizacaoObra extends Model
{
    use HasFactory;

    protected $table = 'tbl_atualizacao_obra';

    protected $primaryKey = 'id_atualizacao_obra';

    const CREATED_AT = 'data_criacao_atualizacao_obra';
    const UPDATED_AT = 'data_atualizacao_atualizacao_obra';

    protected $fillable = [
        'id_projetos',
        'id_funcionario',
        'descricao_atualizacao_obra',
        'imagem_atualizacao_obra',
        
    ];

    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projetos::class, 'id_projetos', 'id_projetos');
    }

    public function funcionario(): BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario', 'id_funcionario');
    }
}
