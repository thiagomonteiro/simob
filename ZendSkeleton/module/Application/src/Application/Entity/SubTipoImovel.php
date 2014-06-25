<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of SubTipoImovel
 *
 * @author thiago
 */
class SubTipoImovel extends \Base\Entity\AbstractEntity {
    private $_id;
    private $_descricao;
    /*
     * @var Application\Entity\TipoImovel
     */
    private $_tipo;
    
    
    public function getId() {
        return $this->_id;
    }

    public function getDescricao() {
        return $this->_descricao;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setDescricao($descricao) {
        $this->_descricao = $descricao;
    }

    public function setTipo(\Application\Entity\TipoImovel $Tipo) {
        $this->Tipo = $Tipo;
    }
       
    
}
