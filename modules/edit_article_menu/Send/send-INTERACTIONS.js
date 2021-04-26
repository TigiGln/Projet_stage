/*
 * Created on Fri Apr 23 2021
 * Latest update on Mon Apr 26 2021
 * Info - JS for conclude module in edit article menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

const logHeaderSendInteractions = "[edit article menu : send module]";

/**
 * validateSendInteraction function that will tell the server the new user to which gives the article.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} id 
 *            The ID of the article in the database.
 * @fires XMLHttpRequest
 */
function validateSendInteraction(id) {
  /* Prepare request */
  let newUser = document.getElementById("sendTo").value;
  let url = "./modules/edit_article_menu/Send/validate.php";
  let params = "ID="+encodeURIComponent(id)+"&newUser="+encodeURIComponent(newUser);
  console.log(logHeaderSendInteractions+" Send send with parameters: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          console.log(logHeaderSendInteractions+' Send successfully with status code: '+this.status);
          alert("The article was successfully Sent. Return to your tasks");
          document.location.href="/";
        } else {
          console.log(logHeaderSendInteractions+' Send failed with status code: '+this.status);
          alert("An error occured. Please retry.");
        }
    }
  }
}