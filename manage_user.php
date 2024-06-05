<?php 
include('db_connect.php');
session_start();

$utype = array('','users','staff','customers');

if (isset($_SESSION['login_type']) && array_key_exists($_SESSION['login_type'], $utype)) {
    $table = $utype[$_SESSION['login_type']];
} else {
    echo "Invalid login type.";
    exit;
}

if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM $table where id =" . $_GET['id']);
    if($user->num_rows > 0){
        foreach($user->fetch_array() as $k => $v){
            $meta[$k] = $v;
        }
    }
}
?>
<div class="container-fluid">
    <div id="msg"></div>
    
    <form action="" id="manage-user">    
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <input type="hidden" name="table" value="<?php echo $table ?>">
        <div class="form-group">
            <label for="name">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="name">Middle Name</label>
            <input type="text" name="middlename" id="middlename" class="form-control" value="<?php echo isset($meta['middlename']) ? $meta['middlename'] : '' ?>">
        </div>
        <div class="form-group">
            <label for="name">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="username">Username/Email</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required  autocomplete="off">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
            <small><i>Leave this blank if you don't want to change the password.</i></small>
        </div>
    </form>
</div>
<script>
    $('#manage-user').submit(function(e){
        e.preventDefault();
        start_load()
        $.ajax({
            url:'ajax.php?action=save_user',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                if(resp == 1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },1500)
                } else {
                    $('#msg').html('<div class="alert alert-danger">Username already exists</div>')
                    end_load()
                }
            }
        })
    })
</script>
