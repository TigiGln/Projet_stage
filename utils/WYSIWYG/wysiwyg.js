//WYSIWYG ZONE
const editor = document.getElementsByClassName('editor')[0];
const toolbar = editor.getElementsByClassName('toolbar')[0];
const buttons = toolbar.querySelectorAll('.action');
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
  const commentArea = editor.getElementsByClassName('comment-area')[0];
  const visuellView = commentArea.getElementsByClassName('visual-view')[0];
  const htmlView = commentArea.getElementsByClassName('html-view')[0];

  if(button.classList.contains('active')) {
    visuellView.innerHTML = htmlView.value;
    htmlView.style.display = 'none';
    visuellView.style.display = 'block';

    button.classList.remove('active');     
  } else { 
    htmlView.innerText = visuellView.innerHTML;
    visuellView.style.display = 'none';
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
    isOpen = false;
    document.getElementById("editor").style.visibility = "hidden";
  }
}
function commentSend() {
  if(isOpen) {
    //Save
  }
}
//Mouse up, when we release button
document.addEventListener("mouseup", function() {
  if(document.getSelection() && !isOpen && document.getSelection().toString().length > 0) {
    document.getElementById("editor").style.visibility = "visible";
    document.querySelector("#selection").textContent = document.getSelection();
    isOpen = true;
  } 
});