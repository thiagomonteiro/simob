/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
        function(){
            var mensagem=$('.response-error');            
            if(mensagem.length){//verifica se existe alguma mensagem de erro
                notif({
                    msg: mensagem.text(),
                    type: mensagem.attr('tipo'),
                    width: "all",
                    opacity: 0.8,
                    position: "center",
                });
            }
        }
        );