/*
 * Created on Fri Apr 23 2020
 * Latest update on Mon Apr 26 2021
 * Info - JS for conclude module in edit article menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

const logHeaderConcludeInteractions = "[edit article menu : conclude module]";

/**
 * validateConcludeInteraction function that will give the new status of the article to conclude or proccessed.
 * @param {*} id 
 *            The ID of the article in the database.
 * @fires XMLHttpRequest
 */
function validateConcludeInteraction(id) {
  /* Prepare request */
  let url = "./modules/edit_article_menu/Conclude/validate.php";
  let date = (new Date()).getTime();
  let params = "ID="+encodeURIComponent(id)+"&date="+encodeURIComponent(date);
  console.log(logHeaderConcludeInteractions+" Validate send with parameters: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          console.log(logHeaderConcludeInteractions+' Validate successfully with status code: '+this.status);
          alert("The article was successfully proccessed. Return to your tasks");
          document.location.href="/";
        } else {
          console.log(logHeaderConcludeInteractions+' Validate failed with status code: '+this.status);
          alert("An error occured. Please retry.");
        }
    }
  }
}