/***
 * JS for notes page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/
window.onload = function() {
  let header = document.getElementById('notes');
  let id = header.dataset.article;
  notesLoad(id);
}
/**
 * notesLoad:
 * Allows to load the user previous
 * @param {*} pmcid 
 */
function notesLoad(id) {
  //todo: query to load-notes to get the data then write it
  let url = "./modules/edit_article_menu/notes/load-notes.php";
  let params = "PMCID="+encodeURIComponent(id);
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  //header init
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //Send the datas
  http.send(params);
  //message received to notify the success or a failure (CALLBACK)
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        //if success, call the update article function
        if (http.status === 202) {
          console.log('notes saved successfuly');
        } else {
           console.log('notes saved failed');
        }
    }
  }
}


/**
 * notesSave:
 * Will save the user notes in the database
 * @param {*} pmcid 
 */
function notesSave(pmcid) {
  //Parse element to prepare the query
  document.querySelector('#notesCode').click();
  let url = "./modules/edit_article_menu/notes/save-notes.php";
  let notes = document.querySelector("#notesHtmlView").textContent;
  let date = (new Date()).getTime(); //Until I find a way to get date from the php
  document.querySelector('#notesCode').click();
  let params = "PMCID="+encodeURIComponent(pmcid)+"&date="+encodeURIComponent(date)+"&notes="+encodeURIComponent(notes);
  console.log("notes send req: "+params);
  //Start request to store in the note database by calling start.php script
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  //header init
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  //Send the datas
  http.send(params);
  //message received to notify the success or a failure (CALLBACK)
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        //if success, call the update article function
        if (http.status === 200) {
          console.log('notes saved successfuly');
        } else {
           console.log('notes saved failed');
        }
    }
  }
}