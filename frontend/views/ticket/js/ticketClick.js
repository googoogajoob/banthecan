function ticketMove(ticketMoveUrl, event)
{
    preventBubbling(event);
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml(ticketMoveUrl, event);
    turnOnModalEvents();

    return false;
}

function preventBubbling(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    else {
        e.cancelBubble = true;
    }
}

function toggleModalFontsize() {
    element = $('#w0');
    if (element.hasClass('ticketLargeModalText')) {
        element.removeClass('ticketLargeModalText');
    } else {
        element.addClass('ticketLargeModalText');
    }

}