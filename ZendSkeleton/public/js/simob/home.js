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
      var url,pagina,cidade,bairro,tipo,transacao,valor;
      var url = $(this).attr('url');
      var pagina = $(this).attr('data-proxima');
      cidade = $(".cidade-hidden").val();
      bairro = $(".bairro-hidden").val();
      tipo = $(".tipo-hidden").val();
      transacao = $(".transacao-hidden").val();
      valor = $(".valor-hidden").val();
        if(cidade == ""){
            cidade = 0;
        }
        if(bairro == ""){
            bairro = 0;
        }
        if(tipo == ""){
            tipo = 0;
        }
        if(transacao == ""){
            transacao = 0;
        }
        if(valor == ""){
            valor = 0;
        }
      $.get(url+'/'+pagina+'/'+cidade+'/'+bairro+'/'+tipo+'/'+transacao+'/'+valor, function(data){
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
      var url,pagina,cidade,bairro,tipo,transacao,valor;
      var url = $(this).attr('url');
      var pagina = $(this).attr('data-anterior');
      cidade = $(".cidade-hidden").val();
      bairro = $(".bairro-hidden").val();
      tipo = $(".tipo-hidden").val();
      transacao = $(".transacao-hidden").val();
      valor = $(".valor-hidden").val();
        if(cidade == ""){
            cidade = 0;
        }
        if(bairro == ""){
            bairro = 0;
        }
        if(tipo == ""){
            tipo = 0;
        }
        if(transacao == ""){
            transacao = 0;
        }
        if(valor == ""){
            valor = 0;
        }
      $.get(url+'/'+pagina+'/'+cidade+'/'+bairro+'/'+tipo+'/'+transacao+'/'+valor, function(data){
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
        $(".cidade-hidden").val(cidade);
        bairro = $(".bairro-select").val();
        $(".bairro-hidden").val(bairro);
        tipo = $(".filtro-tipo").val();
        $(".tipo-hidden").val(tipo);
        transacao = $(".filtro-transacao").val();
        $(".transacao-hidden").val(transacao);
        valor = $(".filtro-valor").val();
        $(".valor-hidden").val(valor);
        if(cidade == null){
            cidade = 0;
        }
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
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $("#div-anuncios").replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
        });
    });
    
  
});
