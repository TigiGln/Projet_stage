function changeStatus(numSelect)
{
    var lineTable = document.getElementById('line_' + numSelect.id); //récupration de ligne du tableau dont le select à été modifié
    var linesTable = document.getElementsByTagName('table')[0].rows;//récupération des lignes du tableau entier pour faire la suppression
    //console.log(linesTable);
    //console.log(numSelect.name.split('_'));
    value_select = numSelect.name.split('_')[0];
    //console.log(name_select)
    for (line of linesTable)//boucle sur le tableau ligne par ligne
    {
        //console.log(line);
        //console.log(numSelect.value);
        if (line.id == lineTable.id)//si correspond à la ligne dont le statut est modifié alors
        {
            valueStatusInitial = line.cells[3].childNodes[0].value;//récupération du status initial de l'article
            //console.log(valueStatusInitial);
            
            document.getElementsByTagName('table')[0].deleteRow(line.rowIndex);//tu supprime la ligne selon son index
            xhttp = new XMLHttpRequest(); //création de l'objet de requête pour accéder aux script php
            /*xhttp.onreadystatechange = function() //action HTML pour le changement d'état
            {
                if (this.readyState == 4 && this.status == 200) 
                {
                    //location.reload();
                }
            };*/
            //ouverture de la requête du script php
            xhttp.open("GET", "update2.php?valueStatusInitial=" + valueStatusInitial + "&" + value_select + "=" + numSelect.value + "&num_acces=" + numSelect.id + "&fields=" + value_select, true);
            //console.log('status initial: ' + valueStatusInitial);
            //console.log('champs: ' + value_select);
            //console.log('valeur à modifier:' + numSelect.value);
            //console.log('pmid de la ligne:' + numSelect.id);
            xhttp.send(); //lancement de la requête
            
        }
    }
}
