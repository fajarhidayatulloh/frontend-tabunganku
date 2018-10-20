/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');
require('./library');

import AutoNumeric from 'autonumeric';
const {
    register
} = require("./registration");
import {
    beforeSubmit,
    showValidation,
    showAlert,
    updateStep,
    timeoutErr,
    showPhoneVerify,
} from './global';


register();

$(document).ready(function () {
    $('.dropdown-toggle').dropdown();
});

if (document.querySelector('.currency')) {
    AutoNumeric.multiple('.currency', {
        'modifyValueOnWheel': false,
        'unformatOnHover': false,
        'currencySymbolPlacement': 's',
    });
}

$.fn.stars = function () {
    return $(this).each(function () {
        $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
    });
};

$(function () {
    $('span.stars').stars();
});

$('#subscribe-form').on('submit', function (e) {
    var data = beforeSubmit('subscribe-form');
    data.append('amount', AutoNumeric.getNumber('#amount'));
    if ($('input[name="agree_prospectus"]:checked').val()) {
        data.append('agree_prospectus', '1');
    }
    axios.post(url + '/user/transaction/subscribe', data)
        .then(function (response) {
            if (response.status == 200 && response.data.status == true) {
                var result = response.data.data;
                $('#order_no').append(result.order_no);
                $('#order_date').append(result.order_date);
                $('#nama_bank').append(result.info_payment.nama_bank);
                $('#nama').append(result.info_payment.nama);
                $('#cabang').append(result.info_payment.cabang);
                $('#no_rek').append(result.info_payment.no_rek);
                $('#nett_subscription').append(result.nett_subscription);
                $('#subscription_fee').append(result.subscription_fee);
                $('#total_payment').append(result.total_payment);
                AutoNumeric.multiple('.curr', {
                    'modifyValueOnWheel': false,
                    'unformatOnHover': false,
                    'currencySymbolPlacement': 's',
                });
                updateStep(1, 2);
            } else if (response.data.code == 401) {
                window.location = '/login';
            }
        })
        .catch(function (error) {
            if (error.response) {
                if (error.response.status === 422 && error.response.data.errors != "undefined") {
                    showValidation(error.response.data.errors);
                }
            } else if (error.request) {
                console.log(error.request);
            } else {
                console.log('Error', error.message);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });
    e.preventDefault();
});

$('#amount').on('keyup', function () {
    var amount = AutoNumeric.getNumber('#amount');
    var feepercent = $(this).data('fee');
    var fee = (amount * feepercent) / 100;
    AutoNumeric.getAutoNumericElement('#fee').set(fee);
    AutoNumeric.getAutoNumericElement('#total').set(fee + amount);
});

$('#btn-redemption').on('click', function (e) {
    var data = beforeSubmit('redemption-form');
    data.append('sms_token', $('#sms_token').val());
    data.append('unit', AutoNumeric.getNumber('#unit'));
    axios.post(url + '/user/transaction/redemption', data)
        .then(function (response) {
            if (response.status == 200 && response.data.response.code == 200) {
                $('#unit-resp').append(response.data.data.unit);
                $('#order_no').append(response.data.response.data.order_no);
                $('#redemption').hide();
                $('#redemp-finish').removeClass('d-none');
            } else if (response.data.response.code == 403) {
                $('#sms_token-val').append(response.data.response.message.message);
                $('#sms_token').addClass('is-invalid');
            } else if (response.data.response.code == 401) {
                window.location = '/login';
            }
        })
        .catch(function (error) {
            if (error.response) {
                if (error.response.status === 422 && error.response.data.errors != "undefined") {
                    showValidation(error.response.data.errors);
                }
            } else if (error.request) {
                console.log(error.request);
            } else {
                console.log('Error', error.message);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });
    e.preventDefault();
});

$('#all-unit-sell').on('click', function (e) {
    var all_unit = $('input[name="all_unit"]').val();
    var nav = $('#unit').data('nav');
    if (all_unit == 'f') {
        var unit = $('#unit').data('maximum-value');
        AutoNumeric.getAutoNumericElement('#unit').set((unit).toFixed(4));
        $('#unit').attr('readonly', true);
        $('input[name="all_unit"]').val('t').change();
        AutoNumeric.getAutoNumericElement('#estimation').set((nav * unit).toFixed(4));
    } else {
        $('#unit').attr('readonly', false);
        $('input[name="all_unit"]').val('f').change();
        AutoNumeric.getAutoNumericElement('#unit').set(0);
        AutoNumeric.getAutoNumericElement('#estimation').set((0));
    }

});

$('#unit').on('keyup', function () {
    var unit = AutoNumeric.getNumber('#unit');
    var nav = $(this).data('nav');
    AutoNumeric.getAutoNumericElement('#estimation').set((nav * unit).toFixed(4));
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#output').attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$('#order_confirmation').change(function () {
    readURL(this);
});

$('#registration').bind('submit', function (e) {
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $('#password').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url:"/registration/proses",
        data: {
            name:name,
            email:email,
            password:password,
        },

        dataType : "text",
        success : function(data) {
            var result = JSON.parse(data);
            console.log(result.status);
            if(result.status == 'OK'){
                $('#message').html(result.message);
                $('#modalMessage').modal();
            } 
            if(result.status == 'NOT_OK'){
                alert(result.message);
            }

        }
    });
    e.preventDefault();
});

