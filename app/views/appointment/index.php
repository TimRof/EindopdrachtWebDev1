<?php

include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
$PageTitle = "The Hair Company - Appointment";
?>
<!-- Main -->
<div class="content">
    <h1 class="title">Appointment</h1>
    <h4>Choose date:</h4>
    <div class="input-group mb-2">
        <input type="date" class="form-control" name="datepicker" id="datepicker" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime("+21 days")); ?>">
    </div>
    <div>
        <h4>Choose time:</h4>
        <div>
            <fieldset id="time-options">
                <?php
                $controller = new AppointmentController();
                $i = 0;
                foreach ($controller->getSlots() as $appointment) {
                ?>

                    <input type="radio" class="btn-check" name="time-options" id="<?php echo $i; ?>" <?php
                                                                                                        if ($appointment->getTaken() || date_format($appointment->getStart(), 'Y-m-d H:i:s') < date('Y-m-d H:i:s')) {
                                                                                                            echo "disabled";
                                                                                                        }
                                                                                                        ?>>
                    <label class="btn btn-outline-success m-2" for="<?php echo $i;
                                                                    $i++; ?>"><?php echo date_format($appointment->getStart(), 'H:i') ?> - <?php echo date_format($appointment->getEnd(), 'H:i') ?></label>
                <?php
                }
                echo date('d-m-Y H:i:s');

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
<input type="text" id="hiddendate" name="hiddendate" value="<?php echo date('Y-m-d'); ?>">
<!-- Main -->
<?php
include_once __DIR__ . '/../footer.php';
?>
<script>
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });
    document.getElementById('datepicker').value = new Date().toDateInputValue();
</script>
<script>
    document.getElementById('datepicker').addEventListener('change', () => {
        const date = {
            date: document.getElementById('datepicker').value
        };
        fetch('appointment/test', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(date),
            }).then(response => response.json())
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    });
</script>
<?php
include_once __DIR__ . '/../end.php';
?>