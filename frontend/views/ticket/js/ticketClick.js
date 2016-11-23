function ticketClick(ticketId)
{
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml('/ticket/view/' + ticketId);
    turnOnModalEvents();
}

function ticketMove(ticketId)
{
    turnOffModalEvents();
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml('/ticket/move/' + ticketId);
    turnOnModalEvents();
}

function preventBubbling(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    else {
        e.cancelBubble = true;
    }
}
