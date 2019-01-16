$(document).ready(function() {
    refreshTable(2);
    $('#argument').change(function() {
        var selected = $('option:selected', this).val();
        var txt = 'LAPORAN HASIL TES';
        if(selected == 0) {
            txt = 'LAPORAN HASIL TES YANG TIDAK SESUAI';
        } else if(selected == 1) {
            txt = 'LAPORAN HASIL TES YANG SESUAI';
        }
        $('#title').text(txt);
        refreshTable(selected);
    });
});
function refreshTable(arg=2) {
    $.ajax({
        type: 'GET',
        url: 'olah_hasil_tes.php?arg=' + arg,
        dataType: 'JSON'
    }).done(function(data) {
        console.log(data);
        $('.dataRow').remove();
        var body = $('#maintable'), row = $('#row');
        for(var i = 0; i < data.length; i++) {
            var item = data[i];
            var temp = row.clone();
            temp.removeAttr('id').removeClass('looptemplate hidden').addClass('dataRow');
            $('.no', temp).text(i+1);
            $('.nama', temp).text(item.Nama);
            $('.jk', temp).text(item.JenisKelamin);
            $('.usia', temp).text(item.Usia);
            $('.domisili', temp).text(item.Domisili);
            $('.hasil', temp).text(item.Hasil);
            $('.hasil_diagnosa', temp).text(item.HasilDiagnosa);
            body.append(temp);
        }
    });
}
