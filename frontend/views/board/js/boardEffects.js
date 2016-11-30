var pollingRequests;

$(document).ready(function () {

    pollingRequests = 0;

    $('#backlog-per-page').change(function() {
        this.form.submit();
    });

    $('#completed-per-page').change(function() {
        this.form.submit();
    });

    initializeColumnCollapse();

    checkForKanbanUpdate();
});

function checkForKanbanUpdate()
{
    boardTimestamp = parseInt($('#boardTimestamp').val(), 10);

    if (boardTimestamp > 0) {
        pollingRequests++;
        $.ajax({
            url: "/board/polling",
            type: "post",
            timeout: longPollingTimeout,
            data: {
                'boardTimestamp': boardTimestamp,
                'ajaxCookie': JSON.stringify(getColumnCookies()),
            },
        }).done(function (returnData) {
            pollingRequests--;
            newTimestamp = parseInt(returnData.newTimestamp);
            returnBoardTimestamp = parseInt(returnData.boardTimestamp, 10);

            // NewTimestamp checks if the server has returned an actual update
            // boardTimestamp comparison checks if this is a return from this client (???)
            if ((newTimestamp > 0) && (boardTimestamp == returnBoardTimestamp)) {
                $('.board-column' ).sortable('destroy');
                $('#kanban-row').html(returnData.html);
                $('#boardTimestamp').val(returnData.newTimestamp);
                initializeBoard();
                console.log("Long Polling: Change");
                pollingDebug(returnData.debugData)
            } else {
                console.log("Long Polling: Bad Data");
            }
            checkForKanbanUpdate();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            pollingRequests--;
            var time = new Date();
            formattedTime =
                ("0" + time.getHours()).slice(-2)   + ":" +
                ("0" + time.getMinutes()).slice(-2) + ":" +
                ("0" + time.getSeconds()).slice(-2);
            console.log("Long Polling: Fail " + formattedTime);
            console.log('- polling requests: ' + pollingRequests);
            checkForKanbanUpdate();
        });
    }
}

function getColumnCookies()
{
    var columnCookies = {};

    $('.panel-collapse').each( function(index, element){
        columnId = $(this).attr('id');
        //console.log( columnId + ':' + getCookie(columnId));
        columnCookies[columnId] = getCookie(columnId);
    });

    return columnCookies;
}

function pollingDebug(debugData)
{
    console.log('- boardTimestamp  : ' + formatUnixTimestamp(debugData.boardTimestamp));
    console.log('- counterLimit    : ' + debugData.counterLimit);
    console.log('- counter         : ' + debugData.counter);
    console.log('- polling requests: ' + pollingRequests);
}

function formatUnixTimestamp(unixTimestamp)
{
    var date = new Date(unixTimestamp*1000);
    var hours = date.getHours();
    var minutes = "0" + date.getMinutes();
    var seconds = "0" + date.getSeconds();

    return formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
}

function initializeColumnCollapse()
{
    $('.apc-col-btn').siblings('.panel-collapse').on('shown.bs.collapse', function() {
        columnNumber = this.id;
        console.log('Column shown ' + columnNumber);
        setCookie(columnNumber, 1, 365);
    });

    $('.apc-col-btn').siblings('.panel-collapse').on('hidden.bs.collapse', function() {
        columnNumber = this.id;
        console.log('Column hidden ' + columnNumber);
        setCookie(columnNumber, 0, 365);
    });
}