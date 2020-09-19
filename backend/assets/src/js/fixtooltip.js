let bootstrapTooltip,
    bootstrapDatepicker;
// Tooltip
if ($.fn.tooltip && $.fn.tooltip.noConflict) {
    bootstrapTooltip = $.fn.tooltip.noConflict();
}
// Datepicker
if ($.fn.datepicker && $.fn.datepicker.noConflict) {
    bootstrapDatepicker = $.fn.datepicker.noConflict();
}
