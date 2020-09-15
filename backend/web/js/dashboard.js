$(function () {

    "use strict";

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        containment         : $('section.content'),
        placeholder         : 'sort-highlight',
        connectWith         : '.connectedSortable',
        handle              : '.box-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex              : 999999
    });
    $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

    $(document).ready(function () {
        $('.sidebar-menu').tree()
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $(document).ajaxComplete(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
