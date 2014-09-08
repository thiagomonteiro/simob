$(document).ready(function(){
    var content = $(document);//o metodo live foi descontinuado
    content.delegate(".uf-select","change",function(){
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
    
    content.delegate(".categoria-select","change",function(){
        var categoria = $(".categoria-select option:selected").val();
        $.get("/imovel/getSubCategorias/"+categoria, function(data){
           var res = jQuery.parseJSON(data);
           if(res.success == true){
               $(".sub-categoria-select").replaceWith(res.select);
           }
        });
    });
});


