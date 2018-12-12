$(document).ready(function() {
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };
    var id = getUrlParameter('id');
    $.ajax({
        type:'GET',
        url: 'olah_hasil_diagnosa.php?id=' + id,
        dataType: 'JSON'
    }).done(function(data) {
        if(data.Status == 0) {
            var header = data.Header, content = data.Data;
            if(header) {
                refreshTable(header);
                var wktu = header.waktu;
                wktu = moment(wktu, 'YYYY-MM-DD HH:mm');
                wktu = wktu.format("dddd, MMMM Do YYYY HH:mm");
                $('#timestamps').text(wktu);
                $('#usia').text(header.usia);
                $('#domisili').text(header.domisili);
                $('#jk').text(header.jk == 'P' ? 'Perempuan' : 'Laki-laki');
                var metaData = {
                    header: 'Malaria',
                    result: 'hasil',
                    elm_body: '#result-body',
                    elm_row: '#line-result',
                    positiveIdentifier: 'Ya',
                    negativeIdentifier: 'Tidak',
                    finalVerb: 'Terkena'
                };
                displayResult({ calculation: content, result: header.hasil_diagnosa, meta: metaData });
            }
        }
    });
});
function refreshTable(/*Item*/item) {
    // console.log(item);
    // remDataTable('maintable');
    var body = $('#body'), row = $('#row');
    $('.dataRow').remove();
    // var Item = data.Data;
    // for(var i = 0; i < Item.length; i++) {
        var gejala = ['malaise', 'sakit_kepala', 'batuk', 'diare', 'nyeri_otot', 'mual', 'menggigil', 'endemik', 'demam'];
        var /*item = Item[i],*/ temp = row.clone();
        for (var field in item) {
            if(gejala.includes(field)) {
                item[field] = item[field] == 1 ? "Ya" : "Tidak";
            }
        }
        temp.removeAttr('id').removeClass('looptemplate hidden').addClass('dataRow');
        // $('.no', temp).text(parseInt(i+1));
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
        $('.hasil', temp).text(item.hasil_diagnosa == '1' ? 'Positif' : 'Negatif');

        body.append(temp);
    // }
    // $('#maintable').DataTable({
        // columnDefs: [{
        //     orderable : false,
        //     targets : [-1, 0]
        // }],
        // order: [[1, "asc"]]
    // });
}
