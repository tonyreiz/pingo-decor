<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favoritos extends Model
{
    use HasFactory;

    protected $table = 'tbl_favoritos';

    protected $primaryKey = 'id_favoritos';

    const CREATED_AT = 'data_criacao_favoritos';
    const UPDATED_AT = 'data_atualizacao_favoritos';

    protected $fillable = [
        'id_cliente',
        'id_projetos',

    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projetos::class, 'id_projetos', 'id_projetos');
    }
}
