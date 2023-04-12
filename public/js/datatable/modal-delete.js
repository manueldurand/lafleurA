$(function() {
    $(document).on('click', '.delete-button', function (e) {
        e.preventDefault();

        var csrfToken = $(this).data('token');
        $("#delete-token").val(csrfToken);

        var href = $(this).attr('href');
        $("#delete-form").attr('action', href);
        $('#delete-modal').modal('show');
    });
});