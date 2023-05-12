
<style>
	.collapse a{
		text-indent:10px;
	}

</style>

<nav id="sidebar" class='mx-lt-5 bg-white mt-5' >
		
		<div class="sidebar-list">
			<br><br>
			<a href="index.php?page=home" class="nav-item"><span class='icon-field'><i class="fa fa-tachometer-alt mr-3"></i></span> Dashboard</a>
			
			<a href="index.php?page=orders" class="nav-item "><span class='icon-field'><i class="fa fa-clipboard-list mr-3"></i></span> Orders</a>
			<a href="billing/index.php" class="nav-item "><span class='icon-field'><i class="fa fa-list-ol mr-3"></i></span> Take Orders</a>
			<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=add-category" class="nav-item "><span class='icon-field'><i class="fa fa-list-alt mr-3"></i></span>Add Categories</a>
				<a href="index.php?page=add-product" class="nav-item "><span class='icon-field'><i class="fa fa-th-list mr-3"></i></span>Add Products</a>
			<!-- <div class="mx-2 text-white">Master List</div> -->
			<a href="index.php?page=categories" class="nav-item "><span class='icon-field'><i class="fa fa-list-alt mr-3"></i></span>Manage Categories</a>
			
			<a href="index.php?page=products" class="nav-item "><span class='icon-field'><i class="fa fa-th-list mr-3"></i></span>Manage Products</a>
				
			<?php endif; ?>
			<!-- <div class="mx-2 text-white">Report</div> -->
			<a href="index.php?page=sales_report" class="nav-item "><span class='icon-field'><i class="fa fa-th-list mr-3"></i></span> Sales Report</a>
			<?php if($_SESSION['login_type'] == 1): ?>
			<!-- <div class="mx-2 text-white">Systems</div> -->
			<a href="index.php?page=users" class="nav-item "><span class='icon-field'><i class="fa fa-users mr-3"></i></span> Users</a>
			<a href="index.php?page=site_settings" class="nav-item "><span class='icon-field'><i class="fa fa-cogs mr-3" ></i></span> System Settings</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
