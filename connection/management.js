/*
 * Created on Mon May 17 2021
 * Latest update on Mon May 17 2021
 * Info - JS for members management
 * @author Eddy Ikhlef <eddy.ikhlef@protonmail.com>
 */

//Which form to show first, comment or remove if you don't want to open a section at start
//showAddForm();
var usersJSON;

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
    http.open("GET", url+"?"+params, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(null);
    /* Handle request results */
    http.onreadystatechange = function() {
        if (http.readyState === 4) {
            if (http.status === 200) {
                document.getElementById("info").innerHTML = '<div class="alert alert-info" role="alert">Successfully Added '+username+' as '+profile+'.</div>';
                cleanForm();
            } else if (http.status === 403) {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">'+username+' already exists.</div>';
            } else {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">Failed to Add '+username+' as '+profile+'.</div>';
            }
        }
    }
}

function updateMember() {
    let oldUsername = document.getElementById('selectedUser').value;
    let username = document.getElementById('name_user').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let profile = document.getElementById('profile').value;
    let users = document.getElementsByClassName('users');
    let id = "";
    for(let i = 0; i<users.length; i++) {
        if(users[i].value == oldUsername) {
            id = users[i].dataset.id;
            break;
        }
    }
    let params = "username="+encodeURIComponent(username)+"&email="+encodeURIComponent(email)+"&password="+encodeURIComponent(password)+"&profile="+encodeURIComponent(profile)+"&id="+encodeURIComponent(id);
    /* Prepare request */
    let url = "./update.php";
    /* Fires request */
    var http = new XMLHttpRequest();
    http.open("GET", url+"?"+params, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(null);
    /* Handle request results */
    http.onreadystatechange = function() {
      if (http.readyState === 4) {
          if (http.status === 200) {
              document.getElementById("info").innerHTML = '<div class="alert alert-info" role="alert">Successfully Updated '+oldUsername+' as '+username+", "+username+", "+profile+'.</div>';
              cleanForm();
              loadUsersList();
          } else if (http.status === 403) {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">'+username+' don\'t exists.</div>';
          } else {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">Failed to Update '+username+' as '+profile+'.</div>';
          }
      }
    }
}

function deleteMember() {
    let username = document.getElementById('selectedUser').value;
    let users = document.getElementsByClassName('users');
    let id = "";
    for(let i = 0; i<users.length; i++) {
        if(users[i].value == username) {
            id = users[i].dataset.id;
            break;
        }
    }
    let params = "username="+encodeURIComponent(username)+"&id="+encodeURIComponent(id);
    /* Prepare request */
    let url = "./delete.php";
    /* Fires request */
    var http = new XMLHttpRequest();
    http.open("GET", url+"?"+params, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(null);
    /* Handle request results */
    http.onreadystatechange = function() {
        if (http.readyState === 4) {
            if (http.status === 200) {
                document.getElementById("info").innerHTML = '<div class="alert alert-info" role="alert">Successfully Deleted '+username+'.</div>';
                cleanForm();
                loadUsersList();
            } else if (http.status === 403) {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">'+username+' Don\'t exists.</div>';
            } else {
            document.getElementById("info").innerHTML = '<div class="alert alert-danger" role="alert">Failed to Delete '+username+'.</div>';
            }
        }
    }
}

/*******************************************************************************/
/* activate function */
/*******************************************************************************/
function activate(data) {
    let buttons = document.getElementsByClassName("validate");
    for(let i = 0; i<buttons.length; i++) {
        buttons[i].disabled = false;
    }
    let ids = data.split(" ");
    ids.forEach(element => {
        if(document.getElementById(element).value.length == 0) {
            for(let i = 0; i<buttons.length; i++) {
                buttons[i].disabled = true;
            }
        }
    });
}

/*******************************************************************************/
/* show function */
/*******************************************************************************/
function showAddForm() {
    cleanDivs();
    document.getElementById('form').innerHTML = `
    <div class="form-group pt-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Username</span>
            </div>
            <input class="form-control" type="text" name="name_user" id="name_user" required oninput="activate('name_user email profile password')">
        </div>
        <div class="form-group pt-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
            </div>
            <input class="form-control" type="email" name="email" id="email" required oninput="activate('name_user email profile password')">
        </div>
        <div class="form-group pt-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Password</span>
            </div>
            <input class="form-control" type="password" name="password" id="password" required oninput="activate('name_user email profile password')">
        </div>
        <div class="form-group pt-4">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Profile</span>
            </div>
            <select class="form-select" name="profile" id="profile" required oninput="activate('name_user email profile password')">
                <option value="expert">Expert</option>
                <option value="assistant">Assistant</option>
            </select>
        </div>
        <div class="form-group pb-4">
            <button class="validate btn btn-outline-success" onclick="addMember()" disabled>Add Member</button>
        </div>
    </div>
    `;
    updateButtons("addForm");
}

function showManageForm() {
    cleanDivs();
    document.getElementById('form').innerHTML = `
    <div class="row justify-content-start">
        <div class="col-4">
            <input type="text" list="usersList" id="selectedUser" name="selectedUser" class="form-control" placeholder="Member Name" oninput="showManageUser()" />
            <datalist id="usersList"></datalist>
        </div>
        <div class="col" id="formBis">
        </div>
    </div>
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
            <div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Username</span>
                    </div>
                    <input class="form-control" type="text" name="name_user" id="name_user" value="`+selected+`" required oninput="activate('name_user email profile')">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Email</span>
                    </div>
                    <input class="form-control" type="email" name="email" id="email" value="`+all[i].innerHTML+`" required oninput="activate('name_user email profile')">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Password</span>
                    </div>
                    <input class="form-control" type="password" name="password" id="password" oninput="activate('name_user email profile')">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Profile</span>
                    </div>
                    <select class="form-select" name="profile" id="profile" required oninput="activate('name_user email profile')">
                        <option value="expert">Expert</option>
                        <option value="assistant">Assistant</option>
                    </select>
                </div>
                <div class="form-group pb-4">
                    <div class="row">
                    <div class="col-md-auto"><button class="validate btn btn-outline-success" onClick="updateMember()">Update</button></div>
                    <div class="col-md-auto"><button class="validate btn btn-outline-danger" onClick="deleteMember()">Delete</button></div>
                </div>
            </div>
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
    usersList.innerHTML = "";
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
            usersJSON = JSON.parse(this.response);
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

function cleanDivs() {
    if(document.getElementById('info') != null) document.getElementById('info').innerHTML = "";
    if(document.getElementById('form') != null) document.getElementById('form').innerHTML = "";
    if(document.getElementById('formBis') != null) document.getElementById('formBis').innerHTML = "";
}

function cleanForm() {
    if(document.getElementById('name_user') != null) document.getElementById('name_user').value = "";
    if(document.getElementById('email') != null) document.getElementById('email').value = "";
    if(document.getElementById('password') != null) document.getElementById('password').value = "";
    if(document.getElementById('selectedUser') != null) document.getElementById('selectedUser').value = "";
}