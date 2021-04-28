/*
 * Created on Web Apr 28 2021
 * Latest update on Web Apr 28 2021
 * Info - JS for grade module in edit article menu
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

/*******************************************************************************/
/* interactions function */
/*******************************************************************************/

const logHeaderGradeInteractions = "[edit article menu : grade module]";
initGradeInteractions();

/**
 *  initGradeInteractions is a method to initialize the grading system.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */
function initGradeInteractions() {
  let stars = document.querySelectorAll(".rat-star");
  let boxes = document.querySelectorAll(".rat-box");
  gradeResetColors(stars);
  for (let i = 0; i < stars.length; i++) {
    let star = stars[i];
    star.addEventListener("mouseenter", function() {
      gradeResetColors(stars);
      gradeUpdateColors(stars, i);
    });
    star.addEventListener("mouseleave", function() {
      gradeResetColors(stars);
    });

    boxes[i].addEventListener("click", function() {
      gradeResetShapes(stars);
      gradeUpdateShapes(stars, i);
      gradeUpdateDB(i);
    });
	}
  getUsergrade();
}

/**
 * getUsergrade is a method to get user grade for this article.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @fires XMLHttpRequest
 */
function getUsergrade() {
  let stars = document.querySelectorAll(".rat-star");
  /* Prepare request */
  let header = document.getElementById('notes');
  let id = header.dataset.article;
  let url = "./modules/edit_article_menu/Grade/getUserGrade.php";
  let params = "?ID="+encodeURIComponent(id);
  console.log(logHeaderGradeInteractions+" Request user grade for article: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("GET", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          let value = JSON.parse(this.response)['notes'];
          gradeResetShapes(stars);
          gradeUpdateShapes(stars, value);
          console.log(logHeaderSendInteractions+' Request users List successfully with status code: '+this.status);
        } else {
          document.querySelector("#grade").innerHTML = '<div class="alert alert-danger" role="alert">An error occured. Please reload to use this module</div>';
          console.log(logHeaderSendInteractions+' Request users List failed with status code: '+this.status);
        }
    }
  }
}

/**
 * gradeUpdateDB is a method to update the grade onto the database.
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} grade 
 *            The grade that will be given to this article.
 */
function gradeUpdateDB(grade) {
  /* Prepare request */
  grade++;
  let header = document.getElementById('notes');
  let id = header.dataset.article;
  let url = "./modules/edit_article_menu/Grade/validate.php";
  let params = "ID="+encodeURIComponent(id)+"&GRADE="+encodeURIComponent(grade);
  console.log(logHeaderGradeInteractions+" Validate send with parameters: "+params);
  /* Fires request */
  var http = new XMLHttpRequest();
  http.open("POST", url, true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  http.send(params);
  /* Handle request results */
  http.onreadystatechange = function() {
    if (http.readyState === 4) {
        if (http.status === 200) {
          console.log(this.response);
          console.log(logHeaderGradeInteractions+' Validate successfully with status code: '+this.status);
        } else {
          console.log(logHeaderGradeInteractionss+' Validate failed with status code: ');
          alert("An error occured. Please retry. "+this.response);
        }
    }
  }
}

/**
 * gradeUpdateColors is a method to visually update the color of the grades. 
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} stars 
 *            The array of "stars" (means, the array of radioboxes that represent the grades).
 * @param {*} index 
 *            The index of the selected "star" (if we click of the thirs star, all star from first star to this one (included) will get the selected color).
 */
function gradeUpdateColors(stars, index) {
  for (let j = index; j >= 0; j--) {
    stars[j].style.color = "#7D74B6";
  }
}

/**
 * gradeUpdateShapes is a method to visually update the shape of the grades. 
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} stars 
 *            The array of "stars" (means, the array of radioboxes that represent the grades).
 * @param {*} index 
 *            The index of the selected "star" (if we click of the thirs star, all star from first star to this one (included) will get the selected shape).
 */
function gradeUpdateShapes(stars, index) {
  for (let j = index; j >= 0; j--) {
    stars[j].textContent = "★";
  }
}

/**
 * gradeUpdateColors is a method to visually reset the color of the grades. 
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} stars 
 *            The array of "stars" (means, the array of radioboxes that represent the grades).
 */
function gradeResetColors(stars) {
  for (let i = 0; i < stars.length; i++) {
    stars[i].style.color = "#56b9c7";
	}
}

/**
 * gradeUpdateColors is a method to visually reset the color of the grades. 
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 * @param {*} stars 
 *            The array of "stars" (means, the array of radioboxes that represent the grades).
 */
function gradeResetShapes(stars) {
  for (let i = 0; i < stars.length; i++) {
    stars[i].textContent = "☆";
	}
}