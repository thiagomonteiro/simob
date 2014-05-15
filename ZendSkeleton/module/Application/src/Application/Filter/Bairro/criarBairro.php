<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Filter\Bairro;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;

class criarBairro implements InputFilterAwareInterface {

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'nome',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => '\Zend\I18n\Validator\Alnum',
                            'options' => array(
                                    'messages' => array(\Zend\I18n\Validator\Alnum::NOT_ALNUM=> 'Informe apenas letras ou numeros')
                                ),
                            ),
                    ),
                )
            )
        );

        
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'uf',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione um estado'),
                            ),
                        ),
                    ),
                )
            )
        );

        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'cidade',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione uma cidade'),
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