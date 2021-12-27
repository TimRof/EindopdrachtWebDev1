<?php
$PageTitle = "The Hair Company - Login";

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->
<h1>Login</h1>


<form method="post" action="/login/create" id="formLogin">
    <div>
        <label for="inputEmail">Email</label>
        <input type="email" id="inputEmail" name="email" placeholder="Email address" value="<?php echo $email; ?>" <?php if (empty($email)) { ?> autofocus <?php } ?>>
    </div>
    <div>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="password" placeholder="Password" <?php if (!empty($email)) { ?> autofocus <?php } ?>>
    </div>

    <button class="btn btn-primary rounded-pill" type="submit">Login</button>
    <?php if ($user == false && !is_null($email)) { ?>
        <p class="alert alert-danger" role="alert">
            <b>Incorrect Credentials</b><br>
            Verify your email address and password and try again.
        </p>
    <?php } ?>
</form>
<!-- Main -->

<?php
include_once __DIR__ . '/../footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {

        $('#formLogin').validate({
            onkeyup: false,
            onclick: false,
            onfocusout: false,

            rules: {
                name: 'required',
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                }
            }
        });
    });
</script>
<?php
include_once __DIR__ . '/../end.php';
?>