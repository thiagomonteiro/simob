$(document).ready(function(){
    var content = $(document);//o metodo live foi descontinuado
    content.delegate(".uf-select","change",function(){
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
    
    content.delegate(".categoria-select","change",function(){
        var categoria = $(".categoria-select option:selected").val();
        $.get("/imovel/getSubCategorias/"+categoria, function(data){
           var res = jQuery.parseJSON(data);
           if(res.success == true){
               $(".sub-categoria-select").replaceWith(res.select);
           }
        });
    });
    
    $(".btn-proprietario").click(
            function(){
                $("#caixa-busca").dialog({
                    height: 250,
                    width:550,
                    title:"Localizar proprietário",
                    modal: true
                });
            }
     );
     
     var dialogoBusca = $("#dialog-mensagem");
     $(dialogoBusca).dialog({
                            modal: true,
                            autoOpen: false,
                            buttons:{
                                ok : function(){
                                    $(this).dialog('close');
                                }
                            }
                         });
     
     $("#busca-proprietario").click(
             function(e){
                    e.preventDefault();
                    var form = $("#form-busca"); 
                    var rota = form.attr('action');
                    var filtro = $("#filtro option:selected").text();
                    if(filtro == "selecione"){
                        $(dialogoBusca).find("p").text("selecione um filtro");
                        $(dialogoBusca).dialog( "open");
                        exit();
                    }
                    if(filtro == "cpf" || filtro == "nome"){
                        $("#hidden-filtro").val(filtro);
                    }
                    if($("#param").val()==""){
                        $(dialogoBusca).find("p").text("informe um valor para a busca");
                        $(dialogoBusca).dialog( "open");
                         exit();
                    }else{
                        $("#hidden-param").val($("#param").val());
                    }
                    
                    $.post( rota+'/selecao', $(form).serialize(),function(data){
                    var res = jQuery.parseJSON(data);
                    if(res.success == true){
                        if(res.haDados){
                            $("#tabela-proprietarios").parent().find('h5').remove();
                            $("#tabela-proprietarios").children('tbody').replaceWith(res.html);  
                            $("#tabela-proprietarios").show();
                            $("#barra-paginacao").remove();
                            $("#tabela-proprietarios").after(res.barrapaginacao);
                        }else{
                            $("#tabela-proprietarios").hide();
                            $("#barra-paginacao").hide();
                            $("#tabela-proprietarios").next('h5').remove();
                            $("#tabela-proprietarios").after('<h5>Nenhum registro encontrado</h5>');
                        }
                    }
                });
             });
             
             
             content.delegate(".proxima-pagina","click",function(){
                var url = $(this).attr('url');
                var pagina = $(this).attr('data-proxima');
                var filtro = $("#hidden-filtro").val();
                var param = $("#hidden-param").val();
                if(filtro.length == 0){
                        $.get(url+'/'+pagina, function(data){
                            var res = jQuery.parseJSON(data);
                            if(res.success===true){
                                $("#tabela-proprietarios").children('tbody').replaceWith(res.html);                
                                $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            }
                        });
                }else{
                     $.get(url+'/selecao/'+pagina+'/'+filtro+'/'+param, function(data){
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
                   $.get(url+'/'+pagina, function(data){
                        var res = jQuery.parseJSON(data);
                        if(res.success === true){
                            $("#tabela-proprietarios").children('tbody').replaceWith(res.html);
                            $("#barra-paginacao").replaceWith(res.barrapaginacao);
                        }
                    });
               }else{
                   $.get(url+'/selecao/'+pagina+'/'+filtro+'/'+param, function(data){
                            var res = jQuery.parseJSON(data);
                            if(res.success===true){
                                $("#tabela-proprietarios").children('tbody').replaceWith(res.html);                
                                $("#barra-paginacao").replaceWith(res.barrapaginacao);
                            }
                        });
               }
            });
            
            content.delegate(".selecionar-proprietario", "click", function(){
                var linha = $(this).closest('tr');
                var id = $(linha).find(".id-proprietario").val();
                var nome = $(linha).find(".nome").text();
                $(".txt-proprietario").val($.trim(nome));
                $(".id-proprietario").val(id);
                $(".ui-dialog-titlebar-close").click();
            });
            
            
            $("#passo2-submit").click(function(){
                    
                        
            });
        });