$('#login-form').bind('submit', function (e) {
    var email = $("#email").val();
    var password = $('#password').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url:"/login/proses",
        data: {
            email:email,
            password:password,
        },
        dataType : "text",
        success : function(data) {
            var result = JSON.parse(data);
            console.log(result.status);
            if(result.status == 'OK'){
                window.location.href='/';
            } 
            if(result.status == 'NOT_OK'){
                $('#message').html(result.message);
                $('#modalMessage').modal();
            }

        }
    });
    /*var data = beforeSubmit('login-form');
    var url = '/login/proses';
    axios.post(url , data, {
            timeout: 5000
        })
        .then(function (data) {
            var response = JSON.parse(data);
            alert(response.data.status);
            if (response.status == 200 && response.data.status == 'OK') {
                window.location.href='/';
            }else if(response.data.status == 'NOT_OK'){
                alert(response.data.message);
            }
        })
        .catch(function (error) {
            if (error.code == 'ECONNABORTED' || error == 'Error: Network Error') {
                $("div#divLoading").removeClass('show');
                timeoutErr();
            }
            if (error.response.status === 422 && error.response.data.errors != "undefined") {
                showValidation(error.response.data.errors);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });*/
    e.preventDefault();
});

$('#contact-form').on('submit', function (e) {
    var data = beforeSubmit('contact-form');
    axios.post(url + '/contact', data)
        .then(function (response) {
            if (response.status == 200 && response.data.status == 'OK') {
                $('#contact-form').trigger("reset");
                showAlert('success', response.data.message);
            }
        })
        .catch(function (error) {
            if (error.response.status === 422 && error.response.data.errors != "undefined") {
                showValidation(error.response.data.errors);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });
    e.preventDefault();
});

$('#forgot-password').on('submit', function (e) {
    var data = beforeSubmit('forgot-password');
    axios.post(url + '/forgot-password', data)
        .then(function (response) {
            if (response.data.status == true && response.data.code == 200) {
                $('#forgot-password').trigger("reset");
                showAlert('success', response.data.message);
            } else {
                showAlert('danger', response.data.message);
            }
        })
        .catch(function (error) {
            if (error.response.status === 422 && error.response.data.errors != "undefined") {
                showValidation(error.response.data.errors);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });
    e.preventDefault();
});

$('#reset-password').on('submit', function (e) {
    var formElement = document.getElementById('reset-password');
    var data = beforeSubmit('reset-password');
    axios.post(formElement.action, data)
        .then(function (response) {
            if (response.data.status == 1 && response.data.code == 200) {
                $('#forgot-password').trigger("reset");
                showAlert('success', response.data.message);
            } else {
                showAlert('danger', response.data.message);
            }
        })
        .catch(function (error) {
            if (error.response.status === 422 && error.response.data.errors != "undefined") {
                showValidation(error.response.data.errors);
            }
        })
        .then(function () {
            $("div#divLoading").removeClass('show');
        });
    e.preventDefault();
});
