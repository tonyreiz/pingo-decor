<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Funcionario extends Model
{

    protected $table = 'tbl_funcionario';
    protected $primaryKey = 'id_funcionario';
    public $timestamps = false;
    protected  $fillable = [
        'nome_funcionario',
        'foto_funcionario',
        'email_funcionario',
        'senha_funcionario',
        'cargo_funcionario',
        'status_funcionario',
        'telefone_funcionario',
    ];
public function agendamentos()
{
    return $this->hasMany(
        Agendamento::class,
        'id_funcionario',
        'id_funcionario'
    );
}

public function atualizacoesObra(): HasMany
{
    return $this->hasMany(AtualizacaoObra::class, 'id_funcionario', 'id_funcionario');
}
}
