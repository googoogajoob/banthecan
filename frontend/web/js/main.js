$(document).ready(function() {
    $('#global-modal-container').on('show.bs.modal', function (event) {
        sourceUrl = $(event.relatedTarget).attr('href');
        getGlobalModalHtml(sourceUrl);
        $('.tooltip').hide();
    });
    disableTooltip();
});

function getGlobalModalHtml(url) {
    $.ajax({
        url: url,
        type: "post",

        success: function(returnData) {

            $('#global-modal-container .modal-body').html(returnData);
            headerHtml = $('#global-modal-container .modal-body .apc-modal-header')[0].outerHTML;
            $('#global-modal-container .modal-body .apc-modal-header').remove();
            $('#global-modal-container .modal-header .apc-modal-header').remove();
            $('#global-modal-container .modal-header').prepend(headerHtml);

            //alert('success');
        },

        error: function(jqXHR, textStatus, errorThrown){
            alert('Error loading Global Modal Container: ' + textStatus + ':' + errorThrown);
        }

    });
}

function getBootstrapEnvironment() {
    var envs = ['xs', 'sm', 'md', 'lg'];

    var $el = $('<div>');
    $el.appendTo($('body'));

    for (var i = envs.length - 1; i >= 0; i--) {
        var env = envs[i];

        $el.addClass('hidden-'+env);
        if ($el.is(':hidden')) {
            $el.remove();
            return env;
        }
    }
}

function disableTooltip() {
    environment = getBootstrapEnvironment();

    if (environment != 'lg') {
        $('[data-toggle="tooltip"]').tooltip('disable');
    }

}