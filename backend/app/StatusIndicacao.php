<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * class StatusIndicacao
 */
class StatusIndicacao extends Model
{
    const INICIADA = 1;
    const EM_PROCESSO = 2;
    const FINALIZADA = 3;

    protected $table = 'status_indicacao';
    
    protected $primaryKey = 'id';
    
    /**
     * Retorna o próximo status baseado no status atual
     *
     * @param  int $status_atual
     * @return object
     */
    public static function proximoStatus($status_atual=NULL)
    {
        $proximo_status = self::find(self::FINALIZADA);

        if (is_null($status_atual)) {
            $proximo_status = self::find(self::INICIADA);
        } elseif ($status_atual == self::INICIADA) {
            $proximo_status = self::find(self::EM_PROCESSO);
        }

        return $proximo_status;
    }
}
