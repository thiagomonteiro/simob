/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {     
    
    
    /*****************************paginação***************************************/
    
    var content = $(document);//o metodo live foi descontinuado
    
    content.delegate(".proxima-pagina","click",function(){
        var url = $(this).attr('url');
        var pagina = $(this).attr('data-proxima');
        var filtro = $("#hidden-filtro").val();
        var param = $("#hidden-param").val();
        if(filtro.length == 0){
                $.get(url+'/'+pagina, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-bairros").children('tbody').replaceWith(res.html);                
                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                    }
                });
        }else{
             $.get(url+'/'+pagina+'/'+filtro+'/'+param, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-bairros").children('tbody').replaceWith(res.html);                
                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                    }
                });
        }
        
        
    });
    
    content.delegate(".pagina-anterior","click",function(){
       var url = $(this).attr('url');
       var pagina = $(this).attr('data-anterior');
       var filtro = $("#hidden-filtro").val();
       var param = $("#hidden-param").val();
       if(filtro.length == 0){
           $.get(url+'/'+pagina, function(data){
                var res = jQuery.parseJSON(data);
                if(res.success === true){
                    $("#tabela-bairros").children('tbody').replaceWith(res.html);
                    $("#barra-paginacao").replaceWith(res.barrapaginacao);
                }
            });
       }else{
           $.get(url+'/'+pagina+'/'+filtro+'/'+param, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-bairros").children('tbody').replaceWith(res.html);                
                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                    }
                });
       }
       
    });
    /********************************************************paginacao*******************/
    
    
    
    /********************************************************criar********************************/
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
    /*******************************************criar***********************/
    
    
    
    
    
    /************************************busca********************************/
    //'EXIBIR UMA MODAL PARA SELECIONAR A CIDADE. A CIDADE SELECIONADA SERA COLOCADO DENTRO DO CAMPOS PARAMETRO QUE FICARÁ DESATIVADO PARA EDICAO SO SENDO REABILITADO CASO O USUARIO SELECIONE O CAMPO NOME'
    $("#filtro").change(
            function(){
                var filtro = $("#filtro option:selected").text();
                if(filtro == "cidade"){
                    $(function() {
                        $( "#dialog-busca").dialog({
                          height: 200,
                          width:400,
                          modal: true,
                          buttons: {
                            "Selecionar": function () {
                                var cidade = $("#cidade-select option:selected");
                                if(cidade.val()!="selecione um estado"){
                                    $('#hidden-param').val(cidade.val());
                                    $('#param').val(cidade.text());
                                }else{
                                    $('#filtro').val('selecione');
                                }
                                $(this).dialog("close");
                              },
                            "Cancelar": function () {
                                $("#filtro").val('selecione');
                                $(this).dialog("close");
                              }
                          }
                        });
                      });
                }
            }
    );
    
    $("#busca-submit").click(     
            function(e){
                e.preventDefault();
                var form = $("#form-busca"); 
                var rota = form.attr('action');
                var param;
                var filtro = $("#filtro option:selected").text();
                if(filtro == "cidade"){
                    param = $("#hidden-param").val();
                }else if(filtro == "nome"){
                    var param = $("#param").val();
                }else{
                    alert('selecione um filtro');
                    exit();
                }
                var url= rota+'/'+filtro+'/'+param;
                window.location.replace(url);
            }
    );
    
    content.delegate(".deletar-bairro","click",function(){
        var linha = $(this).closest('tr');
        var id = $(this).closest('tr').find(".id-bairro").val();//retorna o elemento mais proximo
        //var id = $(this).parents('tr').find(".id-bairro").val();//retorna todos os ascendentes que sejam ul
        //var id = $(this).parent('tr').find(".id-bairro").val();//retorna o mais proximo
        $("#dialog-mensagem").find("p").text("Você esta prestes a excluir permanentemente este bairro, deseja continuar");
        $("#dialog-mensagem").dialog({
                    height: 200,
                    width:400,
                    modal: true,
                    buttons:{
                        "Confirmar": function(){
                            $.get("/bairro/deletarBairro/"+id,function(data){
                                var res = jQuery.parseJSON(data);
                                if(res.success == true){
                                    $(linha).remove();
                                }else{
                                   $("#dialog-mensagem").find("p").text(res.mensagem);
                                }
                            });
                            $(this).dialog("close");
                        },
                        "Cancelar": function(){
                            $(this).dialog("close");
                        }
                    }
                });
    });
    
    content.delegate(".alterar-bairro","click",function(){
        var id = $(this).closest('tr').find(".id-bairro").val();
        alert("transformar em text e selects ou abrir uma dialog com os dados");
    });
    
});


