<?php
include 'db_connect.php';
$order = $conn->query("SELECT * FROM orders where id = {$_GET['id']}");
foreach ($order->fetch_array() as $k => $v) {
	$$k = $v;
}
$items = $conn->query("SELECT o.*,p.name FROM order_items o inner join products p on p.id = o.product_id where o.order_id = $id ");
?>

<style>
	.flex {
		display: inline-flex;
		width: 100%;
	}

	.w-50 {
		width: 50%;
	}

	.text-center {
		text-align: center;
	}

	.text-right {
		text-align: right;
	}

	table.wborder {
		width: 100%;
		border-collapse: collapse;
	}

	table.wborder>tbody>tr,
	table.wborder>tbody>tr>td {
		border: 1px solid;
	}

	p {
		margin: unset;
	}
</style>
<div class="container-fluid mt-1">
	<h5 class="text-center"><b><?php echo $amount_tendered > 0 ? "HEAVY VEHICLE MOTORS (PVT) LTD" : "HEAVY VEHICLE MOTORS (PVT) LTD" ?></b></h5>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "583, Pattiya Junction, Kandy Road, Kelaniya" : "583, Pattiya Junction, Kandy Road, Kelaniya" ?></b></p>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "heavyvehiclemotors@gmail.com" : "heavyvehiclemotors@gmail.com" ?></b></p>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "Kasun - 071 0810871" : "Kasun - 071 0810871" ?></b></p>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "Dhanushka - 074 0544959" : "Dhanushka - 074 0544959" ?></b></p>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "Amith - 075 4632480" : "Amith - 075 4632480" ?></b></p>

	<p class="text-center"><b><?php echo $amount_tendered > 0 ? "Dilshan - 077 3611296" : "Dilshan - 077 3611296" ?></b></p>





	<hr>
	<div class="flex">
		<div class="w-100">
			<?php if ($amount_tendered > 0) : ?>
				<p>Invoice Number: <b><?php echo $ref_no ?></b></p>
			<?php endif; ?>
			<p>Customer Name: <b><?php echo $customer_name ?></b></p>
			<p>Date: <b><?php echo date("M d, Y", strtotime($date_created)) ?></b></p>

		</div>
	</div>
	<hr>
	<h6><b>Order List</b></h6>
	<table width="100%">
		<thead>
			<tr>
				<td><b>Item Code</b></td>
				<td><b>Item Name</b></td>
				<td><b>Item QTY</b></td>
				<td class="text-right"><b>Amount</b></td>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = $items->fetch_assoc()) :
			?>
				<tr>
					<td>HVM-00<?php echo $row['product_id'] ?></td>
					<td>
						<p><?php echo $row['name'] ?></p><?php if ($row['qty'] > 0) : ?><small>(<?php echo number_format($row['price']) ?> LKR)</small> <?php endif; ?>
					</td>
					<td><?php echo $row['qty'] ?></td>
					<td class="text-right"><?php echo number_format($row['amount']) ?> LKR</td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<hr>
	<table width="100%">
		<tbody>
			<tr>
				<td><b>Total Amount</b></td>
				<td class="text-right"><b><?php echo number_format($total_amount) ?> LKR</b></td>
			</tr>
			<?php if ($amount_tendered > 0) : ?>


				<tr>
					<td><b>Amount Tendered</b></td>
					<td class="text-right"><b><?php echo number_format($amount_tendered) ?> LKR</b></td>
				</tr>
				<tr>
					<td><b>Change</b></td>
					<td class="text-right"><b><?php echo number_format($amount_tendered - $total_amount) ?> LKR</b></td>
				</tr>
			<?php endif; ?>

		</tbody>
	</table>
	<hr>
	<p class="m-auto text-center w-75"><b>Please call our hotline 071 0810871 for your valued suggestions and comments.</b></p>
	
</div>