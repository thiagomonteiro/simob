/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {     
    
    var content = $(document);//o metodo live foi descontinuado

    content.delegate(".proxima-pagina-bairro","click",function(){
        var url = $(this).attr('url');
        var pagina = $(this).attr('data-proxima');
        $.get(url+'/'+pagina, function(data){
            var res = jQuery.parseJSON(data);
            if(res.success===true){
                $("#tabela-bairros").children('tbody').replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
        });
    });
    
    content.delegate(".pagina-anterior-bairro","click",function(){
       var url = $(this).attr('url');
       var pagina = $(this).attr('data-anterior');
       $.get(url+'/'+pagina, function(data){
           var res = jQuery.parseJSON(data);
           if(res.success === true){
               $("#tabela-bairros").children('tbody').replaceWith(res.html);
               $("#barra-paginacao").replaceWith(res.barrapaginacao);
           }
       });
    });
    
    
    $("#uf-select").change(function(e){
        e.preventDefault();
        var uf = $("#uf-select option:selected").text();
        $.get("/bairro/getCidades/"+uf,function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $("#cidade-select").replaceWith(res.cidades);
            }
        });
    });
    
   /* $(".proxima-pagina-bairro").on("click",function(e){
        alert('teste');
        var url = $(this).attr('url');
        var pagina = $(this).attr('data-proxima');
        $.get(url+'/'+pagina, function(data){
            var res = jQuery.parseJSON(data);
            if(res.success===true){
                $("#tabela-bairros").children('tbody').replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
        });
    });*/
    
    
   
   
    
});


