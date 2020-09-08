$(function () {

    "use strict";

    $(document).ready(function () {
        $('.sidebar-menu').tree()
    });

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $(document).ajaxComplete(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
