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



function exibir_erros(erros,form) {
    
    var vetor=[];
       $.each(erros, function(index, value) {
            $.each(value,function(chave,valor){
               vetor[index]=valor;
            });
        }); 
        
        for (var key in vetor){
            if (vetor.hasOwnProperty(key)){
                 $(form).find('input[name='+key+']').after(vetor[key]);
                 $(form).find('select[name='+key+']').after(vetor[key]);
                 $(form).find('textarea[name='+key+']').after(vetor[key]);
            }
        }
}