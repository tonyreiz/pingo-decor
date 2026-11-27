<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Briefing extends Model
{
    protected $table = 'tbl_briefing';

    protected $primaryKey = 'id_briefing';

    const CREATED_AT = 'data_criacao_briefing';
    const UPDATED_AT = 'data_atualizacao_briefing';

    protected $fillable = ['id_projetos', 'conteudo_briefing'];

    protected $casts = ['conteudo_briefing' => 'array'];
}
