<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CpfUnique
 *
 * @author thiago
 */

namespace Application\Validator;
 
use Zend\Validator\AbstractValidator;

class CpfUnique extends AbstractValidator {
    
    const INVALID = "CPFDuplicado.";
 
    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID        => "CPF Duplicado.",
    );


    public function isValid($value) {
         $cpf = $this->trimCPF($value);
         $this->verificar($cpf);
         if (!$this->verificar($cpf)) {
            $this->error(self::INVALID);
            return false;
        }
         return true;
    }
    
    private function trimCPF($cpf)
    {
        $cpf = preg_replace('/[.,-]/', '', $cpf);
        return $cpf;
    }
    
    private function verificar($cpf){
        $proprietarioDao = \Base\Model\daoFactory::factory('Proprietario');
        $result = $proprietarioDao->recuperarPorCpf($cpf);
        if(count($result) == 0){
          return true;  
        }else{
            return false;
        }
        
    }
}
