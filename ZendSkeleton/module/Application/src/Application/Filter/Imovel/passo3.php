<?php
namespace Application\Filter\Imovel;

use Zend\InputFilter\InputFilter,
    Zend\InputFilter\Factory,
    Zend\InputFilter\InputFilterAwareInterface,
    Zend\InputFilter\InputFilterInterface,
    Zend\Filter\File\RenameUpload,
    Zend\InputFilter\FileInput,
    Zend\Validator\File\MimeType,
    Zend\Validator\File\Size;

class passo3 extends InputFilter{

    
    public function __construct()
    {
        $arquivo = new FileInput('uploadfile');
        $arquivo->setRequired(true);
        $arquivo->getFilterChain()->attach(new RenameUpload(array(
            'target'    =>  '.data/blog_',
            'use_upload_extesion'   => true,
            'randomize' =>  true,
        )));
        $arquivo->getValidatorChain()->attach(new Size(array(
            'max'   => substr(ini_get('upload_max_filesize'),0, -1).'MB'
        )));
        $arquivo->getValidatorChain()
                ->attach(new MimeType(array(
                    'image/gif',
                    'image/jpeg',
                    'image/png',
                    'enableHeaderCheck'=>true
                )));
                $this->add($arquivo);
    } 
}
