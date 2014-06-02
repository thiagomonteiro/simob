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
            
  /*******************************deletar/alterar*************************/
    content.delegate(".deletar","click",function(){
        var linha = $(this).closest('tr');
        var id = $(this).closest('tr').find(".id-comodo").val();//retorna o elemento mais proximo
        $("#dialog-mensagem").find("p").html("Você esta prestes a excluir permanentemente este tipo de comodo, deseja continuar");
        $("#dialog-mensagem").dialog({
                    height: 200,
                    width:400,
                    modal: true,
                    buttons:{
                        "Confirmar": function(){
                            $.get("/comodo/deletar/"+id,function(data){
                                var res = jQuery.parseJSON(data);
                                if(res.success == true){
                                    $(linha).remove();
                                    notif({
                                        msg: res.menssagem,
                                        type: 'success',
                                        width: "all",
                                        opacity: 0.8,
                                        position: "center",
                                    });
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
    
   
    content.delegate(".alterar","click",function(){
        $(this).closest('tr').addClass('tr-edit');        
        var id = $(this).closest('tr').find('.id-comodo').val();
        $.get("/comodo/alterar",function(data){//recupero o formulario
            var res = jQuery.parseJSON(data);
            if(res.success == true){
               var form=res.html;
               $("#dialog-mensagem").find('p').html(form);//adiciono o formulairo a minha dialog
               $("#dialog-mensagem").find(".upd-id").val(id);//seto o id
                $("#dialog-mensagem").dialog({
                            height: 250,
                            width:400,
                            modal: true,
                            buttons:{
                                Salvar:function(){
                                    $.post("/comodo/salvarAlteracoes",$(this).find("#form-alterar").serialize(),function(data){
                                         var res = jQuery.parseJSON(data);
                                         if(res.success==true){                  
                                             var descricao = $('input[name="descricao"]').val();
                                             $(".tr-edit").find(".descricao").text(descricao);
                                             $("#dialog-mensagem").dialog('close');
                                             notif({
                                                  msg: res.menssagem,
                                                  type: 'success',
                                                  width: "all",
                                                  opacity: 0.8,
                                                  position: "center",
                                              });
                                         }else{
                                             exibir_erros(res.erros,$("#dialog-mensagem").find("#form-alterar"));//passo o formulario por referencia para a funcao exibir_erros
                                         }
                                    });
                                    
                                },
                                Cancelar:function(){
                                    $("#dialog-mensagem").dialog("close");    
                                }
                            }
                        });
                    }
                });
    });
    //////////////////////////**********deletar/alterar**********//////////////////

    
});
