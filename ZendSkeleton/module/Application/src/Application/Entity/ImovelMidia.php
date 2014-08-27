<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Entity;

/**
 * Description of ImovelMidia
 *
 * @author thiago
 */
class ImovelMidia extends \Base\Entity\AbstractEntity {
    
    private $_id;
    /*
     * @var \Application\Entity\Imovel
     */
    private $_imovel;
    /*
     * @var \Application\Entity\Midia
     */
    private $_midia;
    
    public function getId() {
        return $this->_id;
    }

    public function getImovel() {
        return $this->_imovel;
    }

    public function getMidia() {
        return $this->_midia;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setImovel($imovel) {
        $this->_imovel = $imovel;
    }

    public function setMidia($midia) {
        $this->_midia = $midia;
    }
    
}
