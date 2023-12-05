/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Dynamic Drag and Drop with jQuery and PHP
*/

$(function() {
    $('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
            $.ajax({
                url: base_url +'gallery/update_orders',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                    //finished
                    //console.log(data);
                }
            });
        }
    }); // fin sortable
});
$(function() {
    $('#sortable').sortable({
        axis: 'y',
        opacity: 0.7,
        handle: 'span',
        update: function(event, ui) {
            var list_sortable = $(this).sortable('toArray').toString();
    		// change order in the database using Ajax
            $.ajax({
                url: base_url +'gallery/update_orders',
                type: 'POST',
                data: {list_order:list_sortable},
                success: function(data) {
                    //finished
                    //console.log(data);
                }
            });
        }
    }); // fin sortable
});