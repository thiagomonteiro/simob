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
    
     content.delegate(".uf-select","change",function(){
        //e.preventDefault();
        var uf = $(".uf-select option:selected").text();
        $.get("/bairro/getCidades/"+uf,function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $(".uf-select").closest('section').find(".cidade-select").replaceWith(res.cidades);//o uf select e o uf cidade da view criar precisam estar dentro de uma section 
            }
        });
    });
    /*******************************************criar***********************/
    
    
    /******************************************alterar**************************/
     content.delegate(".uf-upd-select","change",function(){
        //e.preventDefault();
        var uf = $(".uf-upd-select option:selected").text();
        $.get("/bairro/getCidades/"+uf,function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $(".uf-upd-select").closest('section').find(".cidade-select").replaceWith(res.cidades);//o uf select e o uf cidade da view criar precisam estar dentro de uma section 
            }
        });
    });
    /*********************************************alterar***********************/
    
    
    /************************************busca********************************/
    //'EXIBIR UMA MODAL PARA SELECIONAR A CIDADE. A CIDADE SELECIONADA SERA COLOCADO DENTRO DO CAMPOS PARAMETRO QUE FICARÁ DESATIVADO PARA EDICAO SO SENDO REABILITADO CASO O USUARIO SELECIONE O CAMPO NOME'
    $("#filtro").change(
            function(){
                var filtro = $("#filtro option:selected").text();
                $("#hidden-filtro").val(filtro);
                if(filtro == "cidade"){
                    $(function() {
                        $( "#dialog-busca").dialog({
                          height: 200,
                          width:400,
                          modal: true,
                          buttons: {
                            "Selecionar": function () {
                                var cidade = $(this).find(".cidade-select option:selected");//aki e tive que especificar o seletor pai do select cidade para evitar o coflito com o select cidade do form alterar
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
                }
                if(filtro == "nome"){
                    var param = $("#param").val();
                    $("#hidden-param").val(param);
                }
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
                }
                $.post( rota, $(form).serialize(),function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success == true){
                        if(res.haDados){//se for vazio sem dados
                            $("#tabela-bairros").hide();
                            $("#barra-paginacao").hide();
                            $("#tabela-bairros").after('<h1>Nenhum registro encontrado</h1>');
                        }else{
                            $(".listar").find('h1').remove();
                            $("#tabela-bairros").children('tbody').replaceWith(res.html);  
                            $("#tabela-bairros").show();
                            $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            $("#barra-paginacao").show();
                        }
                    }
                });
            }
    );
    
    
    
    /*******************************alterar*************************/
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
        $(this).closest('tr').addClass('tr-edit');        
        var id = $(this).closest('tr').find('.id-bairro').val();
        $.get("/bairro/alterarBairro",function(data){//recupero o formulario
            var res = jQuery.parseJSON(data);
            if(res.success == true){
               var form=res.html;
               $("#dialog-mensagem").find('p').replaceWith(form);//adiciono o formulairo a minha dialog
               $("#dialog-mensagem").find(".upd-id").val(id);//seto o id
                $("#dialog-mensagem").dialog({
                            height: 250,
                            width:400,
                            modal: true,
                            buttons:{
                                Salvar:function(){
                                    $.post("/bairro/salvarAlteracoes",$("#dialog-mensagem").find("#form-alterar-bairro").serialize(),function(data){
                                         var res = jQuery.parseJSON(data);
                                         if(res.success==true){                       
                                             $(".tr-edit").find(".nome").text(res.nome);
                                             $(".tr-edit").find(".cidade").text(res.cidade);
                                             $(".tr-edit").find(".estado").text(res.estado);
                                             $("#dialog-mensagem").dialog('close');
                                         }else{
                                             exibir_erros(res.erros,$("#dialog-mensagem").find("#form-alterar-bairro"));//passo o formulario por referencia para a funcao exibir_erros
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
    
    
     content.delegate(".uf-select-update","change",function(){
     });
    
   
    //////////////////////////**********alterar**********//////////////////
});




