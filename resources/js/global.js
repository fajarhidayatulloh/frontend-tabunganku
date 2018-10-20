export function beforeSubmit(form) {
    $("div#divLoading").addClass('show');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').empty();
    var formElement = document.getElementById(form);
    var data = new FormData(formElement);
    return data;
}

export function showValidation(errors) {
    for (var key in errors) {
        $('#' + key).addClass('is-invalid');
        if( $('#' + key + '-val').is(':empty') ) {
            $('#' + key + '-val').append(errors[key][0]);
        }
        if (key == 'sign_file') {
            showAlert('danger', errors[key][0]);
        }
    }
    $('html, body').animate({
        scrollTop: $(".is-invalid").offset().top - 30
    }, 500);
}

export function showAlert(alert, message) {
    $('.alert').hide();
    $('.alert').removeClass().addClass('alert in alert-' + alert).show().text(message);
}

export function updateStep(prev_step, next_step) {
    $('#step-' + prev_step).addClass('d-none');
    $('#step-' + next_step).removeClass('d-none');
    $('input[name="step"]').val(next_step).change();
    $('#pg-' + next_step).removeClass('bg--grey').addClass('bg--primary__lighten');
}

export function backStep(currStep) {
    $('#step-' + currStep).addClass('d-none');
    $('#step-' + (currStep - 1)).removeClass('d-none');
    $('input[name="step"]').val((currStep - 1)).change();
    $('#pg-' + currStep).addClass('bg--grey').removeClass('bg--primary__lighten');
}

export function timeoutErr() {
    $('#main-modal-body').empty().append(err_conn_msg);
    $('#main-modal').modal({show:true});
}

export function crsfErr() {
    $('#main-modal-body').empty().append(err_conn_msg);
    $('#main-modal').modal({show:true});
    setTimeout(function() { $('#main-modal').modal('hide'); }, 3000);
}
