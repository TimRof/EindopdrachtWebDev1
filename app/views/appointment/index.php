<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
?>

<!-- Main -->
<div class="content">
    <h1 class="title">Appointment</h1>

    <div>
        <h4>Choose time:</h4>
        <div>
            <fieldset id="time-options">
                <?php
                // use disabled to input
                $i = 0;
                foreach ($model as $appointment) {
                ?>

                    <input type="radio" class="btn-check" name="time-options" id="<?php echo $i; ?>">
                    <label class="btn btn-outline-success m-2" for="<?php echo $i;
                                                                    $i++; ?>"><?php echo date_format($appointment->getStart(), 'H:i') ?> - <?php echo date_format($appointment->getEnd(), 'H:i') ?></label>
                <?php
                }
                ?>
            </fieldset>
        </div>
    </div>
    <div>
        <h4>Choose type:</h4>
        <div>
            <fieldset id="type-options">
                <input type="radio" class="btn-check" name="type-options" id="wh">
                <label class="btn btn-outline-success m-2" for="wh">Wash & Haircut - €35.00</label>
                <input type="radio" class="btn-check" name="type-options" id="h">
                <label class="btn btn-outline-success m-2" for="h">Haircut - €33.00</label>
                <input type="radio" class="btn-check" name="type-options" id="c">
                <label class="btn btn-outline-success m-2" for="c">Clippers - €20.00</label>
            </fieldset>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-center mt-3 login_container">

        <button class="btn btn-lg btn-primary me-1 rounded-pill m-2">Make appointment</button>
    </div>
</div>
<!-- Main -->
<?php
include_once __DIR__ . '/../footer.php';
?>
<?php
include_once __DIR__ . '/../end.php';
?>