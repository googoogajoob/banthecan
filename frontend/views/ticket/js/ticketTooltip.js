/**
 * Created by and on 4-May-15.
 */

$(function () {
    $("[data-toggle-click='tooltip']").tooltip({
        placement: 'auto',
        trigger: 'click'
    });
    $("[data-toggle-hover='tooltip']").tooltip({
        placement: 'auto',
        trigger: 'hover'
    });
    $('.ticket-glyph-tags').popover();
});
