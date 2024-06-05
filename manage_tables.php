<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM tables where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>
<div class="container-fluid">
	<form action="" id="manage-tables">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Table Code</label>
			<input type="text" class="form-control form-control-sm" name="code" value="<?php echo isset($code) ? $code : '' ?>">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Status</label>
			<select name="status" id="" class="custom-select custom-select-sm">
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : ''; ?>>Empty</option>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : ''; ?>>Filled</option>
			</select>
		</div>
	</form>
</div>
<script>
	$('#manage-tables').submit(function(e){
		e.preventDefault()
		$('input').removeClass("border-danger")
		start_load()
		$('#msg').html('')
		$.ajax({
			url: 'ajax.php?action=save_tables',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success: function(resp){
				if (resp == 1){
					alert_toast('Data successfully saved.', "success");
					setTimeout(function(){
						location.replace('index.php?page=tables_list')
					}, 750)
				} else if (resp == 2){
					$('#msg').html("<div class='alert alert-danger'>Tables already exist.</div>");
					$('[name="code"]').addClass("border-danger")
					end_load()
				}
			}
		})
	})
</script>
