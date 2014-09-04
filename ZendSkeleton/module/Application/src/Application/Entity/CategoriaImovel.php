<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of TipoImovel
 *
 * @author thiago
 */
class CategoriaImovel extends \Base\Entity\AbstractEntity{
    private $_id;
    private $_descricao;
    
    public function getId() {
        return $this->_id;
    }

    public function getDescricao() {
        return $this->_descricao;
    }

    public function setId($_id) {
        $this->_id = $_id;
    }

    public function setDescricao($_descricao) {
        $this->_descricao = $_descricao;
    }


}
