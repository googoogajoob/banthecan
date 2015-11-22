$(document).ready(function() {
    $('#header-create-button').click(function() {
        $('#create-ticket-modal').modal('show')
            .find('#create-ticket-modal-content')
            .load($(this).attr('value'));
    });
});