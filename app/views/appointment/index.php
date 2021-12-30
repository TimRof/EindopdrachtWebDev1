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
        <input type="date" class="form-control" name="datepicker" id="datepicker" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime("+21 days")); ?>" required>
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
        AjaxReqSlots();
        AjaxReqTypes();
    });
    document.getElementById('datepicker').addEventListener('change', () => {
        AjaxReqSlots();
    });

    function AjaxReqSlots() {
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
            makeSlotButtons(res);
        })
    }

    function makeSlotButtons(res) {
        document.getElementById('time-options').innerHTML = "";
        var nowDay = new Date();
        var now = new Date();

        for (const element of res) {
            var radio = document.createElement('input');
            radio.type = 'radio';
            radio.id = 'time' + element.timeslot;
            radio.name = 'time-options';
            radio.classList.add('btn-check');

            var label = document.createElement('label');
            label.classList.add('btn');
            label.classList.add('btn-outline-success');
            label.classList.add('m-2');
            label.htmlFor = 'time' + element.timeslot;

            var start = element.start.date.substring(11, 16);
            var end = element.end.date.substring(11, 16);
            var description = document.createTextNode(start + " - " + end);
            label.appendChild(description);

            var starttime = new Date();
            starttime.setTime(Date.parse(element.start.date));

            if (element.taken || starttime < now && (nowDay.setHours(0, 0, 0, 0) == starttime.setHours(0, 0, 0, 0))) {
                radio.disabled = true;
            }
            radio.required = true;

            var fieldset = document.getElementById('time-options');
            fieldset.appendChild(radio);
            fieldset.appendChild(label);
        }
    }

    function AjaxReqTypes() {
        $.ajax({
            type: 'GET',
            url: 'appointment/getTypes',
        }).done(function(res) {
            makeTypeButtons(res);
        })
    }

    function makeTypeButtons(res) {
        document.getElementById('type-options').innerHTML = "";
        for (const type of res) {
            var radio = document.createElement('input');
            radio.type = 'radio';
            radio.id = 'type' + type.id;
            radio.name = 'type-options';
            radio.classList.add('btn-check');

            var label = document.createElement('label');
            label.classList.add('btn');
            label.classList.add('btn-outline-success');
            label.classList.add('m-2');
            label.htmlFor = 'type' + type.id;

            var myformat = new Intl.NumberFormat('de-DE', {
                minimumFractionDigits: 2
            });
            var description = document.createTextNode(type.type + " - €" + type.price);
            label.appendChild(description);

            radio.required = true;

            var fieldset = document.getElementById('type-options');
            fieldset.appendChild(radio);
            fieldset.appendChild(label);
        }
    }
</script>

<?php
include_once __DIR__ . '/../end.php';
?>