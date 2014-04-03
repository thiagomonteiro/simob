<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of administrador
 *
 * @author thiago
 */
namespace Application\Entity;


class Administrador extends \Base\Entity\AbstractEntity {

    private $_id;
    private $_nome;
    private $_email;
    private $_senha;

    public function setId($id){
        $this->_id = $id;
    }

   public function getId(){
       return $this->_id;
   }

   public function setNome($nome){
       $this->_nome = $nome;
   }

   public function getNome(){
       return $this->_nome;
   }

   public function setEmail($email){
      $this->_email = $email;
   }

   public function getEmail(){
       return $this->_email;
   }

   public function setSenha($senha){
       $this->_senha = $senha;
   }

   public function getSenha(){
       return $this->_senha;
   }

}
