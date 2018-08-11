function addTitleToList(ticketTitle) {
    $('#merge-title-list').append('<li>' + ticketTitle + '</li>');
}

function addHiddenIdField(ticketId) {
    mergeCandidateCount = $('#merge-form input:hidden').length - 1; //ignore csrf input
    $('#merge-form').append('<input type="hidden" name="mergeCandidateId[' + mergeCandidateCount + ']" value="' + ticketId + '"></input>');
    if (mergeCandidateCount > 0) {
        $("#merge-submit-button").show();
    } else {
        $("#merge-submit-button").hide();
    }
}

function addTicketToMerge(ticketId, ticketTitle) {
    $("#merge-block").show();
    addTitleToList(ticketTitle);
    addHiddenIdField(ticketId);
}