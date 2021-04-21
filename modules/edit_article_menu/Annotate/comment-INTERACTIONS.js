/***
 * JS for comment page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

//Initialize some variables to know if we edit or not.
var isOpen = false;
var commentID = -1;

/**
 * commentClose:
 * Will be called when we abort or send a comment. It will lock user interaction with the comment menu
 * and if we highlighted a text, remove the temp tag.
 */
function commentClose() {
  if(isOpen) {
    //dissalow user interactions
    document.querySelector("#commentEditor").style.pointerEvents = "none";
    document.querySelector("#commentEditor").style.userSelect = "none";
    //Remove temp tag if we didn't saved the comment
    if(!!document.getElementById("temp")) {
      let article = document.getElementById("article").innerHTML;
      let data = document.getElementById("temp").innerHTML;
      document.getElementById("article").innerHTML = article.replace(/(<span id="temp">).*?(<\/span>)/s, data);
    }
    isOpen = false;
    //Close menu if open
    if(document.querySelector('#article-Annotate').classList.contains("show")) { document.querySelector('#AnnotateBtn').click(); }
    //Always refresh popOvers
    refreshPopovers();
  }
}

/**
 * commentSend:
 * Will send the comment part to the database, edit the current articl html and
 * will update the html of the article in the database.
 * @param {*} pmcid 
 */
function commentSend(pmcid) {
  if(isOpen) {
    //Parse element to prepare the query
    document.querySelector('#commentCode').click();
    let url = "./modules/edit_article_menu/Annotate/save-comment.php";
    let color = document.getElementById("commentColorPicker").value;
    let text = document.getElementById("selection").innerHTML;
    let comment = document.querySelector("#commentHtmlView").textContent;
    let date = (new Date()).getTime(); //Until I find a way to get date from the php
    document.querySelector('#commentCode').click();
    let params = "PMCID="+encodeURIComponent(pmcid)+"&date="+encodeURIComponent(date)+"&color="+encodeURIComponent(color)+"&text="+encodeURIComponent(text)+"&comment="+encodeURIComponent(comment);
    console.log("comment send req: "+params);
    //Start request to store in the comment database by calling start.php script
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
            console.log('comment sent successful');
            updateArticle(pmcid, date, color, text, comment);
            commentClose();
          } else {
             console.log('comment sent failed');
             commentClose();
          }
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
  let url = "./modules/edit_article_menu/Annotate/save-article.php";
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

/**
 * addTempTag:
 * add a temporary span with id temp to allows us to find the place we are ommenting in the article.
 */
function addTempTag() {
    var sel, range, node;
    //Within the selection
    if (window.getSelection) {
        sel = window.getSelection();
        //Get selection element, add temp span before and after.
        if (sel.getRangeAt && sel.rangeCount) {
            range = window.getSelection().getRangeAt(0);
            var html = '<span id="temp">' + range + '</span>'
            range.deleteContents();
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) { lastNode = frag.appendChild(node); }
            range.insertNode(frag);
        }
    }
}

//Create an eventListener on mouseUp  button.

document.getElementById("article").addEventListener("mouseup", function() {
  //console.log("sel: ");
  //if it' not already opened in a comment, and if we at least selected one character
  if(document.getSelection() && !isOpen && document.getSelection().toString().length > 0 && document.getSelection().toString().length < 300) {
    //Allows user interactions with the menu
    document.querySelector("#commentEditor").style.pointerEvents = "all";
    document.querySelector("#commentEditor").style.userSelect = "all";
    //Initialize the text
    document.querySelector("#selection").textContent = document.getSelection();
    document.querySelector("#commentVisualView").textContent = "Your Comment";
    document.querySelector("#commentHtmlView").textContent = "Your Comment";
    isOpen = true;
    //Add temp balise to know we change this one
    addTempTag();
    //open menu if close
    if(!document.querySelector('#article-Annotate').classList.contains("show")) { document.querySelector('#AnnotateBtn').click(); }
  } 
});