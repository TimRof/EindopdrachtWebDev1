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
<script>
    Date.prototype.toDateInputValue = (function() {
        var local = new Date(this);
        local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    });
    document.getElementById('datepicker').value = new Date().toDateInputValue();
</script>
<script>
    document.addEventListener('readystatechange', () => {
        AjaxReq();
    });
    document.getElementById('datepicker').addEventListener('change', () => {
        AjaxReq();
    });

    function AjaxReq() {
        const date = {
            date: document.getElementById('datepicker').value
        };
        $.ajax({
            type: 'POST',
            url: 'appointment/getFreeSlots',
            data: {
                date: document.getElementById('datepicker').value
            },
        }).done(function(res) {
            makeButtons(res);
        })
    }

    function makeButtons(res) {
        document.getElementById('time-options').innerHTML = "";
        var now = new Date();
        for (const element of res) {
            var radio = document.createElement('input');
            radio.type = 'radio';
            radio.id = element.timeslot;
            radio.name = 'time-options';
            radio.classList.add('btn-check');

            var label = document.createElement('label');
            label.classList.add('btn');
            label.classList.add('btn-outline-success');
            label.classList.add('m-2');
            label.htmlFor = element.timeslot;

            var start = element.start.date.substring(11, 16);
            var end = element.end.date.substring(11, 16);
            var description = document.createTextNode(start + " - " + end);
            label.appendChild(description);

            var starttime = new Date();
            starttime.setTime(Date.parse(element.start.date));

            if (element.taken || (now.setHours(0, 0, 0, 0) == starttime.setHours(0, 0, 0, 0) && starttime < now)) {
                radio.disabled = true;
            }
            var fieldset = document.getElementById('time-options');
            fieldset.appendChild(radio);
            fieldset.appendChild(label);
        }
    }
</script>

<?php
include_once __DIR__ . '/../end.php';
?>