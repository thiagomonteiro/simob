<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form;
use Zend\Form\Form;

class login extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $email = new \Zend\Form\Element\Text('email');
        $email->setLabel('Email');
        $senha = new \Zend\Form\Element\Password('senha');
        $senha->setLabel('Senha');
        $submit = new \Zend\Form\Element\Submit('enviar');
        $submit->setAttribute('value','ok');
        $this->add($email);
        $this->add($senha);
        $this->add($submit);
    }
  
}
?>

