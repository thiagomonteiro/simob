/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    
    $("#uf-select").change(function(e){
        e.preventDefault();
        var uf = $("#uf-select option:selected").text();
        $.get("/imovel/getCidades/"+uf,function(data){
            var res = jQuery.parseJSON(data);
            if(res.success == true){
                $("#cidade-select").replaceWith(res.cidades);
            }
        });
    });
    
    
   $("#form-criar-bairro").submit(function(ev) {
        ev.preventDefault();
        var form = $(this);
        alert(form.attr('action'));  
  });
});


