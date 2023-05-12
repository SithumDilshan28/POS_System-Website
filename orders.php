<?php include('db_connect.php'); ?>
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.3);
		/* IE */
		-moz-transform: scale(1.3);
		/* FF */
		-webkit-transform: scale(1.3);
		/* Safari and Chrome */
		-o-transform: scale(1.3);
		/* Opera */
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}
</style>
<div class="container-fluid mt-5">

	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h5>List of Orders </h5>

						<span class="float:right"><a class="btn btn-primary btn-sm col-sm-2 float-right" href="billing/index.php" id="new_order">
								<i class="fa fa-plus"></i> New
							</a></span>

					</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Invoice</th>
									<th>Customer Name</th>
									<th>Amount</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$order = $conn->query("SELECT * FROM orders order by unix_timestamp(date_created) desc ");
								while ($row = $order->fetch_assoc()) :
								?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td>
											<p> <?php echo date("M d,Y", strtotime($row['date_created'])) ?></p>
										</td>
										<td>
											<p> <?php echo $row['amount_tendered'] > 0 ? $row['ref_no'] : 'N/A' ?></p>
										</td>
										<td>
											<p><?php echo $row['customer_name'] ?></p>
										</td>
										<td>
											<p> <?php echo number_format($row['total_amount']) ?></p>
										</td>
										<td>
											<?php if ($row['amount_tendered'] > 0) : ?>
												<span class="badge badge-success">Paid</span>
											<?php else : ?>
												<span class="badge badge-primary">Unpaid</span>
											<?php endif; ?>
										</td>
										<td>
											<button class="btn btn-sm btn-primary " type="button" onclick="location.href='billing/index.php?id=<?php echo $row['id'] ?>'" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
											<button class="btn btn-sm btn-info view_order" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-eye"></i></button>
											<button class="btn btn-sm btn-danger delete_order" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
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
		margin: unset
	}

	img {
		max-width: 250px;
		max-height: 150px;
	}
</style>
<script>
	$(document).ready(function() {
		$('table').dataTable()
	})
	// $('#new_order').click(function(){
	// 	uni_modal("New order ","billing/index.php","mid-large")

	// })
	$('.view_order').click(function() {
		uni_modal("Order  Details", "view_order.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_order').click(function() {
		_conf("Are you sure to delete this order ?", "delete_order", [$(this).attr('data-id')])
	})

	function delete_order($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_order',
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