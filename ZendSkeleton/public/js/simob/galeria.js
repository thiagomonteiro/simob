/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){

    var idDelete;//variavel que irá guardar o id da foto que estiver sendo arrastada
    
    var content = $(document);
    content.delegate(".miniatura","mouseover",function(){
        $(this).draggable({revert:true});
        idDelete = $(this).children('input').val();// atribuindo o id da foto a variavel
    });
    
    
    
    $("#lixeira").droppable({
        drop: function(event, ui) {
            $(ui.draggable).remove();
            $.get("/imovel/removerImagem/"+idDelete,function(data){
                var res = jQuery.parseJSON(data);
            });
        }
    });
    
    
    $(".upload-file").change(
            function(e){
                e.preventDefault();
                var form = $(".upload-wrapper"); 
                var url = form.attr('action');
                $(form).ajaxSubmit({//função do plugin js/libs/jquery.form.js
                  url  : url,
                  type : 'POST',
                  success : function(data){
                    var res = jQuery.parseJSON(data);
                     if(res.success == true){
                         $("#preview").css('background-image', 'none');//remove a imagem da maquina fotografica
                         $("#preview").children("h3").remove();//remove o texto "nenhuma imagem selecionada"
                         $('#preview').children('ul').append(res.data);
                         $("#preview").children("#lixeira").show();
                     }
                  }
                });
                
            });
            
});