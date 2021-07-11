<?php

namespace App\Helpers;

/**
 * class Utils
 */
class Utils 
{
    /**
     * Remove caracteres não numericos e retorna uma string numérica
     *
     * @param mixed $numero
     * @return string
     */
    public static function removeMascara($numero)
    {
        if (is_null($numero) || $numero === '') {
            return null;
        }

        return (string) preg_replace('/[^0-9]/is', '', $numero);
    }
}