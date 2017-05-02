$(function () {
    $('.datetimepicker').datetimepicker({
        language: 'ru'
    });

    CKEDITOR.replaceAll('editor');

    $('#save-promo').on('click', function(event) {
        var $form = $(event.target).closest('form');
        if (!validateForm($form[0])) {
            return false;
        }
        var fd = new FormData($form[0]);
        Object.keys(CKEDITOR.instances).forEach(function(fieldName) {
            fd.append(fieldName, CKEDITOR.instances[fieldName].getData().trim());
        });

        $.ajax({
            url: $form.attr('action'),
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
                cl(data)
            }
        });


        event.preventDefault();
    });




});



function validateForm(form) {
    return (
        checkRequired(form)
    &&  checkDates($(form).find('[name="date_show_start"]')[0], $(form).find('[name="date_show_end"]')[0])
    );
}

function checkRequired(form) {
    var error = false;
    $(form).find('.require').each(function(i, item) {
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





