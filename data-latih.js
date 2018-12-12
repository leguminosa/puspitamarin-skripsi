$(document).ready(function() {
    refreshTable();
    $('[name=domisili]').select2({
        placeholder: 'Silahkan pilih'
    });
    $('#action').submit(function(e) {
        e.preventDefault();
        var ser = aerialize('action');
        $.ajax({
            type: 'POST',
            url: 'olah_data-latih.php',
            data: {ser},
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                if(data.Status == 0) {
                    showAlertSuccess("Suksess", ".modal-footer", 0);
                    resetForm();
                    refreshTable();
                } else {
                    alert("Terjadi galat pada sistem. Error Code = " + data.Status);
                }
            }
        });
    });
});
function resetForm() {
    $('.def_radio').prop('checked', 'checked');
    $('.tb').val('').trigger('change');
    $('[type=checkbox]').prop('checked', false);
    $('select.def option.def_select').attr('selected', 'selected');
}
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'olah_data-latih.php?get=all',
        dataType: 'JSON',
        success: function(data) {
            remDataTable('maintable');
            var body = $('#body'), row = $('#row');
            $('.dataRow').remove();
            var Item = data.Data;
            for(var i = 0; i < Item.length; i++) {
                var gejala = ['malaise', 'sakit_kepala', 'batuk', 'diare', 'nyeri_otot', 'mual', 'menggigil', 'endemik', 'demam'];
                var item = Item[i], temp = row.clone();
                for (var field in item) {
                    if(gejala.includes(field)) {
                        item[field] = item[field] == 1 ? "Ya" : "Tidak";
                    }
                }
                temp.removeAttr('id').removeClass('looptemplate').addClass('dataRow');
                $('.no', temp).text(parseInt(i+1));
                $('.jk', temp).text(item.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
                $('.usia', temp).text(item.usia);
                $('.domisili', temp).text(item.domisili);
                $('.malaise', temp).text(item.malaise);
                $('.sakit_kepala', temp).text(item.sakit_kepala);
                $('.batuk', temp).text(item.batuk);
                $('.diare', temp).text(item.diare);
                $('.nyeri_otot', temp).text(item.nyeri_otot);
                $('.mual', temp).text(item.mual);
                $('.menggigil', temp).text(item.menggigil);
                $('.endemik', temp).text(item.endemik);
                $('.demam', temp).text(item.demam);
                $('.hasil', temp).text(item.hasil == '1' ? 'Positif' : 'Negatif');

                body.append(temp);
            }
            $('#maintable').DataTable({
                // columnDefs: [{
                //     orderable : false,
                //     targets : [-1, 0]
                // }],
                order: [[1, "asc"]]
            });
        }
    });
}
