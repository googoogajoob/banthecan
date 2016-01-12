/**
 * Created by and on 11-Jan-16.
 */

$(document).ready(function() {
    $("#ticketSearchClear-text").click(function () {
        $("#ticketsearch-text_search").val('');
    });

    $("#ticketSearchClear-fromdate").click(function () {
        $("#ticketsearch-from_date").val('');
    });

    $("#ticketSearchClear-todate").click(function () {
        $("#ticketsearch-to_date").val('');
    });
});