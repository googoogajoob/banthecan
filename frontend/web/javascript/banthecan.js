/**
 * Created by and on 2/22/15.
 */

function receiveTicketOrder(event, ui, rthis) {

    /*$debugLine = "[" + rthis.id + "] received [" + ui.item.attr("id") + "]";
    $debugLine += "\n\n";
    $debugLine += $(rthis).sortable('serialize');
    alert($debugLine);*/

    var list =  $(rthis).sortable("toArray").join("|");
    $.ajax({
        url: "index.php?r=ticket/reorder",
        type: "post",
        data: {
                'section':rthis.id,
                'components': list
            },
        success: function(){
            //alert("success");
            /*$("#result").html('Submitted successfully');*/
        },
        error:function(){
            alert("failure");
            /*$("#result").html('There is error while submit');*/
        }
    });
}

function reorderElementsResponse( data ) {
    if (data.FAIL === undefined) // Everything's cool!
    {
        alert( data.resultString + data.itemIndexString );
    }
    else
    {
        alert( "Bad Clams!" );
    }
}