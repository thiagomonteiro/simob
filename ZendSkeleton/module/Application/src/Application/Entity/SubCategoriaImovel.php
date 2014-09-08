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
class SubCategoriaImovel extends \Base\Entity\AbstractEntity {
    private $_id;
    private $_descricao;
    /*
     * @var Application\Entity\CategoriaImovel
     */
    private $_categoria;
    
    
    public function getId() {
        return $this->_id;
    }

    public function getDescricao() {
        return $this->_descricao;
    }

    public function getCategoria() {
        return $this->_categoria;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setDescricao($descricao) {
        $this->_descricao = $descricao;
    }

    public function setCategoria(\Application\Entity\CategoriaImovel $categoria) {
        $this->_categoria = $categoria;
    }
       
    
}
