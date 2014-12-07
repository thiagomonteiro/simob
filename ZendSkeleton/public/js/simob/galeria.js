/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $(".upload-file").change(
            function(e){
                e.preventDefault();
                var form = $(".upload-wrapper"); 
                var url = form.attr('action');
                $(form).ajaxSubmit({//função do plugin js/libs/jquery.form.js
                  url  : url,
                  type : 'POST',
                  success : function(msg){
                      
                  }
                });
                
                $("#preview").css('background-image', 'none');//remove a imagem da maquina fotografica
                $("#preview").children("h3").remove();//remove o texto "nenhuma imagem selecionada"
                for (var i = 0; i < $(this).get(0).files.length; ++i) {
                  var Leitor = new FileReader();
                  Leitor.readAsDataURL(this.files[i]);
                  Leitor.onload = function (oFREvent) {
                        $('#preview').children('ul').append('<li><img src="'+oFREvent.target.result+'"><button class="delete-default">Remover</button><input type="text" placeholder="Renomear Imagem"></li>');
                  };
                }
            });
            
});