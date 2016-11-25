function ticketClick(ticketId)
{
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml('/ticket/view/' + ticketId);
    turnOnModalEvents();

    return false;
}

function ticketMove(ticketId)
{
    preventBubbling(event);
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml('/ticket/move/' + ticketId);
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
