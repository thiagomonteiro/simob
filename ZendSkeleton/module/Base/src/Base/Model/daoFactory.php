<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of daoFactory
 *
 * @author thiago
 */

namespace Base\Model;

class daoFactory {
    public static function factory($type)
    {
        $classname = '\\Application\\Model\\' . $type;
        if (class_exists($classname)) { 
            return new $classname;
        } else {
            return 'dao nao encontrada';
        }
    }
}
