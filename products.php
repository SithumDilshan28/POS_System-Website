<?php include('db_connect.php');?>

<div class="container-fluid mt-5">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<!-- <div class="col-md-4">
			<form action="" id="manage-product">
				<div class="card">
					<div class="card-header">
						   Product Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Category</label>
								<select name="category_id" id="category_id" class="custom-select select2" required>
									<option value=""></option>
									<?php
									$qry = $conn->query("SELECT * FROM categories order by name asc");
									while($row=$qry->fetch_assoc()):
										$cname[$row['id']] = ucwords($row['name']);
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea name="description" id="description" cols="30" rows="4" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" required>
							</div>
							<div class="form-group">
								<div class="custom-control custom-switch">
								  <input type="checkbox" class="custom-control-input" id="status" name="status" checked value="1" required>
								  <label class="custom-control-label" for="status">Available</label>
								</div>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12 text-center">
								<button class="btn btn-primary"> Save</button>
								<button class="btn btn-default" type="button" onclick="$('#manage-product').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div> -->
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5>Product List</h5>
						<span class="float:right"><a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="index.php?page=add-product" id="new_order">
						<i class="fa fa-plus"></i> Add Product </a></span>
					</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Category</th>
									<th>Name</th>
									<th>Description</th>
									<th>Price</th>
									<th>Status</th>
									
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$product = $conn->query("SELECT * FROM products order by id asc");
								while($row=$product->fetch_assoc()):
								?>
								<tr>
									<td><?php echo $i++ ?></td>
									<td class="">
										<?php echo $cname[$row['category_id']] ?>
									</td>
									<td class="">
									<?php echo $row['name'] ?></td>
									<td class="">
									<?php echo $row['description'] ?>
									<td class="">
									<?php echo number_format($row['price'],2) ?></td>
									</td>
									<td class="">
										
										 <?php echo $row['status'] == 1 ? " Available" : "Unavailable" ?>
									</td>
									<td >

										<!-- <a class="btn btn-primary btn-sm edit_product" href="index.php?page=edit-product#<?php echo $row['id'] ?>" type="button" data-id="" data-description="<?php echo $row['description'] ?>" data-name="<?php echo $row['name'] ?>"  data-price="<?php echo $row['price'] ?>"  data-status="<?php echo $row['status'] ?>" data-category_id="<?php echo $row['category_id'] ?>"><i class="fa fa-edit"></i></a> -->

										<button class="btn btn-danger btn-sm delete_product" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
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
	
	td{
		vertical-align: middle !important;
	}
	td p {
		margin:unset;
	}
	.custom-switch{
		cursor: pointer;
	}
	.custom-switch *{
		cursor: pointer;
	}
</style>
<script>
	$('#manage-product').on('reset',function(){
		$('input:hidden').val('')
		$('.select2').val('').trigger('change')
	})
	
	$('#manage-product').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_product',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_product').click(function(){
		start_load()
		var cat = $('#manage-product')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id')).trigger('change')
		if($(this).attr('data-status') == 1)
			$('#status').prop('checked',true)
		else
			$('#status').prop('checked',false)
		end_load()
	})
	$('.delete_product').click(function(){
		_conf("Are you sure to delete this product?","delete_product",[$(this).attr('data-id')])
	})
	function delete_product($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_product',
			method:'POST',
			data:{id:$id},
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
	$('table').dataTable()
</script>