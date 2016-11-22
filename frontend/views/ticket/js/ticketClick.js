function ticketClick(ticketId)
{
    $('#global-modal-container').off('show.bs.modal');
    $('#global-modal-container').modal({
        keyboard: false
    });
    getGlobalModalHtml('/ticket/view/' + ticketId);
}

function preventBubbling(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    else {
        e.cancelBubble = true;
    }
}
