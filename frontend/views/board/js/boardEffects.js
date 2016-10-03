function toggleLeftSidebar() {
    currentStateVisible = $('#left-layout-sidebar').is(':visible');

    if (currentStateVisible) {
        $('#left-layout-sidebar').hide();
        $('#layout-main').animate({
                'margin-left': '0'
            },
            "fast"
        );
        $('#toggle-left-sidebar').removeClass('glyphicon-circle-arrow-left').addClass('glyphicon-circle-arrow-right');
    } else {
        $('#layout-main').animate({
                'margin-left': '200'
            },
            "fast",
            function () {
                $('#left-layout-sidebar').show();
            }
        );
        $('#toggle-left-sidebar').removeClass('glyphicon-circle-arrow-right').addClass('glyphicon-circle-arrow-left');
    }

    return true;
}

$(document).ready(function () {

    $('#toggle-left-sidebar').click(function() {
        return toggleLeftSidebar();
    });

    $('#backlog-per-page').change(function() {
        this.form.submit();
    });

    $('#completed-per-page').change(function() {
        this.form.submit();
    });

    $('[data-toggle="tooltip"]').tooltip();

    checkForKanbanUpdate();
});

function checkForKanbanUpdate()
{
    boardTimestamp = parseInt($('#boardTimestamp').val(), 10);

    if (boardTimestamp > 0) {
        $.ajax({
            url: "/board/polling",
            type: "post",
            timeout: 300000,
            data: {
                'boardTimestamp': boardTimestamp,
            },
        }).done(function (returnData) {
            newTimestamp = parseInt(returnData.newTimestamp);
            if (newTimestamp > 0) {
                $('#kanban-row').html(returnData.html);
                $('#boardTimestamp').val(returnData.newTimestamp);
            }
            checkForKanbanUpdate();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log("Long Polling Error");
            checkForKanbanUpdate();
        });
    }
}
