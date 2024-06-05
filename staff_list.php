<?php include 'db_connect.php' ?>
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff Name</th>
                        <th>Department</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Table Code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    // Updated query to join staff and tables
                    $qry = $conn->query("SELECT s.*, t.code as table_code FROM staff s 
                                         LEFT JOIN tables t ON s.table_id = t.id 
                                         ORDER BY s.lastname ASC");
                    while($row= $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo ucwords($row['lastname'].', '.$row['firstname'].' '.$row['middlename']) ?></b></td>
                        <td><b><?php echo ucwords($row['role']) ?></b></td>
                        <td><b><?php echo $row['contact'] ?></b></td>
                        <td><b><?php echo $row['email'] ?></b></td>
                        <td><b><?php echo $row['table_code'] ?></b></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                              Action
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item edit_staff" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item delete_staff" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
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
        $('#new_staff').click(function(){
            uni_modal("New Staff","new_staff.php")
        })
        $('.edit_staff').click(function(){
            uni_modal("Edit Staff","new_staff.php?id="+$(this).attr('data-id'))
        })
        $('.delete_staff').click(function(){
            _conf("Are you sure to delete this staff?","delete_staff",[$(this).attr('data-id')])
        })
    })
    function delete_staff(id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_staff',
            method:'POST',
            data:{id:id},
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully deleted",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                }
            }
        })
    }
</script>
