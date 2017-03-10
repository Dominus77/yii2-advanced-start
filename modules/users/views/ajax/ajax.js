/**
 * Created by Dominus on 10.03.17.
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
