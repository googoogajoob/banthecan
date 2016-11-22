function ticketClick(ticketId)
{
    location.href = "/ticket/view/" + ticketId;
}

function preventBubbling(e) {
    if (e.stopPropagation) {
        e.stopPropagation();
    }
    else {
        e.cancelBubble = true;
    }
}
