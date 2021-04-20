$(document).ready(function () {
    $('.jsSelectAllInGroup').on('click', function (event) {
        event.preventDefault();
        $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
            $(value).iCheck('check');
        });
    });
    $('.jsDeselectAllInGroup').on('click', function (event) {
        event.preventDefault();
        $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
            $(value).iCheck('uncheck');
        });
    });
});