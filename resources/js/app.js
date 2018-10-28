/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');
require('./library');

import AutoNumeric from 'autonumeric';

import jquery from 'jquery'
import 'datatables';
import dt from 'datatables';
import fontawesome from '@fortawesome/fontawesome'

window.datatables = require('datatables');

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

if (document.querySelector('.nominal')) {
    AutoNumeric.multiple('.nominal', {
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

$(document).ready(function() {
    $('#example').DataTable({
        paging: false,
    });
} );

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     var oTable = $('#pemasukan-table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        scrollX:true,
        ajax: {
            url: '/pemasukan/list/dt',
            data: function (d) {
                d.date = $('input[name=date]').val();
            }
        },
        columns: [
            { data: 'no', name: 'no', orderable: true },
            { data: 'title', name: 'title', orderable: true },
            { data: 'description', name: 'description', orderable: false },
            { data: 'nominal', name: 'nominal', orderable: true },
            { data: 'date', name: 'date', orderable: true },
            { data: 'action', name: 'action', orderable: true },
        ],
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     var oTable = $('#pengeluaran-table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        scrollX:true,
        ajax: {
            url: '/pengeluaran/list/dt',
            data: function (d) {
                d.date = $('input[name=date]').val();
            }
        },
        columns: [
            { data: 'no', name: 'no', orderable: true },
            { data: 'title', name: 'title', orderable: true },
            { data: 'description', name: 'description', orderable: false },
            { data: 'nominal', name: 'nominal', orderable: true },
            { data: 'date', name: 'date', orderable: true },
            { data: 'action', name: 'action', orderable: true },
        ],
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
});

$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     var oTable = $('#qurban-table').DataTable({
        processing: true,
        serverSide: true,
        paging: false,
        searching: false,
        scrollX:true,
        ajax: {
            url: '/tabungan/qurban/list/dt',
            data: function (d) {
                d.date = $('input[name=date]').val();
            }
        },
        columns: [
            { data: 'no', name: 'no', orderable: true },
            { data: 'title', name: 'title', orderable: true },
            { data: 'description', name: 'description', orderable: false },
            { data: 'nominal', name: 'nominal', orderable: true },
            { data: 'date', name: 'date', orderable: true },
            { data: 'action', name: 'action', orderable: true },
        ],
    });

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
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

$('#pemasukan-form').bind('submit', function (e) {
    var title = $("#title").val();
    var nominal = AutoNumeric.getNumber('#nominal');
    var deskripsi = $('#deskripsi').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url:"/pemasukan/store",
        data: {
            title:title,
            nominal:nominal,
            deskripsi:deskripsi,
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

$('#pengeluaran-form').bind('submit', function (e) {
    var title = $("#title").val();
    var nominal = AutoNumeric.getNumber('#nominal');
    var deskripsi = $('#deskripsi').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url:"/pengeluaran/store",
        data: {
            title:title,
            nominal:nominal,
            deskripsi:deskripsi,
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

$('#qurban-form').bind('submit', function (e) {
    var title = $("#title").val();
    var nominal = AutoNumeric.getNumber('#nominal');
    var deskripsi = $('#deskripsi').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url:"/tabungan/qurban/store",
        data: {
            title:title,
            nominal:nominal,
            deskripsi:deskripsi,
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
