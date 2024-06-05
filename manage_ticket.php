<?php include 'db_connect.php' ?>
<?php
$qry = $conn->query("SELECT * FROM tickets where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
    $$k = $v;
}
?>
<div class="container-fluid">
    <form action="" id="update-ticket">
        <input type="hidden" value="<?php echo $id ?>" name='id'>
        <input type="hidden" value="<?php echo $staff_id ?>" name='staff_id'> <!-- Hidden field for staff_id -->
        <div class="form-group">
            <label for="" class="control-label">Status</label>
            <select name="status" id="" class="custom-select custom-select-sm">
                <option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Pending/Open</option>
                <option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Processing</option>
                <option value="2" <?php echo $status == 2 ? 'selected' : ''; ?>>Done</option>
                <option value="3" <?php echo $status == 3 ? 'selected' : ''; ?>>Closed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>
<script>
    $('#update-ticket').submit(function(e) {
        e.preventDefault();
        start_load(); // Assuming start_load is a function that shows a loading animation
        $.ajax({
            url: 'ajax.php?action=update_ticket',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                console.log('AJAX Response:', resp); // Debugging line to check the response
                if (resp.trim() == '1') { // Make sure to compare the trimmed response
                    alert_toast('Data successfully updated.', "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast('An error occurred: ' + resp, "danger"); // Show detailed error message
                }
                end_load(); // Assuming end_load is a function that hides the loading animation
            },
            error: function(xhr, status, error) {
                alert_toast('An error occurred while updating the ticket: ' + error, "danger");
                end_load(); // Assuming end_load is a function that hides the loading animation
            }
        });
    });
</script>
