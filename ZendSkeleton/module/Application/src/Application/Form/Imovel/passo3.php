<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Form\Imovel;
use Zend\Form\Form;
/**
 * Description of passo3
 *
 * @author administrador
 */
class passo3 extends Form{
    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->setAttributes(array('class' => 'upload-wrapper', 'id' => 'upload-wrapper'));
        $contador = new \Zend\Form\Element\Hidden('contador');
        $contador->setAttribute('id', 'contador');
        $contador->setValue(0);
        $file = new \Zend\Form\Element\File("uploadfile");
        $file->setAttributes(array('class'=>'upload-file','multiple' => true, 'accept' => "image/jpeg"));
        $imgButton = new \Zend\Form\Element\Image("uploadbutton");    
        $imgButton->setAttributes(
                array('class' => 'upload-button','src' => "/img/add_foto.png")
                );
        $concluir = new \Zend\Form\Element\Submit('concluir');
        $concluir->setAttributes(
                array('class' => 'concluir-passo3','value' => 'concluir')
                );
        $this->add($contador);
        $this->add($file);
        $this->add($imgButton);
        $this->add($concluir);
    }
}