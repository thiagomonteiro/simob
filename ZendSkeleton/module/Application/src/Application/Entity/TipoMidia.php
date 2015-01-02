<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of TipoMidia
 *
 * @author thiago
 */
class TipoMidia {
    const SEM_MIDIA = 0;
    const FOTO = 1;
    const VIDEO = 2;


    public static function getDescricao($codigo)
    {
        switch ($codigo) {
            case self::SEM_MIDIA:
                return 'SEM_MIDIA';
            case self::FOTO:
                return 'FOTO';
             case self::VIDEO:
                return 'VIDEO';
        }
    }
}
