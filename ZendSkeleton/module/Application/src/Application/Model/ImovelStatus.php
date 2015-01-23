<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;

/**
 * Description of ImovelStatus
 *
 * @author thiago
 */
class ImovelStatus extends \Base\Model\AbstractModel{
    private $_imovelStatus;
    
     public function criarNovo($dados = array()){
        $this->_imovelStatus = new \Application\Entity\ImovelStatus();
        return $this->_imovelStatus;
    }
    
    protected function atualizar($obj) {
        
    }

    protected function inserir($obj) {
        
    }

    protected function recuperar($obj) {
        
    }

    protected function recuperarTodos($de, $qtd, $filtro, $param) {
        
    }

    protected function remover($obj) {
        
    }

}
