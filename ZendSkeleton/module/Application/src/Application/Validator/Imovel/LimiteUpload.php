<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Validator\Imovel;
use Zend\Validator\AbstractValidator;
/**
 * Description of LimiteImage
 *
 * @author thiago
 */
class LimiteUpload extends AbstractValidator {
    const LIMITE = "Limite";

        /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::LIMITE       => "Limite upload",
    );
    
    public function isValid($value) {
         if (!$this->verificar($value)) {
            $this->error(self::LIMITE);
            return false;
        }
        return true;
         
    }
    
    public function verificar($qtdUpload){
        $sessao = new \Application\Plugin\SessionHelper();
        $sessao->definirSessao('imovel');
        $imovel_sessao = $sessao->recuperarObjeto('imovel');
        $midiaDao = \Base\Model\daoFactory::factory('Midia');
        $qtdBd = $midiaDao->recuperarTotal($imovel_sessao->getId());
        $total = $qtdBd + $qtdUpload;
        if($total <= 16){ 
          return true;  
        }else{
           return false;
        }
    }
}
