<?php
include 'db_connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $qry = $conn->query("SELECT t.*, concat(c.lastname, ', ', c.firstname, ' ', c.middlename) as cname 
                         FROM tickets t 
                         INNER JOIN customers c ON c.id = t.customer_id 
                         WHERE t.id = $id");

    if ($qry) {
        $result = $qry->fetch_array();
        foreach ($result as $k => $v) {
            $$k = $v;
        }
    } else {
        echo "Error: Unable to fetch data.";
    }
} else {
    echo "Invalid ticket ID.";
    exit;
}
?>
<style>
    .d-list {
        display: list-item;
    }
</style>
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Ticket</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="control-label border-bottom border-primary">Subject</label>
                                <p class="ml-2 d-list"><b><?php echo $subject ?></b></p>
                                <label for="" class="control-label border-bottom border-primary">Customer</label>
                                <p class="ml-2 d-list"><b><?php echo $cname ?></b></p>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="control-label border-bottom border-primary">Status</label>
                                <p class="ml-2 d-list">
                                    <?php if ($status == 0) : ?>
                                        <span class="badge badge-primary">Pending/Open</span>
                                    <?php elseif ($status == 1) : ?>
                                        <span class="badge badge-info">Processing</span>
                                    <?php elseif ($status == 2) : ?>
                                        <span class="badge badge-success">Done</span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Closed</span>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['login_type'] != 4) : ?>
                                        <span class="badge btn-outline-primary btn update_status" data-id='<?php echo $id ?>'>Update Status</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <hr class="border-primary">
                        <div>
                            <?php echo html_entity_decode($problem) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($_SESSION['login_type'] != 4) : ?>
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Solution/s</h3>
                    </div>
                    <div class="card-body p-0 py-2">
                        <div class="container-fluid">
                            <?php
                            $comments = $conn->query("SELECT * FROM comments WHERE ticket_id = '$id' ORDER BY unix_timestamp(time_finished) ASC");
                            while ($row = $comments->fetch_assoc()) :
                                if ($row['user_type'] == 1)
                                    $uname = $conn->query("SELECT concat(lastname, ', ', firstname, ' ', middlename) as name FROM users WHERE id = {$row['user_id']}")->fetch_array()['name'];
                                if ($row['user_type'] == 2)
                                    $uname = $conn->query("SELECT concat(lastname, ', ', firstname, ' ', middlename) as name FROM staff WHERE id = {$row['user_id']}")->fetch_array()['name'];
                                if ($row['user_type'] == 3)
                                    $uname = $conn->query("SELECT concat(lastname, ', ', firstname, ' ', middlename) as name FROM staff WHERE id = {$row['user_id']}")->fetch_array()['name'];
                                if ($row['user_type'] == 4)
                                    $uname = $conn->query("SELECT concat(lastname, ', ', firstname, ' ', middlename) as name FROM customers WHERE id = {$row['user_id']}")->fetch_array()['name'];
                            ?>
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h5 class="card-title"><?php echo ucwords($uname) ?></h5>
                                        <div class="card-tools">
                                            <span class="text-muted"><?php echo date("M d, Y", strtotime($row['time_finished'])) ?></span>
                                            <?php if ($row['user_type'] == $_SESSION['login_type'] && $row['user_id'] == $_SESSION['login_id']) : ?>
                                                <span class="dropleft">
                                                    <a class="fa fa-ellipsis-v text-muted" href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item edit_comment" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete_comment" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                                                    </div>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <?php echo html_entity_decode($row['solution']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <hr class="border-primary">
                        <div class="px-2">
                            <form action="" id="manage-comment">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="">
                                    <input type="hidden" name="ticket_id" value="<?php echo $id ?>">
                                    <label for="" class="control-label">New Solution</label>
                                    <textarea name="solution" id="" cols="30" rows="" class="form-control summernote2"></textarea>
                                </div>
                                <button class="btn btn-primary btn-sm float-right">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    $(function() {
        $('.summernote2').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['view', ['undo', 'redo']]
            ]
        })
    })
    $('.edit_comment').click(function() {
        uni_modal("Edit Comment", "manage_comment.php?id=" + $(this).attr('data-id'))
    })
    $('.update_status').click(function() {
        uni_modal("Update Ticket's Status", "manage_ticket.php?id=" + $(this).attr('data-id'))
    })
    $('#manage-comment').submit(function(e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'ajax.php?action=save_comment',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast('Comment successfully saved.', "success");
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
                end_load(); 
            },
            error: function() {
                end_load(); 
                alert_toast('An error occurred.', "danger");
            }
        })
    })
    $('.delete_comment').click(function() {
        _conf("Are you sure to delete this comment?", "delete_comment", [$(this).attr('data-id')])
    })

    function delete_comment($id) {
        start_load()
        $.ajax({
            url: 'ajax.php?action=delete_comment',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1500)
                }
            }
        })
    }
</script>