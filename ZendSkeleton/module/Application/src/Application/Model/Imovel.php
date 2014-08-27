<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Model;
use Application\Entity\Imovel as ImovelEntity;
/**
 * Description of Imovel
 *
 * @author thiago
 */
class Imovel extends \Base\Model\AbstractModel {
    private $_imovelObj;
    
    
    public function __construct() {
        
    }
    
    public function criarNovo($params = null){
        return $this->_imovelObj = new ImovelEntity($params);
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
