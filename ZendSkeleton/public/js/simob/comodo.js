/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(
        function(){
            $("#busca-submit").click(
                    function(e){
                        e.preventDefault();
                        var url,form,param;
                        form = $("#form-busca");
                        url = $(form).attr("action");
                        param = $(this).parent().find("#param").val();
                        $("#hidden-param").val(param);
                        if(param == ""){
                           $("#dialog-mensagem").find("p").text("informe um valor para a busca");
                            $("#dialog-mensagem").dialog({
                                modal: true,
                                buttons:{
                                    ok : function(){
                                        $(this).dialog('close');
                                    }
                                }
                            });
                            exit();
                        }else{
                            $.post(url,$(form).serialize(),function(data){
                                var res = jQuery.parseJSON(data);
                                if(res.success == true){
                                    if(res.haDados){//se for vazio sem dados
                                        $("#tabela-comodos").hide();
                                        $("#barra-paginacao").hide();
                                        $("#tabela-comodos").after('<h1>Nenhum registro encontrado</h1>');
                                    }else{
                                        $(".listar").find('h1').remove();
                                        $("#tabela-comodos").children('tbody').replaceWith(res.html);  
                                        $("#tabela-comodos").show();
                                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                                        $("#barra-paginacao").show();
                                    }
                                }
                            });
                        }
                    }
            );
    
            var content = $(document);//o metodo live foi descontinuado
    
            content.delegate(".proxima-pagina","click",function(){
                var url = $(this).attr('url');
                var pagina = $(this).attr('data-proxima');
                var param = $("#hidden-param").val();
                if(param.length == 0){
                        $.get(url+'/'+pagina, function(data){
                            var res = jQuery.parseJSON(data);
                            if(res.success===true){
                                $("#tabela-comodos").children('tbody').replaceWith(res.html);                
                                $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            }
                        });
                }else{
                     $.get(url+'/'+pagina+'/'+param, function(data){
                            var res = jQuery.parseJSON(data);
                            if(res.success===true){
                                $("#tabela-comodos").children('tbody').replaceWith(res.html);                
                                $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            }
                        });
                }


            });

            content.delegate(".pagina-anterior","click",function(){
               var url = $(this).attr('url');
               var pagina = $(this).attr('data-anterior');
               var param = $("#hidden-param").val();
               if(param.length == 0){
                   $.get(url+'/'+pagina, function(data){
                        var res = jQuery.parseJSON(data);
                        if(res.success === true){
                            $("#tabela-comodos").children('tbody').replaceWith(res.html);
                            $("#barra-paginacao").replaceWith(res.barrapaginacao);
                        }
                    });
               }else{
                   $.get(url+'/'+pagina+'/'+param, function(data){
                            var res = jQuery.parseJSON(data);
                            if(res.success===true){
                                $("#tabela-comodos").children('tbody').replaceWith(res.html);                
                                $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            }
                        });
               }

            });
    
});
