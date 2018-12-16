$(document).ready(function() {
    var modal = $('#myModal'), span = $('.close'), btn = $('button', modal);
    span.eq(0).click(function() {
        modal.css('display', 'none');
        btn.unbind();
    });
    $(window).click(function(e) {
        if($(e.target).is(modal)) {
            modal.css('display', 'none');
            btn.unbind()
        }
    });
    refreshTableWaitingList();
    refreshTablAddedList();
});
function refreshTablAddedList() {
    $.ajax({
        type: 'GET',
        url: 'olah_diagnosa_datalatih.php?read=added',
        dataType: 'JSON'
    }).done(function(data) {
        remDataTable('maintable_added');
        var body = $('#body_added'),
            row = $('#row_added');
        $('.dataRowAddedList').remove();
        var Item = data.List;
        for (var i = 0; i < Item.length; i++) {
            var item = Item[i],
                temp = row.clone();
            temp.removeAttr('id').removeClass('looptemplate').addClass('dataRowAddedList');

            var wktu = item.waktu;
            wktu = moment(wktu, 'YYYY-MM-DD HH:mm');
            wktu = wktu.format("D MMMM YYYY, HH:mm");
            $('.waktu', temp).text(wktu);
            $('.nama', temp).text(item.pengguna);
            $('.usia', temp).text(item.usia);
            $('.domisili', temp).text(item.domisili);
            $('.hasil_diagnosa', temp).text(item.hasil_diagnosa == '1' ? 'Positif' : 'Negatif');
            var hsl = item.hasil || '-';
            hsl = hsl.replace('1', 'Positif');
            hsl = hsl.replace('0', 'Negatif');
            $('.hasil', temp).text(hsl);
            body.append(temp);
        }
        $('#maintable_added').DataTable({
            // columnDefs: [{
            //     orderable : false,
            //     targets : [-1, 0]
            // }],
            order: [[0, "desc"]]
        });
    });
}
function refreshTableWaitingList() {
    $.ajax({
        type: 'GET',
        url: 'olah_diagnosa_datalatih.php?read=waiting',
        dataType: 'JSON'
    }).done(function(data) {
        remDataTable('maintable');
        var body = $('#body'), row = $('#row');
        $('.dataRowWaitingList').remove();
        var Item = data.List;
        for(var i = 0; i < Item.length; i++) {
            var item = Item[i], temp = row.clone();
            temp.removeAttr('id').removeClass('looptemplate').addClass('dataRowWaitingList');
            // $('.no', temp).text(parseInt(i+1));
            // $('.jk', temp).text(item.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
            var wktu = item.waktu;
            wktu = moment(wktu, 'YYYY-MM-DD HH:mm');
            wktu = wktu.format("D MMMM YYYY, HH:mm")
            $('.waktu', temp).text(wktu);
            $('.nama', temp).text(item.pengguna);
            $('.usia', temp).text(item.usia);
            $('.domisili', temp).text(item.domisili);
            $('.hasil_diagnosa', temp).text(item.hasil_diagnosa == '1' ? 'Positif' : 'Negatif');
            var hsl = item.hasil || '-';
            hsl = hsl.replace('1', 'Positif');
            hsl = hsl.replace('0', 'Negatif');
            $('.hasil', temp).text(hsl);
            $('.action', temp).attr("attr-id", item.id);
            //action untuk lihat detail (ke arah hasil_diagnosa.php)
            var span_detail = $('<span></span>').addClass("fa fa-file-text-o").addClass("detail").text(" Detail");
            var a_detail = $('<a></a>').addClass("clickable");
            a_detail.append(span_detail);
            $('.action', temp).append(a_detail);
            $('.action', temp).append("<br>");

            body.append(temp);

            $('.action', temp).click(function (e) {
                var attrID = $(this).attr("attr-id");
                var target = $(e.target);
                if(target.is('.detail')) {
                    var modal = $('#myModal');
                    getDetailData(attrID);
                    modal.css('display', 'block');
                    var btn = $('button', modal);
                    btn
                    .unbind()
                    .bind('click', function () {
                        if(confirm("Ingin menambahkan diagnosa ke dalam data latih?")) {
                            $.ajax({
                                type: 'GET',
                                url: 'olah_diagnosa_datalatih.php?push=' + attrID,
                                dataType: 'JSON'
                            }).done(function (data) {
                                if (data.Status == 0) {
                                    alert("Update berhasil");
                                    modal.css('display', 'none');
                                    btn.unbind();
                                    refreshTableWaitingList();
                                    refreshTablAddedList();
                                }
                            });
                        }
                    });
                }
            });
        }
        $('#maintable').DataTable({
            columnDefs: [{
                orderable : false,
                targets : [-1, 0]
            }],
            order: [[0, "desc"]]
        });
    });
}
function getDetailData(id) {
    $.ajax({
        type:'GET',
        url: 'olah_hasil_diagnosa.php?id=' + id,
        dataType: 'JSON'
    }).done(function(data) {
        if(data.Status == 0) {
            var header = data.Header, content = data.Data;
            if(header) {
                refreshDetailData(header);
                var wktu = header.waktu;
                wktu = moment(wktu, 'YYYY-MM-DD HH:mm');
                wktu = wktu.format("dddd, MMMM Do YYYY HH:mm");
                $('#timestamps').text(wktu);
                $('#nama').text(header.nama);
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
}
function refreshDetailData(item) {
    // console.log(item);
    // remDataTable('maintable');
    var body = $('#body_modal'), row = $('#row_modal');
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
        $('.hasil_tes', temp).text(item.hasil == '1' ? 'Positif' : 'Negatif');

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
