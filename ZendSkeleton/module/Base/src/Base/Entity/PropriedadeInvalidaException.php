<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrador
 * Date: 22/10/13
 * Time: 00:21
 * To change this template use File | Settings | File Templates.
 */
namespace Base\Entity;

class PropriedadeInvalidaException extends \Exception
{
    public function __construct($propriedade, $code = 0, Exception $previous = null)
    {
        $msg = 'A propriedade "' . $propriedade . '" é inválida no objeto que está tentando acessá-la.';
        echo $msg;
        //parent::__construct($msg, $code, $previous);
    }
}