<?php
namespace Application\Filter\Imovel;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;

class passo2 implements InputFilterAwareInterface {

    
    public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
        
        $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'proprietario',
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
                    'name' => 'comodos',
                    'required' => false,
                )
            )
        );
        

        return $inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {

    }
      
}
