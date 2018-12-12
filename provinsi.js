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
    $('#action').submit(function(e) { // add
        e.preventDefault();
        var ser = aerialize('action');
        console.log(ser);
        // $.ajax({
        //     type: 'POST',
        //     url: 'olah_data-latih.php',
        //     data: {ser},
        //     dataType: 'JSON'
        // });
    });
});
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'olah_provinsi.php?get=all',
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
                            url: 'olah_provinsi.php?edit=' + attrID,
                            data: {ser},
                            dataType: 'JSON'
                        }).done(function(data) {
                            console.log(data);
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
            // order: [[1, "asc"]]
        });
    });
}
