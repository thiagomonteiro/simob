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
    private $estadoDAO;
    private $cidadeDAO;
    private $bairroDAO;
    
    public function __construct() {
        $this->estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $this->cidadeDAO = \Base\Model\daoFactory::factory('Cidade');
        $this->bairroDAO = \Base\Model\daoFactory::factory('Bairro');
    }
    public function getEstados(){
        $Array_estado = $this->estadoDAO->recuperarTodos(null, null);
        $dados_select = array();
        $dados_select[]=array('value' => "", 'label' => 'Selecione um Estado','disabled'=>'disabled','selected'=>'selected');
        foreach ($Array_estado as $row){
            $dados_select[]=  array('value' => $row->getId(), 'label' => $row->getUf());            
        }
        return $dados_select;     
    }
    
    
   public function getCidades($uf){//funçao que preenche o select-box de cidades        
        $estado = $this->estadoDAO->recuperarPorUf($uf);
        $Array_cidades = $this->cidadeDAO->recuperarPorEstado($estado);
        $dados_select =  array();
        $dados_select[] =  array('value' => "",'label' => 'Selecione uma Cidade','disabled' => 'disabled');
        foreach ($Array_cidades as $row){
            $dados_select[] = array('value' => $row->getId(), 'label' => $row->getNome());
        }
        return $dados_select;
    }
    
  public function getBairros(\Application\Entity\Cidade $cidade){
      $Array_bairros = $this->bairroDAO->recuperarPorCidade($cidade);
      $dados_select = array();
      if(empty($Array_bairros)){
          $dados_select[] = array('value' => "", 'label' => 'Nenhum bairro cadastrado' , 'disabled' => 'disabled');  
      }else{
          $dados_select[] = array('value' => "", 'label' => 'Selecione um Bairro' , 'disabled' => 'disabled');  
          foreach ($Array_bairros as $row){
                $dados_select[] = array('value' => $row->getId(), 'label' => $row->getNome());
          }
      }
      
      return $dados_select;
  }     
}
