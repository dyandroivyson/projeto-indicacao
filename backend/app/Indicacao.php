<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * class Indicacao
 */
class Indicacao extends Model
{
    protected $table = 'indicacoes';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'status_indicacao_id'
    ];

    public function statusIndicacao()
    {
        return $this->belongsTo(\App\statusIndicacao::class, 'status_indicacao_id');
    }
}
