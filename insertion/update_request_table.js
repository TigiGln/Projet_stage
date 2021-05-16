var body = document.getElementsByTagName('body')[0].setAttribute('onload', 'changeColorLigne()');
var insert = document.getElementById('insert').setAttribute('disabled', true);

function changeColorLigne()
{
    var table = document.getElementsByTagName('table')[0];
    var tableRow = table.rows;
    var tableRowLength = tableRow.length;
    var checks = document.getElementsByClassName('check');
    var listNumAccess = [];
    var title = document.getElementsByClassName('note');
    var authors = document.getElementsByClassName('note1');
    for(var i=1; i<tableRowLength; i++)
    {

        tableCells = tableRow[i].cells;
        listNumAccess.push(tableCells[0].innerHTML);
        title[i-1].style.color = '#000';
        title[i-1].style.fontWeight = 'bold';
        title[i-1].style.border = 'none';
        authors[i-1].style.color = '#000';
        authors[i-1].style.fontWeight = 'bold';
        authors[i-1].style.border = 'none';

    }
    listAccessDb = Object.values(listNumAccessDb);
    for(numAccess of listAccessDb)
    {
        var indexNumAccess = listNumAccess.indexOf(numAccess) ;
        if (indexNumAccess !== -1)
        {
            tableRow[indexNumAccess + 1].style.background = "#A9A9A9";
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

function checked_check(coche)
{
    var arraycheck = [];
    var insert = document.getElementById('insert');
    var globalCheck = document.getElementById('global_check');
    var checkboxes = document.getElementsByClassName('check');;
    for(element of checkboxes)
    {
        if (element.checked == true)
        {
            arraycheck.push(element)
        }
    }
    if (arraycheck.length >= 1)
    {
        insert.removeAttribute('disabled');
    }
    else
    {
        insert.setAttribute('disabled', true);
    }
    if (arraycheck.length != checkboxes.length)
    {
        globalCheck.checked = false;
    }
    else
    {
        globalCheck.checked = true;
    }
    
    
}