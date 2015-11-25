/**
 * Created by and on 20/11/15.
 */

function toggleRightSidebar() {
    currentStateVisible = $('#right-layout-sidebar').is(':visible');

    if (currentStateVisible) {
        $('#right-layout-sidebar').hide();
        $('#layout-main').animate({
                'margin-right': '0'
            },
            "fast"
        );
        $('#toggle-right-sidebar').removeClass('glyphicon-circle-arrow-right').addClass('glyphicon-circle-arrow-left');
    } else {
        $('#layout-main').animate({
                'margin-right': '200'
            },
            "fast",
            function () {
                $('#right-layout-sidebar').show();
            }
        );
        $('#toggle-right-sidebar').removeClass('glyphicon-circle-arrow-left').addClass('glyphicon-circle-arrow-right');
    }

    return true;
}

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

function changeBacklogPageSize() {
    $('#backlog-search-per-page').val(
        $('#backlog-per-page').val()
    );

    $('#backlog-search-submit').submit();
}

$(document).ready(function () {

    $('#toggle-right-sidebar').click(function() {
        return toggleRightSidebar();
    });

    $('#toggle-left-sidebar').click(function() {
        return toggleLeftSidebar();
    });

    $('#backlog-per-page').change(function() {
        changeBacklogPageSize();
    });

    $('#completed-per-page').change(function() {
        this.form.submit();
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});
