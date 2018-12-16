$(document).ready(function() {
    $('span').not('.slider-text').click(function() {
        $(this).prev().click();
    });
    $('span.slider-text').click(function() {
        var a = $(this).closest('li')
        a.find('input[type=checkbox]').click();
    });

    $('.dropdown-container').slideUp(0);
    var sideMenu = $('.sidenav > a, .sidenav > button');
    $(sideMenu).click(function() {
        if($(this).hasClass('dropdown-btn')) {
            var btn = $(this);
            var div = btn.next();
            var open = $(this).hasClass('active');
            dropdownsOpenClose(btn, div, open);
            if(!open) {
                // if opening, then close all other dropdowns
                var other_btn = $('button', '.sidenav').not(this);
                var other_div = other_btn.next();
                dropdownsOpenClose(other_btn, other_div, true);
            }
        }
    });
    $('.tablinks').click(function(e) {
        if(!$(this).hasClass('active')) {
            var cls = $(this).attr('class');
            cls = cls.replace('tablinks', '').trim();
            openCity(e, cls);
            // if(cls == 'home') window.location.href = 'index.php';
        }
    });
});
function dropdownsOpenClose(parent, elm, open=true) {
    if(open) {
        // closes it
        parent.removeClass("active");
        elm.slideUp();
        parent.find('i').removeClass('fa-caret-down');
        parent.find('i').addClass('fa-caret-left');
    } else {
        // opens it
        parent.addClass("active");
        elm.slideDown();
        parent.find('i').removeClass('fa-caret-left');
        parent.find('i').addClass('fa-caret-down');
    }
}
function openCity(evt, cityName, other=false) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    if(!other) {
        evt.currentTarget.className += " active";
    } else {
        document.getElementsByClassName(other)[0].className += " active";
    }
}
function aerialize(elm) {
// furthermore objectifies serializeArray()
    var ser_array = $('#' + elm).serializeArray();
    var ser = {};
    for(var i = 0; i < ser_array.length; i++) {
        var collection = ser_array[i];
        var nm = collection.name;
        if(nm.indexOf('[]') > -1) {
            nm = nm.replace('[]', '');
            if(!$.isArray(ser[nm])) ser[nm] = [];
            ser[nm].push(collection.value);
        } else {
            ser[nm] = collection.value;
        }
    }
    return ser;
}
function resetForm() {
    $('.def_radio').prop('checked', 'checked');
    $('.tb').val('').trigger('change');
    $('[type=checkbox]').prop('checked', false);
    $('select.def option.def_select').attr('selected', 'selected');
}
function remDataTable(tableName) {
    var isi = $('#' + tableName + ' .looptemplate').clone();
    $('#' + tableName).dataTable().fnDestroy();
    $('#' + tableName + ' .looptemplate').remove();
    $('#' + tableName).after(isi);
}
function showAlertSuccess(id, flag, msg="Input Berhasil") {
    $(".alert").remove();
    // $('#myModal').modal('hide');

    if(flag == 0) { //ALERT POPUP DITUTUP
        $(id).before('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');
        // self.closePopup();
        $('body').animate({
            scrollTop: 0
        }, 1000);
    } else if(flag == 1) { //ALERT POPUP TIDAK DITUTUP
        $(id).after('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');
    } else if(flag == 3) { //ALERT BIASA
        $(id).before('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+msg+'</div>');
        $('body').animate({
            scrollTop: 0
        }, 1000);
    }
    setTimeout(function(){
        $(".alert").remove();
        // if(flag == 1) {
        //     self.closePopup();
        // }
    },2500);
}
function UCFirst(string) {
    string = string.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
        return letter.toUpperCase();
    });
    return string;
}
