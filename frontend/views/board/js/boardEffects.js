var pollingRequests;
var showConsoleDebug = false;

$(document).ready(function () {

    pollingRequests = 0;

    if (!showConsoleDebug)
    {
        console.warn('Console Debug Messages Disabled');
    } else {
        console.log('Console Debug Messages Enabled');
    }

    $(document.body).on('change', '#backlog-per-page', function() {
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
        ajaxCookie = getColumnCookies();

        if (showConsoleDebug) {
            console.log('%c Long Polling: Start (send ajax request)', 'background: #a0a0a0;');
            console.log('- boardTimestamp: ' + boardTimestamp);
            console.log('- polling requests: ' + pollingRequests);
            console.dir(ajaxCookie);
        }

        $.ajax({
            url: "/board/polling",
            type: "post",
            timeout: longPollingTimeout,
            data: {
                'boardTimestamp': boardTimestamp,
                'ajaxCookie': JSON.stringify(ajaxCookie),
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
                initializeColumnCollapse();
                synchronizeCollapseStatusToCookie();

                if (showConsoleDebug) {
                    console.info("Long Polling: Change");
                    console.log('- newTimestamp: ' + newTimestamp);
                    console.log('- boardTimestamp: ' + boardTimestamp);
                    console.log('- returnBoardTimestamp: ' + returnBoardTimestamp);
                    console.log('- polling requests: ' + pollingRequests);
                    console.log('- counterLimit    : ' + returnData.counterLimit);
                    console.log('- counter         : ' + returnData.counter);
                }

            } else {

                if (showConsoleDebug) {
                    console.warn("Long Polling: Bad Data");
                    console.log('- newTimestamp: ' + newTimestamp);
                    console.log('- boardTimestamp: ' + boardTimestamp);
                    console.log('- returnBoardTimestamp: ' + returnBoardTimestamp);
                    console.log('- polling requests: ' + pollingRequests);
                }

            }

            checkForKanbanUpdate();

        }).fail(function (jqXHR, textStatus, errorThrown) {
            pollingRequests--;

            if (showConsoleDebug) {
                var time = new Date();
                formattedTime =
                    ("0" + time.getHours()).slice(-2) + ":" +
                    ("0" + time.getMinutes()).slice(-2) + ":" +
                    ("0" + time.getSeconds()).slice(-2);

                console.warn('Long Polling: Fail');
                console.log('- time: ' + formattedTime);
                console.log('- status: ' + textStatus);
                console.log('- error: ' + errorThrown);
                console.log('- polling requests: ' + pollingRequests);
            }

            checkForKanbanUpdate();
        });
    }
}

function getColumnCookies()
{
    var columnCookies = {};

    $('.panel-collapse').each( function(index, element){
        columnId = $(this).attr('id');
        cookieValue = getCookie(columnId);
        if (cookieValue) {
            columnCookies[columnId] = cookieValue;
        }
    });

    return columnCookies;
}

function synchronizeCollapseStatusToCookie()
{
    columnCookies = getColumnCookies();
    for(var k in columnCookies) {
        if (columnCookies[k] == 1) {
            $('#' + k).collapse('show');
            if (showConsoleDebug) {
                console.log('Show: ' + k);
            }
        } else {
            $('#' + k).collapse('hide');
            if (showConsoleDebug) {
                console.log('Close: ' + k);
            }
        }
    }
}

function initializeColumnCollapse()
{
    $('.apc-col-btn').siblings('.panel-collapse').on('shown.bs.collapse', function() {
        columnNumber = this.id;
        setCookie(columnNumber, 1, 365);

        if (showConsoleDebug) {
            console.log('Column shown ' + columnNumber);
        }
    });

    $('.apc-col-btn').siblings('.panel-collapse').on('hidden.bs.collapse', function() {
        columnNumber = this.id;
        setCookie(columnNumber, 0, 365);

        if (showConsoleDebug) {
            console.log('Column hidden ' + columnNumber);
        }
    });
}