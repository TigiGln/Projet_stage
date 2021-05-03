/*
 * Created on Mon May 3 2021
 * Latest update on Mon May 3 2021
 * Info - JS for annotate threads module in edit article menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

const logHeaderAnnotateThreadsInteractions = "[edit article menu : annotate Threads module]";
const annotateThreadsArtID = new URLSearchParams(window.location.search).get("NUMACCESS");

/**
 * annotateShow is a function that will show the selected annotation, allowing to reply to this.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} id 
 */
function annotateShow(id) {
  let annotation = document.getElementById("link_"+id);
  let tag = annotation.dataset.bsOriginalTitle;
  let content  = annotation.dataset.bsContent;
  let selection = document.getElementById("selectedAnnotation");
  selection.innerHTML = content+"<br>-----<br>"+tag+"<br>at: "+annotation.innerHTML;
  selection.style.pointerEvents = "all";
  selection.style.userSelect = "all";
  annotateRepliesLoad(annotateThreadsArtID , id);
  if(!document.querySelector('#article-AnnotateThreads').classList.contains("show")) { document.querySelector('#AnnotateThreadsBtn').click(); }
}

/**
 * annotateReplySend is a function that will send the user's reply to an annotation.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} artID 
 * @param {*} commentId 
 * @fires XMLHttpRequest
 */
function annotateReplySend(artID, commentId) {
  let id = artID+"_"+commentId;
  let text = document.getElementById("annotatesReply").value;
  let url = "./modules/edit_article_menu/AnnotateThreads/save-reply.php";
  let params = "ID="+id+"&text="+text;
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          console.log(logHeaderAnnotateThreadsInteractions+" annotate reply sent successfully with status code: "+this.status);
          text = "";
          annotateRepliesLoad(artID , commentId);
        } else {
          console.log(logHeaderAnnotateThreadsInteractions+" annotate reply failed with status code: "+this.status);
          return false;
        }
    }
  }
}

/**
 * annotateReplyLoad is a function that will load the correct replies to an annotation.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} artID 
 * @param {*} commentId 
 * @fires XMLHttpRequest
 */
 function annotateRepliesLoad(artID, commentId) {
  let id = artID+"_"+commentId;
  let url = "./modules/edit_article_menu/AnnotateThreads/load-replies.php";
  let params = "ID="+id;
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("GET", url+"?"+params, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(null);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          let replies = JSON.parse(http.response);
          annotateFillReplies(commentId, replies);
          console.log(logHeaderAnnotateThreadsInteractions+" annotate replies receive successfully with status code: "+this.status);
        } else {
          annotateFillReplies(commentId, []);
          console.log(logHeaderAnnotateThreadsInteractions+" annotate replies receive failed with status code: "+this.status);
        }
    }
  }
}

/**
 * annotateFillReplies will write replies and write reply zone.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} id 
 * @param {*} replies 
 */
function annotateFillReplies(id, replies) {
  let thread = "";
  for (let i = 1; i<replies.length; i++) {
    let reply = replies[i];
    thread = '<div class="card m-0 p-0"><div class="card-header m-0 p-1">['+decodeURIComponent(reply["date"])+'] '+decodeURIComponent(reply["@attributes"]["name"])
              +'</div><div class="card-body m-0 p-1">'+decodeURIComponent(reply["content"])+'</div></div>' + thread;
  }
  document.getElementById("AnnotationRepliesThread").innerHTML = '<div class="card"><div class="card-body"><textarea id="annotatesReply" rows="1"></textarea>'
  +'<button id="annotateReplySend" type="button" class="btn btn-outline-success btn-sm w-100" style="pointer-events: all; user-select: all;" onclick="annotateReplySend(\''+annotateThreadsArtID+'\', \''+id+'\')" >Send reply</button></div></div>'+thread;
}