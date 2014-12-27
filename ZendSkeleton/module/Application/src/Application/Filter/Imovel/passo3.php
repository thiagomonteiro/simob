<?php
namespace Application\Filter\Imovel;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface,
    Application\Validator\Imovel\LimiteUpload;
    

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
                                  'messages' => array(LimiteUpload::LIMITE => 'Limite de 15 fotos, restantes:'),
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
