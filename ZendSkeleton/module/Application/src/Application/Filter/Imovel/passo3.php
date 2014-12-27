<?php
namespace Application\Filter\Imovel;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface;
    

class passo3 implements InputFilterAwareInterface{

   public function getInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory = new Factory();
       
         $inputFilter->add(
            $factory->createInput(
                array(
                    'name' => 'contador',
                    'required' => true,
                    'validators' => array(                       
                        array('name' => 'Application\Validator\Imovel\LimiteUpload',
                              'options' => array(
                                  'messages' => array(\Application\Validator\Imovel\LimiteUpload::LIMITE => 'Limite'),
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
