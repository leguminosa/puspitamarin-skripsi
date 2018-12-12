function NaiveBayes(gejala, latih, automaticDisplay=true) {
    // console.log(JSON.stringify(gejala));
    // console.log(JSON.stringify(latih));
    var attr = [];
    for(var field in latih[0]) {
        if(field != 'hasil') attr.push(field);
    }
    var total = latih.length;

    var tes = {};
    tes.hasil = countAttribute(latih, 'hasil', true);
    for(var i = 0; i < attr.length; i++) {
        var item = attr[i];
        tes[item] = countAttribute(latih, item);
    }

    // console.log(latih, tes);
    // console.log(tes);
    var calculation = [];
    var content = {
        name: 'Malaria_Ya',
        value: tes.hasil[1] + '/' + total
    };
    calculation.push(content);
    // console.log("P(Malaria | Ya) = " + tes.hasil[1] + "/" + total);
    content = {
        name: 'Malaria_Tidak',
        value: tes.hasil[0] + '/' + total
    };
    calculation.push(content);
    // console.log("P(Malaria | Tidak) = " + tes.hasil[0] + "/" + total);

    for(var attr in gejala) {
        var coba = tes[attr][gejala[attr]];
        var a = attr.replace('_', ' ');
        a = UCFirst(a);
        if(gejala[attr] == 0) a = "Tidak " + a;
        if(!coba[0]) coba[0] = 0;
        if(!coba[1]) coba[1] = 0;
        // console.log(attr, gejala[attr], coba);

        content = {
            name: a + '_Ya',
            value: coba[1] + '/' + tes.hasil[1]
        };
        calculation.push(content);
        // console.log('P('+a+' | Ya) = ' + coba[1] + '/' + tes.hasil[1]);
        content = {
            name: a + '_Tidak',
            value: coba[0] + '/' + tes.hasil[0]
        };
        calculation.push(content);
        // console.log('P('+a+' | Tidak) = ' + coba[0] + '/' + tes.hasil[0]);
    }
    var num_1 = 0, denum_1 = 0, num_2 = 0, denum_2 = 0;
    for(var i = 0, len = calculation.length; i < len; i++) {
        var item = calculation[i];
        var val = item.value.split('/');
        if(item.name.indexOf('_Ya') > 0) {
            num_1 = num_1 == 0 ? val[0] : num_1*val[0];
            denum_1 = denum_1 == 0 ? val[1] : denum_1*val[1];
        } else if(item.name.indexOf('_Tidak') > 0) {
            num_2 = num_2 == 0 ? val[0] : num_2*val[0];
            denum_2 = denum_2 == 0 ? val[1] : denum_2*val[1];
        }
    }
    content = {
        name: 'Terkena Malaria_Ya',
        value: num_1 + '/' + denum_1
    }
    calculation.push(content);
    content = {
        name: 'Terkena Malaria_Tidak',
        value: num_2 + '/' + denum_2
    }
    calculation.push(content);
    if(automaticDisplay) {
        displayResult(calculation);
    }
    return calculation;
}
function countAttribute(data, key, header=false) {
    var target = {};
    // console.log(data);
    for(var i = 0; i < data.length; i++) {
        var item = data[i], result = item[key];
        if(header) {
            if(target[result]) target[result] += 1;
            else target[result] = 1;
        } else {
            var temp = item.hasil;
            if(target[result]) {
                target[result].jumlah += 1;
                // target[result][temp] += 1;
                if(target[result][temp]) target[result][temp] += 1;
                else target[result][temp] = 1;
            }
            else {
                target[result] = {
                    jumlah: 1
                };
                target[result][temp] = 1
            }
        }
        // console.log(result);
    }
    return target;
}
function displayResult(calc) {
    $('.dataRes').remove();
    var body = $('#result'), row = $('#row');
    var final_1, final_2;
    for(var i = 0, len = calc.length; i < len; i++) {
        var item = calc[i];
        var left = item.name, right = item.value;
        var dec = right.split('/');
        dec = parseFloat(dec[0] / dec[1]);
        dec = dec.toFixed(3);
        left = left.replace('_', ' | ');
        left = 'P(' + left + ')';
        right = '= ' + dec;

        var temp = row.clone();
        temp.removeAttr('id').removeClass('looptemplate hidden').addClass('dataRes');
        if(left.indexOf('Terkena') > 0) {
            if(left.indexOf('Ya') > 0) final_1 = dec;
            else if(left.indexOf('Tidak') > 0) final_2 = dec;
        } else {
            $('label', temp).css('font-weight', '400');
        }
        $('.kiri', temp).text(left);
        $('.kanan', temp).text(right);
        body.append(temp);
    }
    var text = '';
    // console.log(final_1, final_2);
    if(final_1 > final_2) {
        text = 'Karena persentase terkena malaria Anda lebih tinggi, maka kemungkinan besar Anda menderita malaria.';
    } else {
        text = 'Karena persentase terkena malaria Anda lebih rendah, maka besar kemungkinannya bahwa Anda bebas malaria.';
    }
    $('#final').html(text);
}
