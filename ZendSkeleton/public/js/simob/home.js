/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   /*$(".anuncio").hover(
        function(){
            $(this).find('.descricao').css('visibility','visible');      
            $(this).find('.descricao').animate({
                     display: 'block',
                     position: 'relative',
                     left: '200px',
                     opacity: 0.9,
                 });
        },
        function(){      
            $(this).find('.descricao').animate({
                     opacity: 0.9,
                     left: '0px',
                 });
            $(this).find('.descricao').css('visibility','hidden');
        }
    );*/
    var content = $(document);
    var timeout;
    var descricao;
$(".anuncio").hover(function() {
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
    },
    function(){
        clearTimeout(timeout);
        $(descricao).animate({
                     opacity: 0.9,
                     left: '0px',
                 });
        $(descricao).css('visibility','hidden');
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
  
  
});
