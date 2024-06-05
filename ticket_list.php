<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-info">
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="15%">
                    <col width="20%">
                    <col width="15%">
                    <col width="25%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Queue</th>
                        <th>Time Start</th>
                        <th>Ticket</th>
                        <th>Subject</th>
                        <th>Problem</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $where = '';
                    if ($_SESSION['login_type'] == 2)
                        $where .= " where t.department_id = {$_SESSION['login_department_id']} ";
                    if ($_SESSION['login_type'] == 4)
                        $where .= " where t.customer_id = {$_SESSION['login_id']} ";
                    
                    $qry = $conn->query("SELECT t.*, 
                                        concat(c.lastname, ', ', c.firstname, ' ', c.middlename) as cname, 
                                        (SELECT COUNT(*) FROM tickets t2 WHERE t2.customer_id = t.customer_id AND t2.id <= t.id) as queue_number 
                                        FROM tickets t 
                                        INNER JOIN customers c ON c.id = t.customer_id 
                                        $where 
                                        ORDER BY unix_timestamp(t.time_begin) DESC");
                    while ($row = $qry->fetch_assoc()):
                        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                        $desc = strtr(html_entity_decode($row['problem']), $trans);
                        $desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td class="text-center"><?php echo $row['queue_number'] ?></td>
                        <td><b><?php echo date("H:i:s", strtotime($row['time_begin'])) ?></b></td>
                        <td><b><?php echo ucwords($row['cname']) ?></b></td>
                        <td><b><?php echo $row['subject'] ?></b></td>
                        <td><b class="truncate"><?php echo strip_tags($desc) ?></b></td>
                        <td>
                            <?php if ($row['status'] == 0): ?>
                                <span class="badge badge-primary">Pending/Open</span>
                            <?php elseif ($row['status'] == 1): ?>
                                <span class="badge badge-info">Processing</span>
                            <?php elseif ($row['status'] == 2): ?>
                                <span class="badge badge-success">Done</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Closed</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              Action
                            </button>
                            <div class="dropdown-menu" style="">
                              <a class="dropdown-item view_ticket" href="./index.php?page=view_ticket&id=<?php echo $row['id'] ?>" data-id="<?php echo $row['id'] ?>">View</a>
                              <?php if ($_SESSION['login_type'] != 4 || ($_SESSION['login_type'] == 4 && $_SESSION['login_id'] == $row['customer_id'])): ?>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="./index.php?page=edit_ticket&id=<?php echo $row['id'] ?>">Edit</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item delete_ticket" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                              <?php endif; ?>
                            </div>
                        </td>
                    </tr>    
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#list').dataTable()
        $('.delete_ticket').click(function(){
            _conf("Are you sure to delete this ticket?", "delete_ticket", [$(this).attr('data-id')])
        })
    })
    function delete_ticket($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_ticket',
            method:'POST',
            data:{id:$id},
            success:function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted", 'success')
                    setTimeout(function(){
                        location.reload()
                    }, 1500)
                }
            }
        })
    }
</script>
