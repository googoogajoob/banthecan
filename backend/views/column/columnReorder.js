/**
 * Created by and on 4/28/2015.
 */

function columnOrder(event, ui, rthis) {

    var displayOrder =  $(rthis).sortable("toArray");

    for (i = 0; i < displayOrder.length; i++) {
        displayOrder[i] = displayOrder[i].split("_")[1];
    }

    $.ajax({
        url: "/column/reorder",
        type: "post",
        data: {
            'displayOrder': displayOrder
        },
        /*success: function(){
         alert("Column Order Update SUCCESS");
        },*/
        error: function(jqXHR, textStatus, errorThrown){
            alert("Column Order Update Failure:" + textStatus + ':' + errorThrown);
        }
    });
}

jQuery("#sort > tbody").on("sortupdate", function (event, ui) {
    columnOrder(event, ui, this);
});

var fixHelper = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

jQuery("#sort > tbody").sortable({helper: fixHelper}).disableSelection();