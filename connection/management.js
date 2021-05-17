/*
 * Created on Mon May 17 2021
 * Latest update on Mon May 17 2021
 * Info - JS for members management
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//Which form to show first, comment or remove if you don't want to open a section at start
//showAddForm();

/*******************************************************************************/
/* management function */
/*******************************************************************************/
function addMember() {
    let username = document.getElementById('name_user').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let profile = document.getElementById('profile').value;
    let params = "username="+encodeURIComponent(username)+"&email="+encodeURIComponent(email)+"&password="+encodeURIComponent(password)+"&profile="+encodeURIComponent(profile);
    /* Prepare request */
    let url = "./register.php";
    /* Fires request */
    var http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(params);
    /* Handle request results */
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
            let usersJSON = JSON.parse(this.response);
            for (let i = 0; i < usersJSON.length; i++) {
                let user = usersJSON[i];
                usersList.innerHTML += '<option class="users" value="'+user['name_user']+'"data-profile="'+user['profile']+'" data-id="'+user['id_user']+'">'+user['email']+'</option>';
              }
          } else {
            document.querySelector("#send").innerHTML = '<div class="alert alert-danger" role="alert">An error occured. Please reload.</div>';
          }
      }
    }
}

/*******************************************************************************/
/* show function */
/*******************************************************************************/
function showAddForm() {
    document.getElementById('form').innerHTML = `
    <form class="form-group">
        <div class="form-group pb-4">
            <label for="name_user">Username</label>
            <input class="form-control w-25" type="text" name="name_user" id="name_user" required>
        </div>
        <div class="form-group pb-4">
            <label for="email">Email</label>
            <input class="form-control w-25" type="email" name="email" id="email" required>
        </div>
        <div class="form-group pb-4">
            <label for="password">Password</label>
            <input class="form-control w-25" type="password" name="password" id="password" required>
        </div>
        <div class="form-group pb-4">
            <label>Profile</label>
            <select class="form-select w-25" name="profile" id="profile" required>
                <option value="expert">Expert</option>
                <option value="assistant">Assistant</option>
            </select>
        </div>
        <div class="form-group pb-4">
            <button class="btn btn-outline-success" onclick="addMember()">Add Member</button>
        </div>
    </form>
    `;
    updateButtons("addForm");
}

function showManageForm() {
    document.getElementById('form').innerHTML = `
    <form class="pt-4" method="get" action="register.php" enctype="multipart/form-data">
        <input type="text" list="usersList" id="selectedUser" name="selectedUser" class="form-control w-25" placeholder="Member Name" onChange="showManageUser()" />
        <datalist id="usersList">
        </datalist>
    </form>
    `;
    loadUsersList();
    updateButtons("manageForm");
}

function showManageUser() {
    //Check if value exist
    let selected = document.getElementById("selectedUser").value;
    let all = document.getElementsByClassName("users");
    document.getElementById('formBis').innerHTML = "";
    for(let i = 0; i<all.length; i++) {
        if(selected === all[i].value) {
            document.getElementById('formBis').innerHTML = `
            <form class="pt-4" method="get" action="update.php" enctype="multipart/form-data">
                <div class="form-group pb-4">
                    <label for="name_user">Username</label>
                    <input class="form-control w-25" type="text" name="name_user" id="name_user" value="`+selected+`" required>
                </div>
                <div class="form-group pb-4">
                    <label for="email">Email</label>
                    <input class="form-control w-25" type="email" name="email" id="email" value="`+all[i].innerHTML+`" required>
                </div>
                <div class="form-group pb-4">
                    <label for="password">Password</label>
                    <input class="form-control w-25" type="password" name="password" id="password" required>
                </div>
                <div class="form-group pb-4">
                    <label>Profile</label>
                    <select class="form-select w-25" name="profile" id="profile" required">
                        <option value="expert">Expert</option>
                        <option value="assistant">Assistant</option>
                    </select>
                </div>
                <div class="form-group pb-4">
                    <div class="row">
                    <div class="col-md-auto"><input class="btn btn-outline-success" type="submit" value="Update"></div>
                    <div class="col-md-auto"><button class="btn btn-outline-danger" onClick="deleteUser(`+all[i].dataset.id+`)">Delete</button></div>
                </div>
            </form>
            `;
            break;
        }
    }
}

function updateButtons(id) {
    let buttons = document.getElementsByClassName('formButton');
    for(let i = 0; i<buttons.length; i++) {
        button = buttons[i];
        if(button.id == id) {
            button.classList.remove("btn-outline-info");
            button.classList.add("btn-info");
        } else {
            button.classList.remove("btn-info");
            button.classList.add("btn-outline-info");
        }
    }
}

function loadUsersList() {
    let usersList = document.getElementById('usersList');
    /* Prepare request */
    //If you deleted this module, please change path to use the correct file
    let url = "../modules/edit_article_menu/send/getUsersList.php";
    /* Fires request */
    var http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(null);
    /* Handle request results */
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
            let usersJSON = JSON.parse(this.response);
            for (let i = 0; i < usersJSON.length; i++) {
                let user = usersJSON[i];
                usersList.innerHTML += '<option class="users" value="'+user['name_user']+'"data-profile="'+user['profile']+'" data-id="'+user['id_user']+'">'+user['email']+'</option>';
              }
          } else {
            document.querySelector("#send").innerHTML = '<div class="alert alert-danger" role="alert">An error occured. Please reload.</div>';
          }
      }
    }
}