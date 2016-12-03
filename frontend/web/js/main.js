function getGlobalModalHtml(url) {
    clearModalContents();
    $('#modal-ajax-loader').show();
    $.ajax({
        url: url,
        type: "post",

        success: function(returnData) {

            $('#modal-ajax-loader').hide();
            $('#global-modal-container .modal-body').html(returnData);
            headerHtml = $('#global-modal-container .modal-body .apc-modal-header')[0].outerHTML;
            $('#global-modal-container .modal-body .apc-modal-header').remove();
            $('#global-modal-container .modal-header .apc-modal-header').remove();
            $('#modal-header-row').prepend(headerHtml);
            $('#modal-header-row .apc-modal-header').addClass('col-xs-10');

            //alert('success');
        },

        error: function(jqXHR, textStatus, errorThrown){
            $('#modal-ajax-loader').hide();
            alert('Error loading Global Modal Container: ' + url + ':' + textStatus + ':' + errorThrown);
        }

    });
}

function clearModalContents()
{
    $('#global-modal-container .modal-body').empty();
    $('#modal-header-row .apc-modal-header').remove();
}

function turnOnModalEvents() {
    $('#global-modal-container').on('show.bs.modal', function (event) {
        clearModalContents();
        sourceUrl = $(event.relatedTarget).attr('href');
        getGlobalModalHtml(sourceUrl);
        $('.tooltip').hide();
    });
}

function turnOffModalEvents() {
    $('#global-modal-container').off('show.bs.modal');
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

function initializeTooltip() {
    environment = getBootstrapEnvironment();

    if (environment == 'lg') {
        $('[data-toggle="tooltip"]').tooltip();
    }

}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return false;
}

$(document).ready(function() {

    turnOnModalEvents();

    buttonHtml = $('#modal-close-button')[0].outerHTML;
    $('#modal-close-button').remove();
    $('#modal-header-row').prepend(buttonHtml);

    $('#left-sidebar').on('show.bs.collapse', function () {
        $('#left-layout-main').removeClass();
        $('#left-layout-main').addClass('col-xs-6 col-sm-8 col-lg-10');
        $('#show-search-option-button').addClass('hidden');
        $('#hide-search-option-button').removeClass('hidden');
        setCookie('search-block', 1, 365);
    });

    $('#left-sidebar').on('hide.bs.collapse', function () {
        $('#left-layout-main').removeClass();
        $('#left-layout-main').addClass('col-xs-12');
        $('#hide-search-option-button').addClass('hidden');
        $('#show-search-option-button').removeClass('hidden');
        setCookie('search-block', 0, 365);
    });

    initializeTooltip();
});

