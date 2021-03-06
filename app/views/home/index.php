<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->
<main class="text-center">
    <div class="container d-flex align-items-center flex-column">
        <img class="mb-5" src="assets/img/bunnylogo.png" alt="Bunny looking like Elvis getting their haircut" height="250em" />
        <h1 class="text-uppercase mb-0 basic-color">Welcome<?php
                                                            if (isset($_SESSION['user_id'])) {
                                                                echo " " . htmlspecialchars($_SESSION['user_name']);
                                                            }
                                                            ?>!</h1>
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="divider-custom-line"></div>
        </div>
        <p class="font-weight-light mb-0 basic-color">
            Never have a bad hare day again! We at The Hare Company are here
            for all your hair needs! Book your appointment now!
        </p>
        <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="/login" class="btn btn-primary btn-lg rounded-pill mt-4" role="button">Login to make an appointment!</a>
        <?php else : ?>
            <a href="/appointment" class="btn btn-primary btn-lg rounded-pill mt-4" role="button">Book now!</a>
        <?php endif; ?>

    </div>
    <!-- Reviews -->
    <div class="container mt-5 d-flex justify-content-center">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 review">
                <figure><img src="https://media-exp1.licdn.com/dms/image/C5603AQEf6jl-bm5hRg/profile-displayphoto-shrink_800_800/0/1517683024186?e=1653523200&v=beta&t=sPqvxY2svi9Coxs5JuPu-Lcaix7UFz9k6XssTfDoJaY" class="col-md-3 photo" alt="Picture of Peter Stikker"></figure>
                <h1>Peter Stikker</h1>
                <p>I got an amazing harecut! Definitely recommended!</p>
                <div class="mt-1"><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i></p>
                </div>
            </div>
            <div class="col-md-4 review">
                <figure><img src="https://media-exp1.licdn.com/dms/image/C5603AQG0kr7QQrDy6A/profile-displayphoto-shrink_800_800/0/1517405413641?e=1653523200&v=beta&t=bzdUsyb4WlDsgFB0PCvvSWg12Owze1CKVmgPqmJZam4" class="col-md-3 photo" alt="Picture of Niels van der Zwet"></figure>
                <h1>Niels van der Zwet</h1>
                <p>I had the time of my life! Very friendly staff and I left looking like a bunny!
                <div class="mt-1"><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i><i class="star fa-solid fa-star"></i></p>
                </div>
            </div>
        </div>
        <!-- Reviews -->
</main>
<!-- Main -->

<?php
include_once __DIR__ . '/../footer.php';
?>
<?php
include_once __DIR__ . '/../end.php';
?>