/**
 * Created by and on 4-May-15.
 */

function ticketDetailView(id) {

    $('#ajax-loader').removeClass('hidden').addClass('show');
    $.ajax({
        url: '/ticket/view',
        type: "get",
        data: {
            'id': id
        },
        success: function(returnData) {
            $('#ajax-loader').removeClass('show').addClass('hidden');
            $('#right-layout-sidebar .container-fluid').html(returnData.ticketViewHtml);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#ajax-loader').removeClass('show').addClass('hidden');
            alert("Ticket View Failure: " + textStatus + ': ' + errorThrown);
        }
    });
}
