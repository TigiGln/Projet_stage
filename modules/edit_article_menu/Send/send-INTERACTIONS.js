/***
 * JS for sending page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/
function validate(id) {
    let newUser = document.getElementById("sendTo").value;
    let url = "./modules/edit_article_menu/Send/validate.php";
    let params = "ID="+encodeURIComponent(id)+"&newUser="+encodeURIComponent(newUser);
    console.log("Send to send req: "+params);
    var http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(params);
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
            console.log('Send successfuly');
            alert("The article was successfully Sent. Return to your tasks");
            document.location.href="/";
          } else {
             console.log('Send failed');
             alert("An error occured. Please retry.");
          }
      }
    }
}