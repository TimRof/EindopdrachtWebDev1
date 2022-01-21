<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../nav.php';
$PageTitle = "The Hair Company - Dashboard";
?>
<!-- Main -->
<div class="content">
    <h1 class="title" id="title">Dashboard</h1>
    <ul id="appointment-list">

    </ul>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-sm basic-color" id="updateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update appointment</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Set type to:
                    <fieldset id="type-options"></fieldset>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button id="buttonModal" type="button" class="btn btn-primary login_btn" onclick="AjaxReqUpdate()">Update</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<input type="text" id="hiddenid" name="hiddenid" value="" hidden>
<!-- Main -->
<?php
include_once __DIR__ . '/../footer.php';
?>
<script>
    document.addEventListener('readystatechange', () => {
        AjaxReqTaken();

    });

    function AjaxReqTaken() {
        $.ajax({
            type: 'GET',
            url: 'appointment/api',
        }).done(function(res) {
            console.log(res);
            makeTakenList(res);
        })
    }

    function AjaxReqDelete(id) {
        $.ajax({
            type: 'POST',
            url: 'appointment/delete',
            data: {
                id: id
            },
        }).done(function(res) {
            AjaxReqTaken();
        })
    }

    function AjaxReqUpdate() {
        var id = document.getElementsByName('hiddenid')[0].value
        var type = document.querySelector('input[name="type-options"]:checked').value;
        console.log("id: " + id);
        console.log("type: " + type);
        $.ajax({
            type: 'POST',
            url: 'appointment/update',
            data: {
                id: id,
                type: type
            },
        }).done(function(res) {
            console.log("result:" + res);
            AjaxReqTaken();
            $('#updateModal').modal('toggle');
        })
    }

    function update(id) {
        $('#updateModal').modal('show');
        document.getElementById("hiddenid").value = id.match(/\d+/)[0]
        AjaxReqTypes(id.replace(/\d+/g, ''));
    }

    function makeTakenList(res) {
        document.getElementById('appointment-list').innerHTML = "";
        for (const slot of res) {
            var li = document.createElement('li');

            var deleteButton = document.createElement('button');
            deleteButton.appendChild(document.createTextNode("Delete"));
            deleteButton.id = slot.id;
            deleteButton.classList.add('btn');
            deleteButton.classList.add('btn-primary');
            deleteButton.classList.add('rounded-pill');
            deleteButton.onclick = function(clicked_id) {
                AjaxReqDelete(this.id);
            }
            var updateButton = document.createElement('button');
            updateButton.appendChild(document.createTextNode("Update"));
            updateButton.id = slot.type + slot.id;
            updateButton.classList.add('btn');
            updateButton.classList.add('btn-primary');
            updateButton.classList.add('rounded-pill');
            updateButton.onclick = function(clicked_id) {
                update(this.id);
            }
            var liDescription = document.createTextNode(slot.name + " (" + slot.email + ")" + " - " + slot.type + " on " + slot.starttime);
            var br = document.createElement("br");
            li.appendChild(liDescription);
            li.appendChild(br);
            li.appendChild(deleteButton);
            li.appendChild(updateButton);
            var ul = document.getElementById('appointment-list');
            ul.appendChild(li);
        }
    }

    function AjaxReqTypes(id) {
        $.ajax({
            type: 'GET',
            url: 'appointment/getTypes',
        }).done(function(res) {
            makeTypeButtons(res, id);
        })
    }

    function makeTypeButtons(res, id) {
        document.getElementById('type-options').innerHTML = "";
        for (const type of res) {
            var radio = document.createElement('input');
            radio.type = 'radio';
            radio.id = 'type' + type.id;
            radio.name = 'type-options';
            radio.classList.add('btn-check');
            radio.value = type.id;
            if (type.type == id) {
                radio.disabled = true;
            }

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