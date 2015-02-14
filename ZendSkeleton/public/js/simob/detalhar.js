/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(
    function(){
             $('.jcarousel').jcarousel({
        // Core configuration goes here
        });

        $('.jcarousel-pagination').jcarouselPagination({
            item: function(page) {
                return '<a href="#' + page + '">' + page + '</a>';
            }
        });
    }
);

