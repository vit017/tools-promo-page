$(function () {
    $('.datetimepicker').datetimepicker({
        language: 'ru'
    });

    CKEDITOR.replaceAll(function(textarea, cnf) {
        if (!$(textarea).hasClass('editor')) return;
        cnf.filebrowserBrowseUrl = '/assets/ckeditor/ckfinder/ckfinder.html';
        cnf.filebrowserUploadUrl = '/assets/ckeditor/upload.php';
        return true;
    });

    $('.delete-record').on('click', function(event) {
        if (!confirm('Delete record?')) {
            event.preventDefault();
        }
    });

});


function validateForm(form) {
    return (
        checkRequired(form)
        && checkDates($(form).find('[name="date_show_start"]')[0], $(form).find('[name="date_show_end"]')[0])
    );
}

function checkRequired(form) {
    var error = false;
    $(form).find('.require').each(function (i, item) {
        if (item.value.trim() === '') {
            $(item).closest('.form-group').removeClass('has-success');
            $(item).closest('.form-group').addClass('has-error');
            error = true;
        }
        else {
            $(item).closest('.form-group').removeClass('has-error');
            $(item).closest('.form-group').addClass('has-success');
        }
    });

    return !error;
}

function checkDates(date1, date2) {
    var error = false;
    if (+moment(date2.value, 'DD.MM.YYYY hh:mm:ss') < +moment(date1.value, 'DD.MM.YYYY hh:mm:ss')) {
        $(date2).closest('.form-group').removeClass('has-success');
        $(date2).closest('.form-group').addClass('has-error');
        error = true;
    }
    else {
        $(date2).closest('.form-group').removeClass('has-error');
        $(date2).closest('.form-group').addClass('has-success');
    }

    return !error;
}





