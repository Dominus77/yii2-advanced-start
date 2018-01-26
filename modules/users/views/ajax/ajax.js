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

/**
 * Ajax Link Generate Auth Key
 * @param e mixed
 */
function ajaxLinkGenerateAuthKey(e) {

    e.preventDefault();

    var
        $link = $('#' + this.id),
        callUrl = $link.attr('href');

    $.ajax({
        type: "post",
        dataType: 'json',
        url: callUrl,
        data: ({})
    }).done(function (response) {
        $('#auth_key_container').html(response.body);
    });
}
