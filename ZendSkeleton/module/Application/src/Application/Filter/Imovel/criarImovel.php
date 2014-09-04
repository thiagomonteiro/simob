<?php
namespace Application\Filter\Imovel;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;

class criarImovel implements InputFilterAwareInterface {

    
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
  
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
                    'name' => 'bairro',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione uma bairro'),
                            ),
                        ),
                    ),
                )
            )
        );
        
         
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'rua',
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
                    'name' => 'descricao',
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
                    'name' => 'areaTotal',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\GreaterThan',
                            'options' => array(
                                'min' => 1,
                                'inclusive' => true,
                                'messages' => array(\Zend\Validator\GreaterThan::NOT_GREATER_INCLUSIVE=> 'Entre com um valor positivo'),
                            ),
                        ),
                    ),
                )
            )
        );
        
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'areaConstruida',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\GreaterThan',
                            'options' => array(
                                'min' => 1,
                                'inclusive' => true,
                                'messages' => array(\Zend\Validator\GreaterThan::NOT_GREATER_INCLUSIVE=> 'Entre com um valor positivo'),
                            ),
                        ),
                    ),
                )
            )
        );
        
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'valorIptu',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\GreaterThan',
                            'options' => array(
                                'min' => 1,
                                'inclusive' => true,
                                'messages' => array(\Zend\Validator\GreaterThan::NOT_GREATER_INCLUSIVE=> 'Entre com um valor positivo'),
                            ),
                        ),
                    ),
                )
            )
        );
          
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'tipoTransacao',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione uma operação'),
                            ),
                        ),
                    ),
                )
            )
        );
          
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'valorTransacao',
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
                    'name' => 'categoria',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione uma categoria'),
                            ),
                        ),
                    ),
                )
            )
        );
         
          $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'subCategoria',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'Zend\Filter\StripTags'),
                        array('name' => 'Zend\Filter\StringTrim'),
                    ),
                    'validators' => array(
                        array('name' => 'Zend\Validator\NotEmpty',
                            'options' => array(
                                'messages' => array(NotEmpty::IS_EMPTY => 'Selecione uma sub categoria'),
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
