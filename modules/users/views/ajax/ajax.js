/**
 * Ajax Link
 * @param e mixed
 */
function handleAjaxLink(e) {

    e.preventDefault();

    var
        $title = $(e.target),
        $link = $('#' + this.id),
        callUrl = $link.attr('href');

    $.ajax({
        type: "post",
        dataType: 'json',
        url: callUrl,
        data: ({})
    }).done(function (response) {
        $link.html(response.body);
    });
}
