//WYSIWYG ZONE
const editor = document.getElementsByClassName('editor')[0];
const toolbar = editor.getElementsByClassName('toolbar')[0];
const buttons = toolbar.querySelectorAll('.action');

const commentArea = document.getElementById('comment-area');
const visualView = document.getElementById('visual-view');
const htmlView = document.getElementById('html-view');

for(let i = 0; i < buttons.length; i++) {
  let button = buttons[i];
  button.addEventListener('click', function(e) {
    let action = this.dataset.action;
    
    switch(action) {
      case 'code':
        codeAction(this, editor);
        break;
      case 'createLink':
        linkAction();
        break;
      default:
        defaultAction(action);
    }
    
  });
}


/* ACTIONS */

function codeAction(button, editor) {
  if(button.classList.contains('active')) {
    //Close Code
    visualView.innerHTML = htmlView.value;
    htmlView.style.display = 'none';
    visualView.style.display = 'block';
    button.classList.remove('active');   
  } else { 
    //Open Code
    htmlView.innerText = visualView.innerHTML;
    visualView.style.display = 'none';
    htmlView.style.display = 'block';
    button.classList.add('active'); 
  }
}

function linkAction() {
  let linkValue = prompt('Please insert a link');
  document.execCommand('createLink', false, linkValue);
}

function defaultAction(action) {
  document.execCommand(action, false);
}

/* DOM */
//todo: if mark exist, can't comment. Function to show comment when we click
var isOpen = false;
var commentID = -1;

//Action button on editor.
function commentClose() {
  if(isOpen) {
    //Remove temp tag if we didn't saved the comment
    if(!!document.getElementById("temp")) {
      let article = document.getElementById("article").innerHTML;
      let data = document.getElementById("temp").innerHTML;
      document.getElementById("article").innerHTML = article.replace(/(<span id="temp">).*?(<\/span>)/s, data);
    }
    //Close window
    document.getElementById("editor").style.visibility = "hidden";
    isOpen = false;
  }
}

function commentSend(pmcid) {
  if(isOpen) {
    //Save
    document.querySelector('#code').click();
    let url = "./utils/WYSIWYG/save.php";
    let color = document.getElementById("colorPicker").value;
    let text = document.getElementById("selection").innerHTML;
    let comment = document.querySelector("#html-view").textContent;
    let date = (new Date()).getTime(); //Until I find a way to get date from the php
    let params = "PMCID="+pmcid+"&date="+date+"&color="+color+"&text="+text+"&comment="+comment;
    params = params.replaceAll(" ", "%20");
    console.log("REQUEST: "+params);
    //start request
    var http = new XMLHttpRequest();
    http.open("POST", url, true);
    //tell the header that we sent params
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(params);
    //message received to notify the success or a failure (CALLBACK)
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
            //var toast =document.getElementById('toast-success');//select id of toast
            //var notify = new bootstrap.Toast(toast);//inizialize it
            //notify.show();
            console.log('successful');
            updateArticle(pmcid, date, color, text, comment);
            commentClose();
          } else {
             console.log('failed');
             commentClose();
          }
      }
    }
  }
}

function updateArticle(pmcid, date, color, text, comment) {
  //add highlight
  let article = document.getElementById("article").innerHTML;
  let highlight = '<a id=mark_"'+date+'" class="note" data-bs-toggle="popover" data-bs-trigger="hover focus" data-placement="bottom" data-bs-html="true" title="'+
  '['+pmcid+':'+date+']"'+' data-bs-content="'+comment+'">'+'<mark style="background-color: '+color+';">'+text+'</mark>'+'</a>';
  document.getElementById("article").innerHTML = article.replace(/(<span id="temp">).*?(<\/span>)/s, highlight);
  //Need to refresh popOvers since we added a new one.
  refreshPopovers();
}

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

//Mouse up, when we release button
document.addEventListener("mouseup", function() {
  if(document.getSelection() && !isOpen && document.getSelection().toString().length > 0) {
    document.getElementById("editor").style.visibility = "visible";
    document.querySelector("#selection").textContent = document.getSelection();
    document.querySelector("#visual-view").textContent = "Your Comment";
    document.querySelector("#html-view").textContent = "Your Comment";
    isOpen = true;
    //Add temp balise to know we change this one
    addTempTag();
  } 
});
