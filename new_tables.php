<?php include 'db_connect.php' ?>
<?php 
$qry = $conn->query("SELECT * FROM tables where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
?>
<div class="container-fluid">
	<form action="" id="update-tables">
		<input type="hidden" value="<?php echo $id ?>" name='id'>
		<div class="form-group">
			<label for="" class="control-label">Status</label>
			<select name="status" id="" class="custom-select custom-select-sm">
				<option value="0" <?php echo $status == 0 ? 'selected' : ''; ?>>Empty</option>
				<option value="1" <?php echo $status == 1 ? 'selected' : ''; ?>>Filled</option>
			</select>
		</div>
	</form>
</div>
<script>
	$('#manage-tables').submit(function(e){
		e.preventDefault()
		start_load()
		// $('#msg').html('')
		$.ajax({
			url:'ajax.php?action=update_tables',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully updated.',"success");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>
