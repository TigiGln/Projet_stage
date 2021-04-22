/***
 * JS for conclude page
 * author: Eddy IKHLEF
***/

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

function validate(id) {;
    let url = "./modules/edit_article_menu/Conclude/validate.php";
    let date = (new Date()).getTime();
    let params = "ID="+encodeURIComponent(id)+"&date="+encodeURIComponent(date);
    console.log("validate send req: "+params);
    var http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(params);
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
            console.log('validate successful');
            alert("The article was successfully proccessed. Return to your tasks");
            document.location.href="/";
          } else {
             console.log('validate failed');
          }
      }
    }
}