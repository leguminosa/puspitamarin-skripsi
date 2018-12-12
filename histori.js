$(document).ready(function() {
    // var modal = document.getElementById('myModal');
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
    refreshTable();
});
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'olah_histori.php?get=all',
        dataType: 'JSON',
        success: function(data) {
            remDataTable('maintable');
            var body = $('#body'), row = $('#row');
            $('.dataRow').remove();
            var Item = data.Data;
            for(var i = 0; i < Item.length; i++) {
                var item = Item[i], temp = row.clone();
                temp.removeAttr('id').removeClass('looptemplate').addClass('dataRow');
                // $('.no', temp).text(parseInt(i+1));
                // $('.jk', temp).text(item.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
                var wktu = item.waktu;
                wktu = moment(wktu, 'YYYY-MM-DD HH:mm');
                wktu = wktu.format("D MMMM YYYY, HH:mm")
                $('.waktu', temp).text(wktu);
                $('.usia', temp).text(item.usia);
                $('.domisili', temp).text(item.domisili);
                $('.hasil_diagnosa', temp).text(item.hasil_diagnosa == '1' ? 'Positif' : 'Negatif');
                var hsl = item.hasil || '-';
                hsl = hsl.replace('1', 'Positif');
                hsl = hsl.replace('0', 'Negatif');
                $('.hasil', temp).text(hsl);
                $('.action', temp).attr("attr-id", item.id);
                //action untuk lihat detail (ke arah hasil-diagnosa.php)
                var span_detail = $('<span></span>').addClass("fa fa-file-text-o").addClass("detail").text(" Detail");
                var a_detail = $('<a></a>').addClass("clickable");
                a_detail.append(span_detail);
                $('.action', temp).append(a_detail);
                $('.action', temp).append("<br>");
                //action untuk melaporkan hasil tes - hasil yang sebenarnya
                var span_hasil_tes = $('<span></span>').addClass("fa fa-edit").addClass("hasil_tes").text(" Hasil Tes");
                var a_hasil_tes = $('<a></a>').addClass("clickable");
                a_hasil_tes.append(span_hasil_tes);
                $('.action', temp).append(a_hasil_tes);
                $('.action', temp).append("<br>");

                body.append(temp);

                $('.action', temp).click(function (e) {
                    var attrID = $(this).attr("attr-id");
                    var target = $(e.target);
                    if(target.is('.detail')) {
                        window.location.href = 'hasil-diagnosa.php?id='+attrID;
                    } else if(target.is('.hasil_tes')) {
                        var modal = $('#myModal');
                        // $('p.identity', modal).text("Welcome, " + attrID);
                        $('[name=diagnosa]', modal).val(attrID);
                        modal.css('display', 'block');
                        var btn = $('button', modal);
                        btn.unbind().click(function() {
                            var ser = {
                                id: $('#diagnosa_id').val(),
                                hasil: $('[name=hasil]:checked').val()
                            };
                            $.ajax({
                                type: 'POST',
                                url: 'olah_histori.php',
                                data: {ser},
                                dataType: 'JSON'
                            }).done(function(data) {
                                if(data.Status == 0) {
                                    modal.css('display', 'none');
                                    btn.unbind();
                                    refreshTable();
                                    // console.log(data);
                                }
                            });
                        });
                    }
                });
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
