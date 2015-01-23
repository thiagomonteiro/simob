<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of TipoStatus
 *
 * @author thiago
 */
class TipoStatus {
    const ATIVO = 1;
    const INATIVO = 2;   


    public static function getDescricao($codigo)
    {
        switch ($codigo) {
            case self::ATIVO:
                return 'ATIVO';
            case self::INATIVO:
                return 'INATIVO';             
        }
    }
}
