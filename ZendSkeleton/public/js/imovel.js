/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() { 
    $("#uf").change(function(){
        var uf = $("#uf option:selected").text();
        $.get("/imovel/getCidades/"+uf,function(data){
            alert(data);
        });
    });
});


