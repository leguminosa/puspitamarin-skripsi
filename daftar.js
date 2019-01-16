$(document).ready(function() {
    const allEqual = arr => arr.every( v => v === arr[0] )
    $('[name=tmpt_lahir], [name=domisili]').select2({
        placeholder: 'Silahkan pilih'
    });
    $(function() {
        $('.date').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            // autoApply: false,
            maxDate: moment(),
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });
        $('.date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
            var age = moment().diff(picker.startDate, 'years');
        });
        $('.date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
    $('#action').submit(function(e) {
        e.preventDefault();
        var ser = $(this).serializeArray();
        var temp = [];
        $('input.pass').each(function() {
            var val = $(this).val();
            temp.push(val);
        });
        var validatePassword = allEqual(temp);
        if(!validatePassword) {
            alert('Password yang anda masukkan belum cocok.');
        } else {
            $.ajax({
                type: 'POST',
                url: 'olah_daftar.php',
                data: {ser},
                dataType: 'JSON'
            }).done(function(data) {
                if(data.Status == 0) {
                    alert('Registrasi berhasil. Silahkan login.');
                    window.location.href = 'login.php';
                } else if(data.Status == 1) {
                    alert('Ada galat tidak diketahui.');
                } else if(data.Status == 2) {
                    alert('Username Anda sudah digunakan. Silahkan pilih Username yang lain.');
                }
            });
        }
    });
});
