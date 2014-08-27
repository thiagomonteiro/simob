<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Filter\Comodo;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;

class criarComodo implements InputFilterAwareInterface {

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'descricao',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => '\Zend\I18n\Validator\Alnum',
                            'options' => array(
                                    'allowWhiteSpace' => true,
                                    'messages' => array(\Zend\I18n\Validator\Alnum::NOT_ALNUM=> 'Informe apenas letras ou numeros')
                                ),
                            ),
                    ),
                )
            )
        );


        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {

    }

}