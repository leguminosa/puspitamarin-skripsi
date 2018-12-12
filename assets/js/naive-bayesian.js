function NaiveBayes(metaData, gejala, latih) {
/*
 *  metaData = {
 *      header: (wajib) apa yang akan dianalisa dgn Naive Bayes (cth: Malaria)
 *      result: (wajib) property target dari data-latih (cth: latih.hasil)
 *      elm_body: hasilnya mw ditaro dimana (default:#result)
 *      elm_row: elemen per row nya (default:#row)
 *      finalVerb: modifier trhdp tujuan (default:terkena)
 *      positiveIdentifier: (default:ya)
 *      negativeIdentifier: (default:tidak)
 *      automaticDisplay: true/false (default:true)
 *  }
 *  gejala = {
 *      param-1: 0 atau 1,
 *      param-2: 0 atau 1,
 *      .
 *      .
 *      .
 *      param-n: 0 atau 1
 *  }
 *  latih = [{
 *      param-1: 0 atau 1,
 *      param-2: 0 atau 1,
 *      .
 *      .
 *      .
 *      param-n: 0 atau 1
 *      hasil: 0 atau 1
 *  }, {...}, ...]
 */
    var automaticDisplay = true;
    var verb = metaData.finalVerb ? UCFirst(metaData.finalVerb) : 'Terkena';
    var pos = metaData.positiveIdentifier ? UCFirst(metaData.positiveIdentifier) : 'Ya';
    var neg = metaData.negativeIdentifier ? UCFirst(metaData.negativeIdentifier) : 'Tidak';
    metaData.finalVerb = verb;
    metaData.elm_body = metaData.elm_body ? metaData.elm_body : '#result';
    metaData.elm_row = metaData.elm_row ? metaData.elm_row : '#row';
    metaData.positiveIdentifier = pos;
    metaData.negativeIdentifier = neg;
    if(metaData.hasOwnProperty('automaticDisplay')) {
        if(typeof metaData.automaticDisplay === "boolean") {
            automaticDisplay = metaData.automaticDisplay;
        }
    } else metaData.automaticDisplay = automaticDisplay;

    // ngambil daftar atribut apa aja yg ada
    var attr = [];
    for(var field in latih[0]) {
        if(field != metaData.result) attr.push(field);
    }
    var total = latih.length;
    // ngitung ada apa aja di kelas target
    var tes = {};
    tes[metaData.result] = countAttribute(latih, metaData.result, true);
    for(var i = 0; i < attr.length; i++) {
        var item = attr[i];
        tes[item] = countAttribute(latih, item);
    }

    var calculation = [];
    for(var answer in tes[metaData.result]) {
        var item = tes[metaData.result];
        var content = {
            name: metaData.header + '_' + answer,
            value: item[answer] + '/' + total
        };
        calculation.push(content);
    }

    for(var attr in gejala) {
        var coba = tes[attr][gejala[attr]];
        var a = attr.replace('_', ' ');
        a = UCFirst(a);
        if(gejala[attr] == 0) a = neg + " " + a;
        if(!coba[0]) coba[0] = 0;
        if(!coba[1]) coba[1] = 0;

        for(var answer in coba) {
            if(answer != 'jumlah') {
                var item = tes[metaData.result];
                var content = {
                    name: a + '_' + answer,
                    value: coba[answer] + '/' + item[answer]
                };
                calculation.push(content);
            }
        }
    }
    var products = {};
    for(var i = 0, len = calculation.length; i < len; i++) {
        var item = calculation[i];
        var answer = item.name.split('_')[1];
        var fraction = item.value.split('/');
        if(products[answer]) {
            products[answer].numerator *= fraction[0];
            products[answer].denumerator *= fraction[1];
        } else {
            products[answer] = {
                numerator: fraction[0],
                denumerator: fraction[1]
            }
        }
    }
    var result, val;
    for(var answer in products) {
        var item = products[answer];
        var value = parseFloat(item.numerator/item.denumerator);
        if(!result) { result = answer; val = value; }
        if(value > val) { result = answer; val = value; }
        var content = {
            name: verb + ' ' + metaData.header + '_' + answer,
            value: item.numerator + '/' + item.denumerator
        };
        calculation.push(content);
    }
    var optiondata = {
        calculation: calculation,
        result: result,
        meta: metaData
    }
    if(automaticDisplay) {
        displayResult(optiondata);
    }
    return optiondata;
}
function countAttribute(data, key, header=false) {
    var target = {};
    for(var i = 0; i < data.length; i++) {
        var item = data[i], result = item[key];
        if(header) {
            if(target[result]) target[result] += 1;
            else target[result] = 1;
        } else {
            var temp = item.hasil;
            if(target[result]) {
                target[result].jumlah += 1;
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
    }
    return target;
}
function displayResult(optiondata) {
    var calc = optiondata.calculation;
    var meta = optiondata.meta;
    var result = optiondata.result;
    $('.dataRes').remove();
    var body = $(meta.elm_body), row = $(meta.elm_row);
    var final = {}, final_1, final_2;
    for(var i = 0, len = calc.length; i < len; i++) {
        var item = calc[i];
        var left = item.name, right = item.value;
        var dec = right.split('/');
        dec = parseFloat(dec[0] / dec[1]);
        dec = dec.toFixed(3);
        var leftText = left.replace('_', ' | ');
        leftText = 'P(' + leftText + ')';
        leftText = leftText.replace('0', meta.negativeIdentifier);
        leftText = leftText.replace('1', meta.positiveIdentifier);
        var rightText = '= ' + dec;

        var temp = row.clone();
        temp.removeAttr('id').removeClass('looptemplate hidden').addClass('dataRes');
        if(leftText.indexOf(meta.finalVerb) > 0) {
            var answer = left.split('_')[1];
            final[answer] = dec;
        } else {
            $('label', temp).css('font-weight', '400');
        }
        $('.kiri', temp).text(leftText);
        $('.kanan', temp).text(rightText);
        body.append(temp);
    }
    // var largest_index, largest_value;
    // for(var answer in final) {
    //     var current = final[answer];
    //     if(largest_value) {
    //         if(current > largest_value) {
    //             largest_index = answer;
    //             largest_value = current;
    //         }
    //     }
    //     else {
    //         largest_index = answer;
    //         largest_value = current;
    //     }
    // }
    var text = '', x = meta.header.toLowerCase();
    var kesimpulan = result == 0 ? meta.negativeIdentifier.toLowerCase() + " " : "";
    kesimpulan += meta.header.toLowerCase();
    if(result == 1) {
        text = 'Karena persentase terkena '+x+' Anda lebih tinggi, maka kemungkinan besar Anda menderita '+x+'.';
    } else {
        text = 'Karena persentase terkena '+x+' Anda lebih rendah, maka besar kemungkinannya bahwa Anda bebas '+x+'.';
    }
    // $('#final').html(text);
    $('#final').html("Kesimpulan : Kemungkinan " + kesimpulan);
}
function UCFirst(string) {
    string = string.toLowerCase().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter) {
        return letter.toUpperCase();
    });
    return string;
}
