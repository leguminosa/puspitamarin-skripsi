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
    refreshTable();
    $('[name=domisili]').select2({
        placeholder: 'Silahkan pilih'
    });
    $('#action').submit(function(e) {
        e.preventDefault();
        var ser = aerialize('action');
        $.ajax({
            type: 'POST',
            url: 'olah_data_latih.php?write=new',
            data: {ser},
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                if(data.Status == 0) {
                    showAlertSuccess(".modal-footer", 0);
                    resetForm();
                    refreshTable();
                } else {
                    alert("Terjadi galat pada sistem. Error Code = " + data.Status);
                }
            }
        });
    });
});
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'olah_data_latih.php?read=true',
        dataType: 'JSON',
        success: function(data) {
            remDataTable('maintable');
            var body = $('#body'), row = $('#row');
            $('.dataRow').remove();
            var Item = data.Data;
            for(var i = 0; i < Item.length; i++) {
                var gejala = ['malaise', 'sakit_kepala', 'batuk', 'diare', 'nyeri_otot', 'mual', 'menggigil', 'endemik', 'demam'];
                var origin = {};
                var item = Item[i], temp = row.clone();
                for (var field in item) {
                    if(gejala.includes(field)) {
                        origin[field] = item[field];
                        item[field] = item[field] == 1 ? "Ya" : "Tidak";
                    }
                }
                temp.removeAttr('id').removeClass('looptemplate').addClass('dataRow');
                $('.no', temp).text(parseInt(i+1));
                $('.jk', temp).text(item.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan').attr('data-jk', item.jenis_kelamin);
                $('.usia', temp).text(item.usia).attr('data-usia', item.usia);
                $('.domisili', temp).text(item.domisili).attr('data-domisili', item.domisili_id);
                $('.malaise', temp).text(item.malaise).attr('data-malaise', origin.malaise);
                $('.sakit_kepala', temp).text(item.sakit_kepala).attr('data-sakit_kepala', origin.sakit_kepala);
                $('.batuk', temp).text(item.batuk).attr('data-batuk', origin.batuk);
                $('.diare', temp).text(item.diare).attr('data-diare', origin.diare);
                $('.nyeri_otot', temp).text(item.nyeri_otot).attr('data-nyeri_otot', origin.nyeri_otot);
                $('.mual', temp).text(item.mual).attr('data-mual', origin.mual);
                $('.menggigil', temp).text(item.menggigil).attr('data-menggigil', origin.menggigil);
                $('.endemik', temp).text(item.endemik).attr('data-endemik', origin.endemik);
                $('.demam', temp).text(item.demam).attr('data-demam', origin.demam);
                $('.hasil', temp).text(item.hasil == '1' ? 'Positif' : 'Negatif').attr('data-hasil', item.hasil);
                $('.action', temp).attr("attr-id", item.id);

                var span_edit = $('<span></span>').addClass("fa fa-edit").addClass("edit").text(" Edit");
                var a_edit = $('<a></a>').addClass("clickable");
                a_edit.append(span_edit);
                $('.action', temp).append(a_edit);
                $('.action', temp).append("<br>");

                var span_delete = $('<span></span>').addClass("fa fa-times").addClass("delete").text(" Delete");
                var a_delete = $('<a></a>').addClass("clickable");
                a_delete.append(span_delete);
                $('.action', temp).append(a_delete);
                $('.action', temp).append("<br>");
                body.append(temp);

                $('.action', temp).click(function(e) {
                    var attrID = $(this).attr("attr-id");
                    var target = $(e.target);
                    if(target.is('.edit')) {
                        var row = $(this).closest('tr');
                        var modal = $('#myModal');
                        $('#id').val(attrID);
                        $('[name=usia]', modal).val(row.find('.usia').data('usia'));
                        $('[name=domisili]', modal).val(row.find('.domisili').data('domisili')).trigger('change');
                        $('[name=jk][value='+row.find('.jk').data('jk')+']', modal).prop('checked', true);
                        $('[name=malaise]', modal).prop('checked', row.find('.malaise').data('malaise'));
                        $('[name=sakit_kepala]', modal).prop('checked', row.find('.sakit_kepala').data('sakit_kepala'));
                        $('[name=batuk]', modal).prop('checked', row.find('.batuk').data('batuk'));
                        $('[name=diare]', modal).prop('checked', row.find('.diare').data('diare'));
                        $('[name=nyeri_otot]', modal).prop('checked', row.find('.nyeri_otot').data('nyeri_otot'));
                        $('[name=mual]', modal).prop('checked', row.find('.mual').data('mual'));
                        $('[name=menggigil]', modal).prop('checked', row.find('.menggigil').data('menggigil'));
                        $('[name=endemik]', modal).prop('checked', row.find('.endemik').data('endemik'));
                        $('[name=demam]', modal).prop('checked', row.find('.demam').data('demam'));
                        $('[name=hasil]', modal).val(row.find('.hasil').data('hasil')).trigger('change');
                        modal.css('display', 'block');
                        $('#action_edit').unbind().submit(function(e) {
                            e.preventDefault();
                            var ser = aerialize('action_edit');
                            $.ajax({
                                type: 'POST',
                                url: 'olah_data_latih.php?write=' + attrID,
                                data: {ser},
                                dataType: 'JSON'
                            }).done(function(data) {
                                if(data.Status == 0) {
                                    alert("Update berhasil");
                                    modal.css('display', 'none');
                                    $('#action_edit').unbind();
                                    refreshTable();
                                }
                            });
                        });
                    } else if(target.is('.delete')) {
                        if(confirm("Yakin ingin menghapus data?")) {
                            $.ajax({
                                type: 'GET',
                                url: 'olah_data_latih.php?delete=' + attrID,
                                dataType: 'JSON'
                            }).done(function(data) {
                                if(data.Status == 0) {
                                    showAlertSuccess(".modal-footer", 0, "Data Telah Terhapus");
                                    refreshTable();
                                }
                            });
                        }
                    }
                });
            }
            $('#maintable').DataTable({
                // columnDefs: [{
                //     orderable : false,
                //     targets : [-1, 0]
                // }],
                order: [[0, "asc"]]
            });
        }
    });
}
