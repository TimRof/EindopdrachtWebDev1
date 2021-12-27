<?php
$PageTitle = "The Hare Company - Sign Up";

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->

<h1>Sign Up</h1>
<form method="post" action="/signup/create" id="formSignup">
    <div>
        <label for="inputName">Name</label>
        <input id="inputName" name="name" placeholder="Name" maxlength="50" autofocus required>
    </div>
    <div>
        <label for="inputEmail">Email</label>
        <input id="inputEmail" type="email" name="email" placeholder="Email address" maxlength="200">
    </div>
    <div>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="password" placeholder="Password" maxlength="128">
    </div>
    <div>
        <label for="inputPasswordConfirmation">Repeat password</label>
        <input type="password" id="inputPasswordConfirmation" name="password_confirmation" placeholder="Repeat password" maxlength="128">
    </div>
    <button class="btn btn-primary rounded-pill" type="submit">Sign up</button>

</form>

<!-- Main -->
<?php
include_once __DIR__ . '/../footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {

        $('#formSignup').validate({
            onkeyup: false,
            onclick: false,
            onfocusout: false,

            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,
                    remote: '/account/validateEmail'
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    equalTo: '#inputPassword'
                }
            },
            messages: {
                email: {
                    remote: 'Email already taken'
                }
            }
        });
    });
</script>
<?php
include_once __DIR__ . '/../end.php';
?>