function toggleFilter(table,colToFilter,colMax){
    // table: tableau de donnée a filtrer
    // colToFilter : array avec les n°de colonnes a metre un filtre
    // colMax: nombre de colonne du tableau

    // *** ---- mise en place de la barre de filtre --- ****

    var tableTbody=table.children('tbody');
    var tableContent=tableTbody.html();
    var filter=createFilter(colToFilter,colMax);
    var newContent=filter+tableContent;
    tableTbody.html(newContent);

    // **** --------------------------- ********

    var filterLine=table.find('tr.filter');
    table.find('input').keyup(function(){
        showLine(table); // on affiche toute les lignes

        var col=[];
        table.find('tr td input').each(function(){       //   création tableau des colonnes comportants des input
            col.push($(this).parent('td').index()+1);
        });

        col.forEach(function(index){
            var value=filterLine.find('td:nth-child('+index+') input').val();
            if(value!=''){
                hideLine(tableTbody,index,value);  // cache des tr suivant les filtre
            }
        });
    });
}

function showLine(table){
    table.find('tr').show();
}

function hideLine(tbody,col,value){
    tbody.find(' td:nth-child('+col+'):not(:contains('+value+'))').parent('tr:not(.filter)').hide();
}

function createFilter(colToFilter,colMax){
    var tdInput='<td><input type="text" ></td>';
    var td='<td></td>';
    var FilterHtml='';

    for(var i=1;i<colMax+1;i++){
        if(colToFilter.includes(i)){
            FilterHtml=FilterHtml+tdInput;
        }
        else{
            FilterHtml=FilterHtml+td;
        }
    }
    return '<tr class="filter">'+FilterHtml+'</tr>';
}