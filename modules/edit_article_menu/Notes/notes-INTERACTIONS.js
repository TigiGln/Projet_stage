/***
 * JS for notes page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

/**
 * notesLoad:
 * Todo: load user note
 * @param {*} pmcid 
 */


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

/**
 * updateArticle:
 * update the html article by adding the comment highlight block on the selected text.
 * @param {*} pmcid 
 * @param {*} date 
 * @param {*} color 
 * @param {*} text 
 * @param {*} comment 
 */
function updateArticle(pmcid, date, color, text, comment) {
  //add highlight
  let article = document.getElementById("article").innerHTML;
  let highlight = '<a id=mark_"'+date+'" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-placement="bottom" data-bs-html="true" title="'+
  '['+pmcid+':'+date+']"'+' data-bs-content="'+comment+'">'+'<mark style="background-color: '+color+';">'+text+'</mark>'+'</a>';
  document.getElementById("article").innerHTML = article.replace(/(<span id="temp">).*?(<\/span>)/s, highlight);
  article = document.getElementById("article").innerHTML;
  //get the article html and sent it to database
  let url = "./utils/comment/save-article.php";
  let params = "ARTICLE="+encodeURIComponent(article)+"&PMCID="+encodeURIComponent(pmcid);
  console.log("article send req: "+params);
  //Start request
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
          console.log('article sent successful');
        } else {
            console.log('article sent failed');
        }
    }
  }
}