$(function() {
    createToast = function (type, message) {
        var $toast = $('<div/>', {class: 'toast', role: 'alert', 'aria-live': 'assertive', 'aria-atomic': 'true'}).appendTo($('.toast-container'));

        var $header = $('<div/>', {class: 'toast-header'}).appendTo($toast);
        var $strong = $('<strong/>', {class: 'me-auto', 'html': $('.toast-container').data('title')}).appendTo($header);
        if (type === 'success') {
            $("<i/>", {class: 'bi bi-check-square-fill text-success me-1'}).prependTo($strong);
        }
        else if (type === 'error' || type === 'danger') {
            $("<i/>", {class: 'bi bi-x-square-fill text-danger me-1'}).prependTo($strong);
        }
        else if (type === 'warning') {
            $("<i/>", {class: 'bi bi-exclamation-square-fill text-warning me-1'}).prependTo($strong);
        }
        else if (type === 'info') {
            $("<i/>", {class: 'bi bi-question-square-fill text-info me-1'}).prependTo($strong);
        }
        $('<small/>', {class: 'text-muted', 'html': 'À l\'instant'}).appendTo($header);
        $('<button/>', {type:'button', class:'btn-close', 'data-bs-dismiss':'toast', 'aria-label':'Close'}).appendTo($header);

        $('<div/>', {class: 'toast-body bg-white rounded fs-6', 'html': message}).appendTo($toast);

        var toast = new bootstrap.Toast($toast, {autohide: true, delay: 5000});
        toast.show()
    };

    /* Initialize toasts */
    $(".toast-container .toast").each(function () {
        var toast = new bootstrap.Toast($(this), {autohide: true, delay: 5000});
        toast.show()
    });
});
