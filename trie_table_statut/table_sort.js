var compare = function(ids, asc)
{
    return function(row1, row2)
    {
        var tdValue = function(row, ids)
        {
            return row.children[ids].textContent;  
        }
        var tri = function(v1, v2)
        {
            if (v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2))
            {
                return v1 - v2;
            }
            else 
            {
                return v1.toString().localeCompare(v2);
            }
        };
        return tri(tdValue(asc ? row1 : row2, ids), tdValue(asc ? row2 : row1, ids));
    }
}

var tbody = document.querySelector('tbody'); 
var headsTable = document.querySelectorAll('th');
var headsSortTable = document.querySelectorAll('th.sort_column');
var linesTable = tbody.querySelectorAll('tr');
headsSortTable.forEach(function(headSort)
{
    
    headSort.addEventListener('click', function()
    {
        //La partie this.asc = !this.asc permet de définir un booléen dont la valeur logique va être inversée à chaque clic sur un élément d’en-tête. 
        //Cela va nous permettre ensuite de choisir l’ordre de tri.
        var linesSort = Array.from(linesTable).sort(compare(Array.from(headsTable).indexOf(headSort), this.asc = !this.asc));
        linesSort.forEach(function(line)
        {
            tbody.appendChild(line)
        });
    })
});