<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comodosImovel
 *
 * @author thiago
 */
class ImovelComodo extends Base\Entity\AbstractEntity {
    private $_id;
    /*
     * @var \Application\Entity\Imovel
     */
    private $_imovel;
    /*
     * @var \Application\Entity\TipoComodos
     */
    private $_tipoComodo;
    
    public function getId() {
        return $this->_id;
    }

    public function getImovel() {
        return $this->_imovel;
    }

    public function getTipoComodo() {
        return $this->_tipoComodo;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setImovel($imovel) {
        $this->_imovel = $imovel;
    }

    public function setTipoComodo($tipoComodo) {
        $this->_tipoComodo = $tipoComodo;
    }
    
}
