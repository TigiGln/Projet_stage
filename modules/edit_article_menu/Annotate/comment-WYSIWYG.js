/***
 * JS for comment page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* WYSIWYG function */
/*******************************************************************************/

//Store WYSIWYG elements
const commentEditor = document.getElementsByClassName('commentEditor')[0];
const commentToolbar = commentEditor.getElementsByClassName('commentToolbar')[0];
const commentButtons = commentToolbar.querySelectorAll('.commentAction');
const commentArea = document.getElementById('commentArea');
const commentVisualView = document.getElementById('commentVisualView');
const commentHtmlView = document.getElementById('commentHtmlView');
//For each element in the action (button) line, add event listener onClick
for(let i = 0; i < commentButtons.length; i++) {
  let button = commentButtons[i];
  button.addEventListener('click', function(e) {
    //Store the action from its data-action
    let action = this.dataset.action;
    switch(action) {
      //replace stylized input zone with html input zone (and reverse)
      case 'code':
        commentCodeAction(this, commentEditor);
        break;
      //add a clickable link
      case 'createLink':
        commentLinkAction();
        break;
      //default actions (bold, italic, underline, unlink, redo, remove)
      default:
        commentDefaultAction(action);
    } 
  });
}

/**
 * codeAction:
 * if stylized input zone is drawn, hide it and draw the html input zone.
 * if html input zone is drawn, hide it and draw the stylized input zone.
 * @param {*} button 
 * @param {*} commentEditor
 */
function commentCodeAction(button, commentEditor) {
  if(button.classList.contains('active')) {
    //Close Code
    commentVisualView.innerHTML = commentHtmlView.value;
    commentHtmlView.style.display = 'none';
    commentVisualView.style.display = 'block';
    button.classList.remove('active');   
  } else { 
    //Open Code
    commentHtmlView.innerText = commentVisualView.innerHTML;
    commentVisualView.style.display = 'none';
    commentHtmlView.style.display = 'block';
    button.classList.add('active'); 
  }
}

/**
 * linkAction:
 * allows to write a clickable link.
 */
function commentLinkAction() {
  let linkValue = prompt('Please insert a link');
  document.execCommand('createLink', false, linkValue);
}

/**
 * defaultAction:
 * apply the execCommand function.
 * @param {*} action 
 */
function commentDefaultAction(action) {
  document.execCommand(action, false);
}