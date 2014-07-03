<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
/**
 * Description of Localidades
 *
 * @author thiago
 */
class Localidades extends AbstractPlugin {
    
   public function getCidades($uf){//funçao que preenche o select-box de cidades        
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $estado = $estadoDAO->recuperarPorUf($uf);
        $cidadeDAO = \Base\Model\daoFactory::factory('Cidade');
        $Array_cidades = $cidadeDAO->recuperarPorEstado($estado);
        $dados_select =  array();
        $dados_select[] =  array('value' => '0','label' => 'Selecion uma Cidade','disabled' => 'disabled');
        foreach ($Array_cidades as $row){
            $dados_select[] = array('value' => $row->getId(), 'label' => $row->getNome());
        }
        return $dados_select;
    }
    
    
    public function getEstados(){
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $Array_estado = $estadoDAO->recuperarTodos(null, null);
        $dados_select = array();
        $dados_select[]=array('value' => '0', 'label' => 'Selecione um Estado','disabled'=>'disabled','selected'=>'selected');
        foreach ($Array_estado as $row){
            $dados_select[]=  array('value' => $row->getId(), 'label' => $row->getUf());            
        }
        return $dados_select;     
    }
}
