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
  notesLoad(id, 0);
  notesLoad(id, 1);
}
/**
 * notesLoad:
 * Allows to load the user previous
 * @param {*} pmcid 
 */
function notesLoad(id, all) {
  //todo: query to load-notes to get the data then write it
  let url = "./modules/edit_article_menu/notes/load-notes.php";
  let params = "ALL="+all+"&ID="+encodeURIComponent(id);
  console.log("load notes with query: "+params);
  var http = new XMLHttpRequest();
  http.open("GET",url+"?"+params,true);
  http.send(null);
  http.onreadystatechange=function() {
    if (this.readyState==4) {
      if (this.status==200) {
      console.log('notes received successfuly ');
      let res = this.response.toString().split(',');
      if(res[0] == 'USER') { notesLoadUser(res[1]); }
      if(res[0] == 'OTHERS') { notesLoadOthers(res); }
      } else { console.log('notes received failed'); }
    } 
  }
}

function notesLoadUser(content) {
  content = content.split(';')[2];
  document.querySelector("#notesCode").click();
  document.querySelector("#notesHtmlView").textContent = decodeURIComponent(content);
  document.querySelector("#notesCode").click();
}

function notesLoadOthers(content) {
  console.log(content);
  content.shift();
  for (let note of content) {
    let data = note.split(";");
    document.getElementById("notesThread").innerHTML += 
    '<div class="card m-0 p-0"><div class="card-header m-0 p-1">['+decodeURIComponent(data[1])+'] '+decodeURIComponent(data[0])
    +'</div><div class="card-body m-0 p-1">'+decodeURIComponent(data[2])+'</div></div>';
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
  //need to change space with %20 cause php chaneg then with +
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