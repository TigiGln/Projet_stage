var body = document.getElementsByTagName('body')[0].setAttribute('onload', 'changeColorLigne()');

function changeColorLigne()
{
    var table = document.getElementsByTagName('table')[0];
    var tableRow = table.rows;
    var tableRowLength = tableRow.length;
    var checks = document.getElementsByClassName('check');
    var listNumAccess = [];
    for(var i=1; i<tableRowLength; i++)
    {
        tableCells1 = tableRow[i].cells;
        listNumAccess.push(tableCells1[0].innerHTML)

    }
    listAccessDb = Object.values(listNumAccessDb);
    for(numAccess of listAccessDb)
    {
        var indexNumAccess = listNumAccess.indexOf(numAccess) ;
        if (indexNumAccess !== -1)
        {
            tableRow[indexNumAccess + 1].style.background = "yellow";
            checks[indexNumAccess].setAttribute('disabled', true);
            //checks[indexNumAccess].style.display = 'none';
        }
    }
}

function check(source) 
{
    checkboxes = document.querySelectorAll("input[name^='check']");
    for(var i=0, n=checkboxes.length;i<n;i++) 
    {
        if (checkboxes[i].disabled == false)
        {
            checkboxes[i].checked = source.checked;
        }
        
    }
}