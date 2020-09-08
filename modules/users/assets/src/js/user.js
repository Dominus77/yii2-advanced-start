$(function () {
    $('.link-status').click(function (e) {
        e.preventDefault();
        ajaxLink(e);
    });
    $('.link-email').click(function (e) {
        e.preventDefault();
        ajaxLink(e);
    });

    $('.advanced-search-toggle').click(function (e) {
        e.preventDefault();
        $('.advanced-search').toggle('slow');
    });
});

// Ajax link Status
function ajaxLink(e)
{
    let link = e.currentTarget,
        url = link.href,
        body = $('#' + link.id),
        id = link.dataset.id;
    $.ajax({
        url: url,
        dataType: 'json',
        type: 'post',
    }).done(function (response) {
        body.html(response.result);
        $('#email-link-' + id).remove();
    }).fail(function (response) {
        console.log(response.result);
    });
}
