<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orcamento extends Model
{
    use HasFactory;

    protected $table = 'tbl_orcamento';

    protected $primaryKey = 'id_orcamento';

    const CREATED_AT = 'data_criacao_orcamento';
    const UPDATED_AT = 'data_atualizacao_orcamento';

    protected $fillable = [
        'id_cliente',
        'titulo_orcamento',
        'valor_total_orcamento',
        'prazo_execucao_orcamento',
        'observacoes_orcamento',
        'status_orcamento',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}
