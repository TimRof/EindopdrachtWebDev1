<?php
$PageTitle = "The Hair Company - Login";

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->
<h1>Login</h1>

<form method="post" action="/signup/create">
    <div>
        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email address">
    </div>
    <div>
        <label for="inputPassword">Password</label>
        <input type="password" id="inputPassword" name="password" placeholder="Password">
    </div>
    <button class="btn btn-primary rounded-pill" type="submit">Login</button>
</form>
<!-- Main -->

<?php
include_once __DIR__ . '/../footer.php';
?>