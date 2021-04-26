/***
 * JS for notes page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* WYSIWYG function */
/*******************************************************************************/

//Store WYSIWYG elements
const notesEditor = document.getElementsByClassName('notesEditor')[0];
const notesToolbar = notesEditor.getElementsByClassName('notesToolbar')[0];
const notesButtons = notesToolbar.querySelectorAll('.notesAction');
const notesArea = document.getElementById('notesArea');
const notesVisualView = document.getElementById('notesVisualView');
const notesHtmlView = document.getElementById('notesHtmlView');
//For each element in the action (button) line, add event listener onClick
for(let i = 0; i < notesButtons.length; i++) {
  let button = notesButtons[i];
  button.addEventListener('click', function(e) {
    //Store the action from its data-action
    let action = this.dataset.action;
    switch(action) {
      //replace stylized input zone with html input zone (and reverse)
      case 'code':
        notesCodeAction(this, notesEditor);
        break;
      //add a clickable link
      case 'createLink':
        notesLinkAction();
        break;
      //default actions (bold, italic, underline, unlink, redo, remove)
      default:
        notesDefaultAction(action);
    } 
  });
}

/**
 * codeAction:
 * if stylized input zone is drawn, hide it and draw the html input zone.
 * if html input zone is drawn, hide it and draw the stylized input zone.
 * @param {*} button 
 * @param {*} notesEditor
 */
function notesCodeAction(button, notesEditor) {
  if(button.classList.contains('active')) {
    //Close Code
    notesVisualView.innerHTML = notesHtmlView.value;
    notesHtmlView.style.display = 'none';
    notesVisualView.style.display = 'block';
    button.classList.remove('active');   
  } else { 
    //Open Code
    notesHtmlView.innerText = notesVisualView.innerHTML;
    notesVisualView.style.display = 'none';
    notesHtmlView.style.display = 'block';
    button.classList.add('active'); 
  }
}

/**
 * linkAction:
 * allows to write a clickable link.
 */
function notesLinkAction() {
  let linkValue = prompt('Please insert a link');
  document.execCommand('createLink', false, linkValue);
}

/**
 * defaultAction:
 * apply the execCommand function.
 * @param {*} action 
 */
function notesDefaultAction(action) {
  document.execCommand(action, false);
}