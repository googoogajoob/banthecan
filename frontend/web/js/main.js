$(document).ready(function() {
    $('#global-modal-container').on('show.bs.modal', function (event) {
        sourceUrl = $(event.relatedTarget).attr('href');
        getGlobalModalHtml(sourceUrl);
    });
});

function getGlobalModalHtml(url) {
    $.ajax({
        url: url,
        type: "post",
        success: function(returnData) {
            $('#global-modal-container .modal-body').html(returnData);
            //alert('success');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('Error loading Global Modal Container: ' + textStatus + ':' + errorThrown);
        }
    });
}