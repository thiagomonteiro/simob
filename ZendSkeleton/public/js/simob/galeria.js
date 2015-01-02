/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){

    var idMiniatura;//variavel que irá guardar o id da foto que estiver sendo arrastada
    
    var content = $(document);
    content.delegate(".miniatura","mouseenter",function(){
        $(this).draggable({revert:true});
        idMiniatura = $(this).children('input').val();// atribuindo o id da foto a variavel
    });
    
    
    $("#lixeira").droppable({
        drop: function(event, ui) {
            $(ui.draggable).remove();
            $.get("/imovel/removerImagem/"+idMiniatura,function(data){
                window.location.reload();
            });
        }
    });
    
    $("#capa").droppable({
       drop : function(event, ui){
           $(ui.draggable).draggable({revert:false});
           $.post("/imovel/selecionarCapa/"+idMiniatura,function(data){
               var res = jQuery.parseJSON(data)
                   if(res.success){
                       window.location.reload();
                   }
           });
       } 
    });
    
    content.delegate(".nome-miniatura","keydown",function(e){
        var keyCode = e.keyCode || e.which;
         if (keyCode == 13 || keyCode == 9) {
            if($(this).val() != $(this).attr('nome')){
                 var id = $(this).parent().children("input:hidden").val(); 
                 var nome = replaceAll($(this).val(),' ','-');
                 $.post("/imovel/alterarImagem/"+id+"/"+nome,function(data){
                     var res = jQuery.parseJSON(data);
                     if(res.success){
                             notif({
                             msg: res.mensagem,
                             type: 'info',
                             width: 150,                        
                             opacity: 0.8,
                             position: "right",
                             multiline: true,
                         });
                     } 
                 });
                $(this).attr('nome',$(this).val());
             }  
         }
    });
    
    $(".upload-file").change(
            function(e){
                e.preventDefault();
                var fileCount = this.files.length;
                $("#contador").val(fileCount);//quantidade de arquivos sendo enviados sendo setado num input oculto para poder ser processado no servidor resultado na quantidade total de imagens
                var $fileUpload = $("input[type='file']");
                var form = $(".upload-wrapper"); 
                var url = form.attr('action');
                $(form).ajaxSubmit({//função do plugin js/libs/jquery.form.js
                  url  : url,
                  type : 'POST',
                  success : function(data){
                    var res = jQuery.parseJSON(data);
                     if(res.success == true){
                         window.location.reload();
                     }else{
                            notif({
                            msg: res.mensagem,
                            width: "all",
                            type: "warning",                     
                            position: "center",
                            multiline: true,
                        });
                     }
                  }
                });
                
            });        
});
function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}