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
    
    $("#btn-proprietario").click(
            function(){
                $("#caixa-busca").dialog({
                    height: 250,
                    width:550,
                    title:"Localizar proprietário",
                    modal: true
                });
            }
     );
     
     
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
                    
                    $.post( rota, $(form).serialize(),function(data){
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
             });
        });


