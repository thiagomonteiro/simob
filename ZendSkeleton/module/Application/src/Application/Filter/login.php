<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Filter;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;

class login implements InputFilterAwareInterface {

    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'email',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                              'options' => array(
                                  'messages' => array('isEmpty' => 'O campo nao pode ficar vazio')
                              ),
                        ),
                    ),
                )
            )
        );


        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'senha',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'O campo não pode ficar vazio'),
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