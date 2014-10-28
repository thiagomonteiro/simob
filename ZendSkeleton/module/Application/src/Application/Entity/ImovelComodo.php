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
namespace Application\Entity;

class ImovelComodo extends \Base\Entity\AbstractEntity {
    private $_id;
    /*
     * @var \Application\Entity\Imovel
     */
    private $_imovel;
    /*
     * @var \Application\Entity\TipoComodos
     */
    private $_tipoComodo;
    
    private $_Qtd;
    
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

    public function setImovel(\Application\Entity\Imovel $imovel) {
        $this->_imovel = $imovel;
    }

    public function setTipoComodo(\Application\Entity\TipoComodos $tipoComodo) {
        $this->_tipoComodo = $tipoComodo;
    }
    
    public function setQtd($qtd){
        $this->_Qtd = $qtd;
    }
    
    public function getQtd(){
        return $this->_Qtd;
    }
    
}
