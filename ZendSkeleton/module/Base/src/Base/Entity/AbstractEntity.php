<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrador
 * Date: 14/10/13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

namespace Base\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

abstract class AbstractEntity extends ClassMethods
{
    protected $_persistido;

    /**
     * Inicializa o DTO com os dados passados por parâmetro
     *
     * @param array|null $dados Array que representa os valores das propriedades do objeto DTO
     */
    public function __construct(array $dados = null)
    {
        $this->_persistido = false;
        $this->preencherPropriedades($dados);
    }

    function __get($name)
    {
        $prefixos = array('is', 'get');
        $nome = ucfirst($name);

        foreach ($prefixos as $prefixo ) {
            $propriedade = $prefixo . $nome;
            if (method_exists($this, $propriedade)) {
                return $this->$propriedade();
            }
        }
        throw new PropriedadeInvalidaException($name);
    }

    function __set($name, $value)
    {
        $propriedade = 'set' . ucfirst($name);
        if (method_exists($this, $propriedade)) {
            $this->$propriedade($value);
        }
        throw new PropriedadeInvalidaException($name);
    }

    /**
     * Atribui os valores das propriedades do objeto de acordo com a relação chave => valor do array
     * Ex.:
     * $dados['propriedadeUm'] = 'Valor1';
     *
     * equivale á chamada ao metodo "setPropridedadeUm('Valor1')" da classe.
     *
     * @param array|null $dados Array que representa os valores das propriedades do objeto DTO
     */
    public function preencherPropriedades(array $dados = null)
    {
        if (!empty($dados)) {
            foreach ($dados as $campo => $valor) {

                $metodoSet = 'set' . ucfirst((string)$campo);

                if (method_exists($this, $metodoSet)) {

                    $this->$metodoSet($valor);

                }
            }
        }
    }

    /**
     * Retorna se o Data Transfer Object já foi persistido ou não no Banco de Dados.
     *
     * @return boolean
     */
    public function isPersistido()
    {
        return $this->_persistido;
    }

    /**
     * Seta se o objeto é ou não persistido no Banco de Dados.
     *
     * @param $persistido boolean O indicador se o objeto é persistido ou não.
     * @return void
     */
    public function setPersistido($persistido)
    {
        $this->_persistido = (boolean)$persistido;
    }

    /**
     * Converte os dados das propriedades do objeto para uma string representando
     * um objeto JSON.
     *
     * @return string
     */
    public function toJSON()
    {
        return Zend_Json::encode( $this->toCassandra() );
    }



}