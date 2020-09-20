// Fix jQuery Ui to Bootstrap Tooltip
if (bootstrapTooltip && $.fn.tooltip) {
    $.fn.tooltip = bootstrapTooltip;
}
// Fix jQuery Ui to Bootstrap Datepicker
if (bootstrapDatepicker && $.fn.bootstrapDP === undefined) {
    $.fn.bootstrapDP = bootstrapDatepicker;
}

$(function () {

    "use strict";

    /* jQueryKnob */
    $('.knob').knob();

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        containment: $('section.content'),
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs').css('cursor', 'move');

    $(document).ready(function () {
        $('.sidebar-menu').tree()
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $(document).ajaxComplete(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
