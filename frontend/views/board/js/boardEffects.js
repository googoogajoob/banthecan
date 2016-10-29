$(document).ready(function () {

    $('#backlog-per-page').change(function() {
        this.form.submit();
    });

    $('#completed-per-page').change(function() {
        this.form.submit();
    });

    checkForKanbanUpdate();
});

function checkForKanbanUpdate()
{
    boardTimestamp = parseInt($('#boardTimestamp').val(), 10);

    if (boardTimestamp > 0) {
        $.ajax({
            url: "/board/polling",
            type: "post",
            timeout: longPollingTimeout,
            data: {
                'boardTimestamp': boardTimestamp,
            },
        }).done(function (returnData) {
            newTimestamp = parseInt(returnData.newTimestamp);
            returnBoardTimestamp = parseInt(returnData.boardTimestamp, 10);

            // NewTimestamp checks if the server has returned an actual update
            // boardTimestamp comparison checks if this is a return from this client (???)
            if ((newTimestamp > 0) && (boardTimestamp == returnBoardTimestamp)) {
                $('.board-column' ).sortable('destroy');
                $('#kanban-row').html(returnData.html);
                $('#boardTimestamp').val(returnData.newTimestamp);
                initializeBoard();
                //console.log("Long Polling: Change");
            } else {
                console.log("Long Polling: Timeout");
            }
            checkForKanbanUpdate();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Long Polling: Error");
            checkForKanbanUpdate();
        });
    }
}
