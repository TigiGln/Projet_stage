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
    document.querySelector("#commentArea").style.backgroundColor = "white";
    //Uncomment next line to auto-hide annotation menu on close
    //if(document.querySelector('#article-Annotate').classList.contains("show")) { document.querySelector('#AnnotateBtn').click(); }
    //Always refresh popOvers
    refreshPopovers();
  }
}

function commentUndo(id) {
  //remove mark and link if exist
  if (!!document.getElementById("mark_"+id)) document.getElementById("mark_"+id).outerHTML = document.getElementById("link_"+id).innerHTML;
  //remove undo button if exist
  if(!!document.getElementById("commentUndo")) document.getElementById("commentUndo").outerHTML = "";
  document.querySelector("#commentArea").style.backgroundColor = "salmon";
  //todo remove from database too
}

/**
 * commentSend:
 * Will send the comment part to the database, edit the current articl html and
 * will update the html of the article in the database.
 * @param {*} id 
 */
function commentSend(id) {
  if(isOpen) {
    //Parse element to prepare the query
    document.querySelector('#commentCode').click();
    let url = "./modules/edit_article_menu/Annotate/save-comment.php";
    let color = document.getElementById("commentColorPicker").value;
    let text = document.getElementById("temp").innerHTML;
    let comment = document.querySelector("#commentHtmlView").textContent;
    //let date = (new Date()).toLocaleDateString();
    document.querySelector('#commentCode').click();
    //let params = "PMCID="+encodeURIComponent(pmcid)+"&date="+encodeURIComponent(date)+"&color="+encodeURIComponent(color)+"&text="+encodeURIComponent(text)+"&comment="+encodeURIComponent(comment);
    let params = "ID="+encodeURIComponent(id)+"&color="+encodeURIComponent(color)+"&text="+encodeURIComponent(text)+"&comment="+encodeURIComponent(comment);
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
            let res = this.response.toString().split(',');
            let result = updateArticle(id, res[0], res[1],  color, text, comment);
            if (result) {
              commentClose();
              let commentID = "'"+res[0].toString()+"'";
              document.getElementById("commentInteraction").innerHTML = '<button id="commentUndo" type="button" class="btn btn-warning" style="pointer-events: all; user-select: all;" onclick="commentUndo('+commentID+')" >R</button>'
                                                          + document.getElementById("commentInteraction").innerHTML;
            }
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
 * @param {*} id 
 * @param {*} date 
 * @param {*} color 
 * @param {*} text 
 * @param {*} comment 
 */
function updateArticle(id, date, author, color, text, comment) {
  //add highlight
  let article = document.getElementById("article").innerHTML;
  let highlight = '<mark id=mark_'+date+' style="background-color: '+color+';"><a id=link_'+date+' class="note" data-artID='+id+' data-bs-toggle="popover" data-bs-trigger="hover focus" data-placement="bottom" data-bs-html="true" title="'+
  '['+date+'] '+author+'"'+' data-bs-content="'+comment+'">'+text.toString()+'</a></mark>';
  console.log("test: "+highlight);
  document.getElementById("temp").outerHTML = highlight;
  article = document.getElementById("article").innerHTML;
  //get the article html and sent it to database
  let url = "./modules/edit_article_menu/Annotate/save-article.php";
  let params = "ARTICLE="+encodeURIComponent(article)+"&ID="+encodeURIComponent(id);
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
          document.querySelector("#commentArea").style.backgroundColor = "palegreen";
        } else {
            console.log('article sent failed');
            return false;
        }
    }
  }
  return true;
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
          range = sel.getRangeAt(0);
          var container = document.createElement("div");
          for (var i = 0, len = sel.rangeCount; i < len; ++i) {
            container.appendChild(sel.getRangeAt(i).cloneContents());
          }
          //remove potential mark inside
          /* Known Issues: OuterHTML isn't used, hence if a link may cause issues*/
          let text = container.innerHTML.replace(/(<a id="mark_).*?(<mark).*?(>)/, '').replace('(</mark></a>)', '');
          var html = '<span id="temp">' + text + '</span>';
          range.deleteContents();
          var el = document.createElement("div");
          el.innerHTML = html;
          var frag = document.createDocumentFragment(), node, lastNode;
          while ( (node = el.firstChild) ) { lastNode = frag.appendChild(node); }
          range.insertNode(frag);
          return container.innerHTML;
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
    //Add temp balise to know we change this one
    let text = addTempTag();
    //Initialize the text
    document.querySelector("#selection").innerHTML = text;
    document.querySelector("#commentVisualView").textContent = "Your Comment";
    document.querySelector("#commentHtmlView").textContent = "Your Comment";
    document.querySelector("#commentArea").style.backgroundColor = "white";
    if(!!document.getElementById("commentUndo")) {
      document.getElementById("commentUndo").outerHTML = "";
    }
    isOpen = true;
    //open menu if close
    if(!document.querySelector('#article-Annotate').classList.contains("show")) { document.querySelector('#AnnotateBtn').click(); }
  } 
});