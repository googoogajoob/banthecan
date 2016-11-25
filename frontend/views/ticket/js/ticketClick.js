function ticketMove(ticketMoveUrl)
{
    preventBubbling(event);
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml(ticketMoveUrl);
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
