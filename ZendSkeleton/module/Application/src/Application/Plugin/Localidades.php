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
        $cidades = $cidadeDAO->recuperarPorEstado($estado);
        $selectCidades = '<select name="cidade" class="cidade-select">';
        //$selectCidades = ''
        if(count($cidades)>1){
            foreach ($cidades as $row){
                $selectCidades.='<option value="'.$row->getId().'">'.  $row->getNome().'</option>';
            }
        }else{
            $selectCidades.='<option value="'.$cidades->getId().'">'.  $cidades->getNome().'</option>';
        }
        $selectCidades.='</select>'; 
        $data = array('success' => true,'cidades' => $selectCidades);
        return $this->getResponse()->setContent(Json_encode($data));
    }
    
    public function getEstados(){
        $estadoDAO = \Base\Model\daoFactory::factory('Estado');
        $Array_estado = $estadoDAO->recuperarTodos(null, null);
        $dados_select = array('' => 'selecione');
        foreach ($Array_estado as $row){
            $dados_select[$row->getId()] = $row->getUf();
        }
        return $dados_select;     
    }
}
