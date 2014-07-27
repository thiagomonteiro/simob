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
                    'name' => 'uf-imovel',
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
                    'name' => 'cidade-imovel',
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
                    'name' => 'bairro-imovel',
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
                    'name' => 'area-total',
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
                    'name' => 'area-construida',
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
                    'name' => 'valor-iptu',
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
                    'name' => 'tipo-operacao',
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
                    'name' => 'valor-operacao',
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
