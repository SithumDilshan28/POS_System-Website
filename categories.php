<?php include('db_connect.php'); ?>

<div class="container-fluid mt-5">

	<div class="col-lg-12">
		<div class="row">

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5>Category List</h5>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add-category" id="new_order">
								<i class="fa fa-plus"></i> Add Category </a></span>
					</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$category = $conn->query("SELECT * FROM categories order by id asc");
								while ($row = $category->fetch_assoc()) :
								?>
									<tr>
										<td ><?php echo $i++ ?></td>
										<td class=""><?php echo $row['name'] ?></td>
										<td><?php echo $row['description'] ?></td>
										<td >
											<!-- <button class="btn btn-sm btn-primary edit_category" type="button" data-id="<?php echo $row['id'] ?>" data-description="<?php echo $row['description'] ?>" data-name="<?php echo $row['name'] ?>" ><i class="fa fa-edit"></i></button> -->
											<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset;
	}
</style>
<script>
	$('#manage-category').on('reset', function() {
		$('input:hidden').val('')
	})

	$('#manage-category').submit(function(e) {
		e.preventDefault()
		start_load()
		$.ajax({
			url: 'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully added", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				} else if (resp == 2) {
					alert_toast("Data successfully updated", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	})
	$('.edit_category').click(function() {
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_category').click(function() {
		_conf("Are you sure to delete this category?", "delete_category", [$(this).attr('data-id')])
	})

	function delete_category($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_category',
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
	$('table').dataTable()
</script>