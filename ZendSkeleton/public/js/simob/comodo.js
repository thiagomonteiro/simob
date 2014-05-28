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
                            $.post(url,$(form).serialize,function(data){
                                var res = jQuery.parseJSON(data);
                                alert('ok');
                            });
                        }
                    }
            );
        }
);
