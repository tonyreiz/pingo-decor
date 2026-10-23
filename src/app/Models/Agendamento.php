<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class  Agendamento extends Model{

    protected $table = 'tbl_agendamento';
    protected $primaryKey = 'id_agendamento';

    public $timestamps = false;

    protected $fillable = [                    
        'id_cliente',
        'id_funcionario',          
        'dia_agendamento',
        'horario_agendamento',
        'endereco_agendamento',
        'status_agendamento',
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'id_cliente','id_cliente');
    }

public function funcionario()
{
    return $this->belongsTo(
        Funcionario::class,
        'id_funcionario',
        'id_funcionario'
    );
}
}
