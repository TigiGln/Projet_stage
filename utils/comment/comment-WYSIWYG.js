/***
 * JS for comment page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* WYSIWYG function */
/*******************************************************************************/

//Store WYSIWYG elements
const editor = document.getElementsByClassName('editor')[0];
const toolbar = editor.getElementsByClassName('toolbar')[0];
const buttons = toolbar.querySelectorAll('.action');
const commentArea = document.getElementById('comment-area');
const visualView = document.getElementById('visual-view');
const htmlView = document.getElementById('html-view');
//For each element in the action (button) line, add event listener onClick
for(let i = 0; i < buttons.length; i++) {
  let button = buttons[i];
  button.addEventListener('click', function(e) {
    //Store the action from its data-action
    let action = this.dataset.action;
    switch(action) {
      //replace stylized input zone with html input zone (and reverse)
      case 'code':
        codeAction(this, editor);
        break;
      //add a clickable link
      case 'createLink':
        linkAction();
        break;
      //default actions (bold, italic, underline, unlink, redo, remove)
      default:
        defaultAction(action);
    } 
  });
}

/**
 * codeAction:
 * if stylized input zone is drawn, hide it and draw the html input zone.
 * if html input zone is drawn, hide it and draw the stylized input zone.
 * @param {*} button 
 * @param {*} editor 
 */
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

/**
 * linkAction:
 * allows to write a clickable link.
 */
function linkAction() {
  let linkValue = prompt('Please insert a link');
  document.execCommand('createLink', false, linkValue);
}

/**
 * defaultAction:
 * apply the execCommand function.
 * @param {*} action 
 */
function defaultAction(action) {
  document.execCommand(action, false);
}