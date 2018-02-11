function setTargetBoard(thisButton) {
    boardFilterId = $('#columnsearch-board_id').val();
    if (boardFilterId > 0) {
        originalUrl = $(thisButton).attr('href');
        newUrl = originalUrl.replace(/[0-9]*$/, boardFilterId);
        window.location.href = newUrl;
        return false;
    }
}