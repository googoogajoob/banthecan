function ticketClick(ticketId)
{
    if (typeof blockTicketView === 'undefined') {
        status = 0;
    } else {
        status = 1;
    }

    if (status == 0) {
        location.href = "/ticket/view/" + ticketId;
    }
}
