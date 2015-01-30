/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    var content = $(document);
    var timeout;
    var descricao;

content.delegate(".anuncio","mouseenter mouseleave",function(e){
         if(e.type=='mouseenter')
        {
            descricao = $(this).find('.descricao')
            timeout = setTimeout(function(){
               $(descricao).css('visibility','visible');      
               $(descricao).animate({
                         display: 'block',
                         position: 'relative',
                         left: '200px',
                         opacity: 0.9,
                });
            }, 700);
        }
        else if(e.type=='mouseleave')
        {
            clearTimeout(timeout);
            $(descricao).animate({
                         opacity: 0.9,
                         left: '0px',
                     });
            $(descricao).css('visibility','hidden');
        }
    }
    );
    

 content.delegate(".proxima-pagina","click",function(e){
      e.preventDefault();
      var url,pagina,filtro,param;
      var url = $(this).attr('url');
      var pagina = $(this).attr('data-proxima');
      var filtro =  null;
      var param = null;
      if ( $("#filtro").length ){
          filtro = $("#filtro").val();
          param =$("#param").val();
      }
      $.get(url+'/'+pagina+'/'+filtro+'/'+param, function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $("#div-anuncios").replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
      }
      );
 });
 
  content.delegate(".pagina-anterior","click",function(e){
      e.preventDefault();
      var url,pagina,filtro,param;
      var url = $(this).attr('url');
      var pagina = $(this).attr('data-anterior');
      var filtro =  null;
      var param = null;
      if ( $("#filtro").length ){
          filtro = $("#filtro").val();
          param =$("#param").val();
      }
      $.get(url+'/'+pagina+'/'+filtro+'/'+param, function(data){          
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $("#div-anuncios").replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
      }
      );
  });
  
   content.delegate(".cidade-select","change",function(){
        var cidade = $(".cidade-select option:selected").val();
        $.get("/bairro/getBairros/"+cidade, function(data){
           var res = jQuery.parseJSON(data);
           if(res.success == true){
               $(".bairro-select").replaceWith(res.bairros);
           }
        });
       
    });
    
    content.delegate("#form-busca","submit",function(e){
        e.preventDefault();
        var url,cidade,bairro,tipo,transacao,valor;
        url = $(this).attr("action");
        cidade = $(".cidade-select").val();
        bairro = $(".bairro-select").val();
        tipo = $(".filtro-tipo").val();
        transacao = $(".filtro-transacao").val();
        valor = $(".filtro-valor").val();
        if(bairro == null){
            bairro = 0;
        }
        if(tipo == null){
            tipo = 0;
        }
        if(transacao == null){
            transacao = 0;
        }
        if(valor == null){
            valor = 0;
        }
        $.get(url+"/"+cidade+"/"+bairro+"/"+tipo+"/"+transacao+"/"+valor,function(data){
        });
    });
    
  
});
