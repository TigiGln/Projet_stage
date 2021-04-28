/*
 * Created on Tue Apr 21 2021
	* Latest update on Wed Apr 28 2021
 * Info - JS for notes module in edit article menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

const logHeaderNotesInteractions = "[edit article menu : notes module]";
notesInteractionsLoadNotes();

/**
 * notesInteractionsLoadNotes is a method calling a function to get the article's ID.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
function notesInteractionsLoadNotes() {
  let header = document.getElementById('notes');
  let id = header.dataset.article;
  notesLoad(id, 0);
  notesLoad(id, 1);
}

/**
 * notesSave is the specific function to save user's notes.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} id 
 *            The article ID in the database.
 * @fires XMLHttpRequest
 */
 function notesSave(id) {
  /* Prepare request */
  document.querySelector('#notesCode').click();
  let url = "./modules/edit_article_menu/notes/save-notes.php";
  let notes = document.querySelector("#notesHtmlView").textContent;
  let date = (new Date()).getTime(); //Until I find a way to get date from the php
  document.querySelector('#notesCode').click();
  let params = "ID="+encodeURIComponent(id)+"&date="+encodeURIComponent(date)+"&notes="+encodeURIComponent(notes);
  console.log(logHeaderNotesInteractions+" Notes save send request with parameters: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        //if success, call the update article function
        if (http.status === 200) {
          console.log(logHeaderNotesInteractions+' Notes saved successfuly with status code: '+this.status);
          document.querySelector("#notesArea").style.backgroundColor = "white";
        } else {
           console.log(logHeaderNotesInteractions+' Notes save failed with status code: '+this.status);
           document.querySelector("#notesArea").style.backgroundColor = "salmon";
        }
    }
  }
}

/**
 * notesLoad allows to load the user's saved notes, as well as others' notes.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} id 
 * @param {*} all 
 *            If all value is 0, the server will request the user's notes. If 1, the server will request others' notes.
 * @fires XMLHttpRequest
 */
function notesLoad(id, all) {
  /* Prepare request */
  let url = "./modules/edit_article_menu/notes/load-notes.php";
  let params = "ALL="+all+"&ID="+encodeURIComponent(id);
  console.log(logHeaderNotesInteractions+" Notes Load with parameters: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("GET",url+"?"+params,true);
  http.send(null);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
      console.log(logHeaderNotesInteractions+' Notes received successfuly with status code: '+this.status);
      let res = this.response.toString().split(',');
      if(res[0] == 'USER') { notesLoadUser(res[1]); }
      if(res[0] == 'OTHERS') { notesLoadOthers(res); }
      } else { 
        document.querySelector("#notes").innerHTML = '<div class="alert alert-danger" role="alert">An error occured. Please reload to use this module</div>';
        console.log(logHeaderNotesInteractions+' Notes received failed with status code: '+this.status); 
      }
    } 
  }
}

/**
 * notesLoadUser is the specific function to load the user's saved notes.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} content 
 *            The text that will be inside the user's notes part.
 */
function notesLoadUser(content) {
  document.querySelector("#notesCode").click();
  document.querySelector("#notesHtmlView").textContent = decodeURIComponent(content);
  document.querySelector("#notesCode").click();
}

/**
 * notesLoadOthers is the specific function to load the others' saved notes.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} content 
 *            A to-be-parsed string separated with coma and semicolon.
 */
function notesLoadOthers(content) {
  content.shift();
  for (let note of content) {
    let data = note.split(";");
    document.getElementById("notesThread").innerHTML += 
    '<div class="card m-0 p-0"><div class="card-header m-0 p-1">['+decodeURIComponent(data[1])+'] '+decodeURIComponent(data[0])
    +'</div><div class="card-body m-0 p-1">'+decodeURIComponent(data[2])+'</div></div>';
  }
}

/**
 * Listener on visual view area that will change the background color of the notes area to salmon on input event.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
document.getElementById("notesVisualView").addEventListener("input", function() {
  document.querySelector("#notesArea").style.backgroundColor = "salmon";
});

/**
 * Listener on visual html area that will change the background color of the notes area to salmon on input event.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
document.getElementById("notesHtmlView").addEventListener("input", function() {
  document.querySelector("#notesArea").style.backgroundColor = "salmon";
});