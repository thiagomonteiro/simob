<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class SelectHelper extends AbstractPlugin{
    
    public function getArrayData($default,$dados){
        $select = array();
        $select[] =  array('value' => 0,'label' => $default,'disabled' => 'disabled','selected' => 'selected');
        foreach($dados as $row){
            $select[$row->getId()] = array('value' => $row->getId(), 'label' => $row->getDescricao());
        }
        return $select;
    }
    
    public function getArrayDataAlterar($indice,$dados){
        $select = array();
        foreach($dados as $row){
            $select[$row->getId()] = array('value' => $row->getId(), 'label' => $row->getDescricao());
        }
        $select[$indice]['selected']='selected';
        return $select;
    }
    
    
    /*
     * função que cria um select html a partir de um objeto
     * parametros
     * name => nome para o select
     * mensagem => mensagem default para o select
     * chave => nome da propriedade do objeto que irá representar o value do option
     * valor => valor da propriedade que será o texto do option
     */
    public function montarSelect($dados=array(),$name,$classe,$mensagem,$chave,$valor){
        $select = "<select name=".$name." class=".$classe.">";
        foreach($dados as $row){
           $getChave = 'get' . ucfirst((string)$chave);
           $getValor = 'get' . ucfirst((string)$valor);
           $select.="<option value=".$row->$getChave().">";
           $select.=$row->$getValor();
           $select.="</option>";
        }
        $select.="</select>";
        return $select;
    }
}