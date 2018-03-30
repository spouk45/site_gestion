function printTab(data,title){
    if(data==''){
        return 'Aucune donnée';
    }
    if(title==''){
        return 'donnée manquante pour affichage';
    }

    var arrayTitle='';
     $.each(title,function(key,value){
      arrayTitle+='<th>'+value+'</th>'
        });

    var tr='';

   var td='';

        $.each(data, function (key, value) {
            tr+='<tr class="row" id="tr' + value.id + '" data-tr-id="' + value.id + '" >' +
                $.each(title, function (key2, value2) {
                    if (value.key2) {
                        td+='<td>'+value2+'</td>';

                    }else{
                        td+='<td></td>';
                        //alert(value[key2]);
                    }
                })+'</tr>';

        });


    return tab='<table class="divTab">'+
             '<thead>'+
                '<tr>' +
                    arrayTitle +
                 '</tr>' +
            '</thead>' +
            '<tbody>' +
                tr +
            '</tbdoy>' +
        '</table>';


}