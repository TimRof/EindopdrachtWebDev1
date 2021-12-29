<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
$PageTitle = "The Hair Company - Forbidden";
?>
<!-- Main -->

<div class="container content">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h2 class="title">
                    403 Forbidden</h2>
                <div class="error-details">
                    Sorry, an error has occured, you need to be logged in to view this page!
                </div>
                <div>
                    <div class="error-actions">
                        <a href="/login" class="btn btn-primary btn-lg rounded-pill mt-3">Login</a>
                        <a href="/" class="btn btn-primary btn-lg rounded-pill mt-3">Back to home</a>
                    </div>

                    <div class="error-actions">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main -->
<?php
include_once __DIR__ . '/../footer.php';
?>
<?php
include_once __DIR__ . '/../end.php';
?>