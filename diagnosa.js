$(document).ready(function() {
    $('#perjalanan').select2({
        placeholder: 'Apakah anda pernah berpergian dalam kurun waktu tiga bulan terakhir?'
    });
    var test = $("#Now").closest(".form-group");
    test = $("span", test);
    test.delegate('input', 'click', function(e) { e.stopImmediatePropagation(); }).click(function() {
        var res = $(this).find("input[type=checkbox]");
        res.click();
    });
    $('#Now').change(function(e) {
        if ($("#Now").is(':checked')) {
            $('.group-travel-history').removeClass('hidden');
        } else {
            $('.group-travel-history').addClass('hidden');
            $('#perjalanan').val('').trigger('change');
        }
    });

    $('#action').submit(function(e) {
        e.preventDefault();
        var ser = aerialize('action');
        // console.log(ser);
        if(confirm('Anda yakin?')) {
            $.ajax({
                type: 'POST',
                url: 'olah_diagnosa.php',
                data: {ser},
                dataType: 'JSON'
            }).done(function(data) {
                if(data.Status == 0) {
                    // console.log(JSON.stringify(data.Gejala));
                    // console.log(JSON.stringify(data.Latih));
                    var meta = {
                        header: 'Malaria',
                        result: 'hasil',
                        // elm_body: '#result',
                        // elm_row: '#row',
                        // finalVerb: 'terjangkit',
                        // positiveIdentifier: 'Yes',
                        // negativeIdentifier: 'no',
                        automaticDisplay: false
                    }
                    var result = NaiveBayes(meta, data.Gejala, data.Latih);
                    // console.log(result);
                    // displayResult(result);
                    var optiondata = {
                        data : result.calculation,
                        result : result.result,
                        id : data.ID
                    }
                    // console.log(optiondata);

                    $.ajax({
                        type: 'POST',
                        url: 'olah_diagnosa.php',
                        data: {optiondata},
                        dataType: 'JSON'
                    }).done(function(data) {
                        if(data.Status == 0) {
                            window.location.href = "hasil_diagnosa.php?id=" + data.ID;
                        }
                    });
                }
            });
        }
    });
});
