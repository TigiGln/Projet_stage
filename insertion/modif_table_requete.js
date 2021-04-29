var body = document.getElementsByTagName('body')[0].setAttribute('onload', 'changeColorLigne()');

function changeColorLigne()
{
    var table = document.getElementsByTagName('table')[0];
    console.log(table);
    var tableRow = table.rows;
    var tableRowLength = tableRow.length;
    var checks = document.getElementsByClassName('check');
    console.log(checks);

    var listpmid = [];
    for(i=0; i<tableRowLength; i++)
    {
        console.log(i);
        tableCells1 = tableRow[i].cells;
        listpmid.push(tableCells1[0].innerHTML)

    }
    var listepmid = ["54"];
    
    for(pmid of listepmid)
    {
        
        var pmid1 = listpmid.indexOf(pmid);
        if ( pmid !== -1)
        {
            
            tableRow[pmid1].style.background = "yellow";
            //checks[listpmid.indexOf("33524")-1].setAttribute('disabled', true);
            checks[pmid1-1].style.display = 'none';
        }
        else
        {
            console.log("no")
        }
    }   
    //console.log(tableRow);
    //tableCells = tableRow[0].cells;
    //console.log(tableCells[0].innerHTML);*/

}