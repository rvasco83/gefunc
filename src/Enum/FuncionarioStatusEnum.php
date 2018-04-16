<?php
/**
 * Created by PhpStorm.
 * User: Rodrigo Vasco
 * Date: 16/04/2018
 * Time: 16:32
 */

namespace App\Enum;


class FuncionarioStatusEnum
{
    const STATUS_ATIVO = 'A';
    const STATUS_EXONERADO = 'E';

    public static function getStatus()
    {
        return [
            self::STATUS_ATIVO => 'Ativo',
            self::STATUS_EXONERADO =>'Exonerado'
        ];
    }

}