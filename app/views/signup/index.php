<?php
$PageTitle = "The Hare Company - Sign Up";

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->

<h1>Sign Up</h1>
<form action="signup/create" onsubmit="return validate_form()" method="post" name="signupform">
    <div>
        <label for="inputName">Name</label>
        <input id="inputName" name="name" placeholder="Name" maxlength="50" autofocus><span id="nameError" class="error"> Name can not be empty.</span>
    </div>
    <div>
        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email address" maxlength="200"><span id="emailError" class="error"> Email not valid.</span>
    </div>
    <div>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="password" placeholder="Password" maxlength="128"><span id="passwordlngthError" class="error"> Password has to be at least 6 characters.</span>
    </div>
    <div>
        <label for="inputPasswordConfirmation">Repeat password</label>
        <input type="password" id="inputPasswordConfirmation" name="password_confirmation" placeholder="Repeat password" maxlength="128"><span id="passwordmtchError" class="error"> Passwords do not match.</span>
    </div>
    <button class="btn btn-primary rounded-pill" type="submit">Sign up</button>
    <script>
        function validate_form() {
            var validName = true;
            var validEmail = true;
            var validPassLngth = true;
            var validPassMtch = true;
            var pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

            // check name is not empty
            if (document.forms["signupform"]["name"].value == "") {
                document.getElementById("nameError").style.visibility = "visible";
                validName = false;
            } else {
                document.getElementById("nameError").style.visibility = "hidden";
                validName = true;
            }

            // check password length
            if (document.forms["signupform"]["password"].value.length < 6) {
                document.getElementById("passwordlngthError").style.visibility = "visible";
                validPassLngth = false;
            } else {
                document.getElementById("passwordlngthError").style.visibility = "hidden";
                validPassLngth = true;
            }

            // check passwords match
            if (document.forms["signupform"]["password"].value != document.forms["signupform"]["password_confirmation"].value) {
                document.getElementById("passwordmtchError").style.visibility = "visible";
                validPassMtch = false;
            } else {
                document.getElementById("passwordmtchError").style.visibility = "hidden";
                validPassMtch = true;
            }

            // check email
            var input = document.getElementById('inputEmail');

            if (document.forms["signupform"]["email"].value == "") {
                document.getElementById("emailError").style.visibility = "visible";
                validEmail = false;
            } else if (!pattern.test(document.forms["signupform"]["email"].value)) {
                document.getElementById("emailError").style.visibility = "visible";
                validEmail = false;
            } else {
                document.getElementById("emailError").style.visibility = "hidden";
                validEmail = true;
            }

            if (validName && validPassLngth && validPassMtch && validEmail) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</form>

<!-- Main -->

<?php
include_once __DIR__ . '/../footer.php';
?>