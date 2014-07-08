/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    mascarar();
    var content = $(document);//o metodo live foi descontinuado
    content.delegate(".uf-select","change",function(){
        //e.preventDefault();
        var uf = $(".uf-select option:selected").text();
        $.get("/bairro/getCidades/"+uf,function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $(".uf-select").closest('section').find(".cidade-select").replaceWith(res.cidades);//o uf select e o uf cidade da view criar precisam estar dentro de uma section 
                $(".bairro-select Option").each(function(){$(this).remove();});//limpo os bairros
                $(".bairro-select").append('<option>Selecione uma Cidade</option>');
            }
        });
    });
    
    content.delegate(".cidade-select","change",function(){
        var cidade = $(".cidade-select option:selected").val();
        $.get("/bairro/getBairros/"+cidade, function(data){
           var res = jQuery.parseJSON(data);
           if(res.success == true){
               $(".bairro-select").closest("section").find(".bairro-select").replaceWith(res.bairros);
           }
        });
    });
    
});

function mascarar(){
    $(".cpf").mask("999.999.999-99",{placeholder : "_"});
    $(".telefone").mask("(99)9999-9999");
    $(".celular").mask("(99)99999-9999");
}