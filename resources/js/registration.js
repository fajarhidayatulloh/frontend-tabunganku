import {
    beforeSubmit,
    showValidation,
    showAlert,
    updateStep,
    backStep,
    timeoutErr
} from './global';

export function register() {
    $('#register-form').on('submit', function (e) {
        e.preventDefault();
        var step = $('input[name="step"]').val();
        if (step == 1) {
            var uploadImage = document.getElementById('identity_file');
            if (uploadImage.files.length === 0) {
                var data = beforeSubmit('register-form');
                submitRegister(data);
                return;
            }
            var uploadFile = uploadImage.files[0];
            if (!filterType.test(uploadFile.type)) {
                var data = beforeSubmit('register-form');
                submitRegister(data);
                showValidation({
                    identity_file: [invalidImage]
                });
                return;
            }
            fileReader.readAsDataURL(uploadFile);
        } else if (step == 3) {
            if (signaturePad.isEmpty()) {
                 $('input[name="sign_file"]').empty();
            } else {
                 $('input[name="sign_file"]').val(signaturePad.toDataURL('image/png'));
            }
            var data = beforeSubmit('register-form');
            submitRegister(data);
        } else {
            var data = beforeSubmit('register-form');
            submitRegister(data);
        }
    });

    $('#verify-token').click(function () {
        var phone = $('#handphone').val();
        var token = $('#sms_token').val();
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').empty();
        axios.post(url + '/verify-sms-token', {
                handphone: phone,
                sms_token: token
            })
            .then(function (response) {
                if (response.status == 200 && response.data.status == 'OK') {
                    $('#phone-verify').modal('hide');
                    updateStep(1, 2);
                }
            })
            .catch(function (error) {
                if (error.response) {
                    if (422 == error.response.status && error.response.data.errors) {
                        showValidation(error.response.data.errors);
                    }
                } else if (error.request) {
                    console.log(error.request);
                } else {
                    console.log('Error', error.message);
                }
            });
    });

    $('#get-token').click(function () {
        $("div#divLoading").addClass('show');
        var phone = $('#handphone').val();
        axios.post(url + '/send-sms-token', {
                handphone: phone
            })
            .then(function (response) {
                if (response.status == 200 && response.data.status == true) {
                    showAlert('success', response.data.message);
                } else if (response.status == 200 && response.data.status == false) {
                    showAlert('danger', response.data.message);
                }
            })
            .catch(function (error) {
                showAlert('danger', 'Failed to get sms token');
                console.log(error);
            }).then(function () {
                $("div#divLoading").removeClass('show');
            });
    });

    $('#get-trx-token').click(function (e) {
        $("div#divLoading").addClass('show');
        axios.get(url + '/user/get-sms-token', {
                timeout: 20000
            })
            .then(function (response) {
                if (response.status == 200 && response.data.status == true) {
                    showAlert('success', response.data.message);
                }
                if (response.status == 200 && response.data.status == false) {
                    showAlert('danger', response.data.message);
                }
            }).catch(function (error) {
                if (error.code == 'ECONNABORTED' || error == 'Error: Network Error') {
                    timeoutErr();
                }
                showAlert('danger', 'Failed to get sms token');
            }).then(function () {
                $("div#divLoading").removeClass('show');
            });
        e.preventDefault();
    });

    if (document.querySelector('canvas')) {
        var canvas = document.querySelector('canvas');
        var signaturePad = new SignaturePad(canvas);
        window.onresize = resizeCanvas;
        resizeCanvas();
    }

    $('#clear-sign').click(function () {
        signaturePad.clear();
        $('input[name="sign_file"]').empty();
    });

    function resizeCanvas() {
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear();
    }

    function showPhoneVerify() {
        $("#phone-verify").modal('show');
    }

    $('#update-profile').on('submit', function (e) {
        var data = beforeSubmit('update-profile');
        axios.post(url + '/user/profile/update', data)
            .then(function (response) {
                if (response.status == 200 && response.data.status == true) {
                    $('#update-profile').hide();
                    $('#edit-sucess').removeClass('d-none');
                }
            })
            .catch(function (error) {
                if (error.code == 'ECONNABORTED' || error == 'Error: Network Error') {
                    timeoutErr();
                }
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

    $('#register-back').on('click', function (e) {
        var step = $('input[name="step"]').val();
        if (step == 1) {
            window.history.back();
        } else {
            backStep(step);
        }
        e.preventDefault();
    });

    $('.open-disclaimer').on('click', function (e) {
        var title = $(this).data('title');
        var dataURL = $(this).data('href');
        $('#main-modal-title').empty().append(title);
        $('#main-modal-body').load(dataURL, function () {
            $('#main-modal').modal({
                show: true
            });
        });
    });

    $('#token-form input').on('keypress', function (e) {
        return e.which !== 13;
    });

    var fileReader = new FileReader();
    var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

    fileReader.onload = function (event) {
        var image = new Image();
        image.onload = function () {
            var canvas = document.createElement("canvas"),
            context = canvas.getContext("2d"),
            width = image.width,
            height = image.height,
            maxSize = 860;

            if (width > maxSize) {
                width = image.width / (image.width / maxSize);
                height = image.height / (image.width / maxSize);
            }
            canvas.width = width;
            canvas.height = height;
            context.drawImage(image, 0, 0, width, height);
            if (canvas.toBlob) {
                canvas.toBlob(
                    function (blob) {
                        var data = beforeSubmit('register-form');
                        data.append('identity_file', blob, 'identity_file.jpg');
                        submitRegister(data);
                    },
                    'image/jpeg'
                );
            }
        };
        image.src = event.target.result;
    };

    function submitRegister(data) {
        axios.post(url + '/register', data, {
                timeout: 25000
            })
            .then(function (response) {
                if (response.status === 200 && response.data.status == 'OK') {
                    if (response.data.prev_step == 1) {
                        $('#bank_acc_name').val(data.get('name'));
                        showPhoneVerify();
                    } else {
                        updateStep(response.data.prev_step, response.data.next_step);
                    }
                    if (response.data.next_step == 3) {
                        resizeCanvas();
                    }
                    if (response.data.next_step == 4) {
                        $('#wizard').hide();
                        $('#register-back').hide();
                        $('#btn-register').hide();
                    }
                }
            })
            .catch(function (error) {
                if (error.code == 'ECONNABORTED' || error == 'Error: Network Error') {
                    timeoutErr();
                }
                if (error.response) {
                    if (error.response.status == 422 && error.response.data.errors != "undefined") {
                        showValidation(error.response.data.errors);
                    }
                    if (error.response.status == 419) {
                        location.reload();
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
    }
}
