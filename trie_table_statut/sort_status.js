function changeStatus(numSelect)
{
    var lineTable = document.getElementById('line_' + numSelect.id); //récupration de ligne du tableau dont le select à été modifié
    var linesTable = document.getElementsByTagName('table')[0].rows;//récupération des lignes du tableau entier pour faire la suppression
    //console.log(linesTable);
    for (line of linesTable)//boucle sur le tableau ligne par ligne
    {
        //console.log(line);
        if (line.id == lineTable.id)//si correspond à la ligne dont le statut est modifié alors
        {
            //
            xhttp = new XMLHttpRequest(); //création de l'objet de requête pour accéder aux script php
            xhttp.onreadystatechange = function() //action HTML pour le changement d'état
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementsByTagName('table')[0].deleteRow(line.rowIndex)//tu supprime la ligne selon son index
                }
            };
            xhttp.open("GET", "update2.php?status=" + numSelect.value + "&id=" + numSelect.id, true);//ouverture de la requête du script php
            xhttp.send(); //lancement de la requête
        }
    }
}