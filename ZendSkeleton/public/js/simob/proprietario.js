/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    var content = $(document);//o metodo live foi descontinuado
    mascarar();
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
    
     content.delegate(".proxima-pagina","click",function(){
        var url = $(this).attr('url');
        var pagina = $(this).attr('data-proxima');
        var filtro = $("#hidden-filtro").val();
        var param = $("#hidden-param").val();
        if(filtro.length == 0){
                $.get(url+'/default/'+pagina, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-proprietarios").children('tbody').replaceWith(res.html);                
                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                    }
                });
        }else{
             $.get(url+'/default/'+pagina+'/'+filtro+'/'+param, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-proprietarios").children('tbody').replaceWith(res.html);                
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
           $.get(url+'/default/'+pagina, function(data){
                var res = jQuery.parseJSON(data);
                if(res.success === true){
                    $("#tabela-proprietarios").children('tbody').replaceWith(res.html);
                    $("#barra-paginacao").replaceWith(res.barrapaginacao);
                }
            });
       }else{
           $.get(url+'/default/'+pagina+'/'+filtro+'/'+param, function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success===true){
                        $("#tabela-proprietarios").children('tbody').replaceWith(res.html);                
                        $("#barra-paginacao").replaceWith(res.barrapaginacao);
                    }
                });
       }
    });
    
    
    /* busca */
    $("#busca-proprietario").click(     
            function(e){
                e.preventDefault();
                var form = $("#form-busca"); 
                var rota = form.attr('action');
                var filtro = $("#filtro option:selected").text();
                if(filtro == "selecione"){
                    $("#dialog-mensagem").find("p").text("selecione um filtro");
                    $("#dialog-mensagem").dialog({
                        modal: true,
                        buttons:{
                            ok : function(){
                                $(this).dialog('close');
                            }
                        }
                    });
                    exit();
                }
                if(filtro == "cpf" || filtro == "nome"){
                    $("#hidden-filtro").val(filtro);
                }
                if($("#param").val()==""){
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
                    $("#hidden-param").val($("#param").val());
                }
                
                $.post( rota+'/default', $(form).serialize(),function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success == true){
                        if(res.haDados){
                            $(".listar").find('h1').remove();
                            $("#tabela-proprietarios").children('tbody').replaceWith(res.html);  
                            $("#tabela-proprietarios").show();
                            $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            $("#barra-paginacao").show();
                        }else{
                            $("#tabela-proprietarios").hide();
                            $("#barra-paginacao").hide();
                            $("#tabela-proprietarios").next('h1').remove();
                            $("#tabela-proprietarios").after('<h1>Nenhum registro encontrado</h1>');
                        }
                    }
                });
            }
    );
    
    content.delegate(".deletar-proprietario","click",function(){
        var linha = $(this).closest('tr');
        var id = $(this).closest('tr').find(".id-proprietario").val();//retorna o elemento mais proximo
        $("#dialog-mensagem").find("p").html("Você esta prestes a excluir permanentemente este proprietário, deseja continuar?");
        $("#dialog-mensagem").dialog({
                    height: 200,
                    width:400,
                    modal: true,
                    buttons:{
                        "Confirmar": function(){
                            $.get("/proprietario/deletar/"+id,function(data){
                                var res = jQuery.parseJSON(data);
                                if(res.success == true){
                                    $(linha).remove();
                                    notif({
                                        msg: res.mensagem,
                                        type: 'success',
                                        width: "all",
                                        opacity: 0.8,
                                        position: "center",
                                    });
                                }else{
                                   notif({
                                        msg: res.mensagem,
                                        type: 'error',
                                        width: "all",
                                        opacity: 0.8,
                                        position: "center",
                                    });
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
    
   
    content.delegate(".alterar-proprietario","click",function(){
        $(this).closest('tr').addClass('tr-edit');        
        var id = $(this).closest('tr').find('.id-proprietario').val();
        $.get("/proprietario/alterar/"+id,function(data){//recupero o formulario
            var res = jQuery.parseJSON(data);
            if(res.success == true){
               var form=res.html;
               $("#dialog-mensagem").find('p').html(form);//adiciono o formulairo a minha dialog
                $("#dialog-mensagem").dialog({
                            height: 250,
                            width:400,
                            modal: true,
                            buttons:{
                                Salvar:function(){
                                    $.post("/proprietario/salvarAlteracoes",$(this).find("#form-alterar").serialize(),function(data){
                                         var res = jQuery.parseJSON(data);
                                         if(res.success==true){                  
                                             var nome = $('input[name="nome"]').val();
                                             var cpf = $('input[name="cpf"]').val();
                                             $(".tr-edit").find(".nome").text(nome);
                                             $(".tr-edit").find(".CPF").text(cpf);
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
    
    
});

function mascarar(){
    if($(".cpf").length){
        $(".cpf").mask("999.999.999-99",{placeholder : "_"});
    }
    if($(".telefone").length){
        $(".telefone").mask("(99)9999-9999");
    }
    if($(".celular").length){
        $(".celular").mask("(99)99999-9999");
    }
    
}
