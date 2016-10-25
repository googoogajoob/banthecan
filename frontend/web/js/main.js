$(document).ready(function() {

    $('#global-modal-container').on('show.bs.modal', function (event) {
        sourceUrl = $(event.relatedTarget).attr('href');
        getGlobalModalHtml(sourceUrl);
        $('.tooltip').hide();
    });

    buttonHtml = $('#modal-close-button')[0].outerHTML;
    $('#modal-close-button').remove();
    $('#modal-header-row').prepend(buttonHtml);

    $('#left-sidebar').on('show.bs.collapse', function () {
        $('#left-layout-main').removeClass();
        $('#left-layout-main').addClass('col-xs-6 col-sm-8 col-lg-10');
        $('#show-search-option-button').addClass('hidden');
        $('#hide-search-option-button').removeClass('hidden');
        $.setCookie('search-block', 'open');
    });

    $('#left-sidebar').on('hide.bs.collapse', function () {
        $('#left-layout-main').removeClass();
        $('#left-layout-main').addClass('col-xs-12');
        $('#hide-search-option-button').addClass('hidden');
        $('#show-search-option-button').removeClass('hidden');
        $.setCookie('search-block', 'closed');
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
            $('#modal-header-row').prepend(headerHtml);
            $('#modal-header-row .apc-modal-header').addClass('col-xs-10');

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
    console.log('Disable Tool Tip');
    environment = getBootstrapEnvironment();

    if (environment != 'lg') {
        $('[data-toggle="tooltip"]').tooltip('disable');
    }
}