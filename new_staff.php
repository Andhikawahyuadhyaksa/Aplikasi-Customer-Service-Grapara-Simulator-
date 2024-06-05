<?php
if (!isset($conn)) {
    include 'db_connect.php';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $staff = $conn->query("SELECT * FROM staff WHERE id = $id")->fetch_assoc();
    foreach ($staff as $key => $value) {
        $$key = $value;
    }
}
?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form action="" id="manage_staff">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <b class="text-muted">Personal Information</b>
                        <div class="form-group">
                            <label for="" class="control-label">First Name</label>
                            <input type="text" name="firstname" class="form-control form-control-sm" required value="<?php echo isset($firstname) ? $firstname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Middle Name</label>
                            <input type="text" name="middlename" class="form-control form-control-sm" value="<?php echo isset($middlename) ? $middlename : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control form-control-sm" required value="<?php echo isset($lastname) ? $lastname : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Contact No.</label>
                            <input type="text" name="contact" class="form-control form-control-sm" required value="<?php echo isset($contact) ? $contact : '' ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea name="address" cols="30" rows="4" class="form-control" required><?php echo isset($address) ? $address : '' ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Role</label>
                            <select name="role" id="role" class="custom-select custom-select-sm">
                                <option value="Customer Service" <?php echo isset($role) && $role == 'Customer Service' ? "selected" : '' ?>>Customer Service</option>
                                <option value="Manager" <?php echo isset($role) && $role == 'Manager' ? "selected" : '' ?>>Manager</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Table Code</label>
                            <select name="table_id" id="table_id" class="custom-select custom-select-sm select2">
                                <option value=""></option>
                                <?php
                                $tables = $conn->query("SELECT * FROM tables order by code asc");
                                while ($row = $tables->fetch_assoc()):
                                    ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo isset($table_id) && $table_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['code']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <b class="text-muted">System Credentials</b>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($email) ? $email : '' ?>">
                            <small id="msg"></small>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control form-control-sm" name="password" <?php echo isset($id) ? "" : 'required' ?>>
                            <small><i><?php echo isset($id) ? "Leave this blank if you don't want to change your password" : '' ?></i></small>
                        </div>
                        <div class="form-group">
                            <label class="label control-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" name="cpass" <?php echo isset($id) ? '' : 'required' ?>>
                            <small id="pass_match" data-status=''></small>
                        </div>
                    </div>

					
					
		</div>
                <hr>
            </form>
        </div>
    </div>
</div>
<script>
    $('[name="password"],[name="cpass"]').keyup(function () {
        var pass = $('[name="password"]').val();
        var cpass = $('[name="cpass"]').val();
        if (cpass === '' || pass === '') {
            $('#pass_match').attr('data-status', '');
        } else {
            if (cpass === pass) {
                $('#pass_match').attr('data-status', '1').html('<i class="text-success">Password Matched.</i>');
            } else {
                $('#pass_match').attr('data-status', '2').html('<i class="text-danger">Password does not match.</i>');
            }
        }
    });

    $('#manage_staff').submit(function (e) {
        e.preventDefault();
        $('input').removeClass("border-danger");
        start_load();
        $('#msg').html('');
        if ($('#pass_match').attr('data-status') != 1) {
            if ($("[name='password']").val() != '') {
                $('[name="password"],[name="cpass"]').addClass("border-danger");
                end_load();
                return false;
            }
        }
        $.ajax({
            url: 'ajax.php?action=save_staff',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function (resp) {
                if (resp == 1) {
                    alert_toast('Data successfully saved.', "success");
                    setTimeout(function () {
                        location.replace('index.php?page=staff_list');
                    }, 750);
                } else if (resp == 2) {
                    $('#msg').html("<div class='alert alert-danger'>Email already exist.</div>");
                    $('[name="email"]').addClass("border-danger");
                    end_load();
                }
            }
        })
    });
</script>
