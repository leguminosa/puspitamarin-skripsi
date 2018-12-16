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
    $('#action').submit(function(e) {
        e.preventDefault();
        var ser = aerialize('action');
        $.ajax({
            type: 'POST',
            url: 'olah_provinsi.php?write=new',
            data: {ser},
            dataType: 'JSON'
        }).done(function(data) {
            if(data.Status == 0) {
                showAlertSuccess(".modal-footer", 0);
                resetForm();
                refreshTable();
            } else {
                alert("Terjadi galat pada sistem. Error Code = " + data.Status);
            }
        });
    });
});
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'olah_provinsi.php?read=true',
        dataType: 'JSON'
    }).done(function(data) {
        remDataTable('maintable');
        var body = $('#body'), row = $('#row');
        $('.dataRow').remove();
        var Item = data.Data;
        for(var i = 0; i < Item.length; i++) {
            var item = Item[i], temp = row.clone();
            temp.removeAttr('id').removeClass('looptemplate').addClass('dataRow');
            $('.id', temp).text(item.id).attr('data-id', item.id);
            $('.nama', temp).text(item.nama).attr('data-nama', item.nama);
            $('.endemik', temp).text(item.endemik == 0 ? "Tidak" : "Ya").attr('data-endemik', item.endemik);
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
                    // $('#id').val(row.find('.id').data('id'));
                    var modal = $('#myModal');
                    $('#id').val(attrID);
                    $('#nama').val(row.find('.nama').data('nama'));
                    $('#endemik').prop('checked', row.find('.endemik').data('endemik'));
                    modal.css('display', 'block');
                    $('#action_edit').unbind().submit(function(e) {
                        e.preventDefault();
                        var ser = aerialize('action_edit');
                        $.ajax({
                            type: 'POST',
                            url: 'olah_provinsi.php?write=' + attrID,
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
                            url: 'olah_provinsi.php?delete=' + attrID,
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
            // order: [[1, "asc"]]
        });
    });
}
