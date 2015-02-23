/**
 * Created by and on 2/22/15.
 */

function receiveTicketOrder(event, ui, rthis) {


    $debugLine = "[" + rthis.id + "] received [" + ui.item.attr("id") + "]";
    $debugLine += "\n\n";
    $debugLine += $(rthis).sortable('serialize');
    alert($debugLine);

    /*alert("[" + this.id + "] received [" + ui.item.html() + "] from [" + ui.sender.attr("id") + "]");*/

    /*jQuery.ajax({
        type: 'POST',
        url: '$url',
        data: {
            key: ui.item.data('key'),
            pos: ui.item.index()
        },
        complete: function() {
            jQuery('#{$this->id}').removeClass('sorting');
        }
    });*/
}