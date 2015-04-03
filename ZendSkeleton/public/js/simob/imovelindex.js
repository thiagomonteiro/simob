$(document).ready(function() {     

    /*****************************paginação***************************************/
    
    var content = $(document);//o metodo live foi descontinuado
    content.delegate(".proxima-pagina","click",function(){
        var url = $(this).attr('url');
        var pagina = $(this).attr('data-proxima');
        $.get(url+'/'+pagina, function(data){
            var res = jQuery.parseJSON(data);
            if(res.success===true){
                $("#tabela-imoveis").children('tbody').replaceWith(res.html);                
                $("#barra-paginacao").replaceWith(res.barrapaginacao);
            }
        });
        
        
        
    });
    
    content.delegate(".pagina-anterior","click",function(){
       var url = $(this).attr('url');
       var pagina = $(this).attr('data-anterior');
        $.get(url+'/'+pagina, function(data){
                 var res = jQuery.parseJSON(data);
                 if(res.success===true){
                     $("#tabela-imoveis").children('tbody').replaceWith(res.html);                
                     $("#barra-paginacao").replaceWith(res.barrapaginacao);
                 }
             });
       
       
    });
    /********************************************************paginacao*******************/
    
    /******botoes***********/
    content.delegate(".ativar","click",function(){
        var id = $(this).val();
        $(this).replaceWith('<button class="inativar" value="'+id+'">Inativar</button>');  
        $.post('/imovel/ativar/'+id,function(data){
        });
    });
    
    content.delegate(".inativar","click",function(){
        var id = $(this).val();
        $(this).replaceWith('<button class="ativar" value="'+id+'">Ativar</button>');  
        $.post('/imovel/inativar/'+id,function(data){
        });
    });
    
    content.delegate(".deletar-imovel","click",function(){
        var linha = $(this).closest('tr');
        var id = $(this).closest('tr').find(".id").text();
        $.post('/imovel/deletar/'+id,function(data){
            $(linha).remove();
        });
    });
    
    
    content.delegate(".alterar-imovel","click",function(){
        $(this).closest('tr').addClass('tr-edit');        
        var id = $(this).closest('tr').find(".id").text();
        window.location.href = "alterarPasso1/"+id;
    });
    
    $("#passo1-update")
    
    
    
    
    
    /*      fim de botoes           */
    
    });


function mascarar(){
  $(".preco").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false});
  $(".iptu").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: false});
}