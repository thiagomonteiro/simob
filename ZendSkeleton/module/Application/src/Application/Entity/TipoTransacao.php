<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of TipoTransacao
 *
 * @author thiago
 */
class TipoTransacao extends \Base\Entity\AbstractEntity{
    //put your code here
    
    private $_id;
    private $_descricao;
    
    public function getId() {
        return $this->_id;
    }

    public function getDescricao() {
        return $this->_descricao;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setDescricao($descricao) {
        $this->_descricao = $descricao;
    }


}
