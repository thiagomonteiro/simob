<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace Application\Filter\Proprietario;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;

class alterarProprietario implements InputFilterAwareInterface {

    
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
                                    'allowWhiteSpace' => true,
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
        
         $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'logradouro',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                )
            )
        );
         
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'numero',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                )
            )
        );
        
         $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'telefone',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                )
            )
        );
         
         $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'celular',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                )
            )
        );
         
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'rg',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                )
            )
        );
        
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'profissao',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
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

