<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"> طلبات متجر ووكومرس </h1>
			</div>
			<!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-left">
					<li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
					<li class="breadcrumb-item active"> طلبات متجر ووكومرس </li>
				</ol>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>
<?php
$data = file_get_contents('http://localhost/woo_orders/product.php');
$data = json_decode($data, true);
?>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="my_table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th> رقم الطلب </th>
										<th>تاريخ الطلب </th>
										<th>حالة الطلب </th>
										<th> العميل </th>
										<th> المجموع </th>
										<th> </th>
									</tr>
								</thead>
								<tbody>
									<?php $i = 1; ?>
									<?php foreach ($data as $row) : ?>
										<tr>
											<td><?= $i; ?></td>
											<td> <?= $row['number']; ?> </td>
											<td> <?= $row['date_created']; ?> </td>
											<td><?= $row['status']; ?></td>
											<td>
												<?= $row['billing']['first_name']; ?>
												<?= $row['billing']['last_name']; ?>
											</td>
											<td><?= $row['total']; ?></td>
											<td>
												<form method="post" action="main.php?dir=woocommerce&page=add" enctype="multipart/form-data">
													<!-- start client data -->
													<input type="text" name="order_number" value="<?php echo $row['number']; ?>">
													<input type="text" name="name" value="<?php echo $row['billing']['first_name'] . $row['billing']['last_name']; ?>">
													<input type="text" name="email" value="<?php echo $row['billing']['email'] ?>">
													<input type="text" name="phone" value="<?php echo $row['billing']['phone'] ?>">
													<input type="text" name="area" value="<?php echo  $row['billing']['state']  ?>">
													<input type="text" name="city" value="<?php echo  $row['billing']['city']  ?>">
													<input type="text" name="address" value="<?php echo $row['billing']['address_1']  ?>">
													<!--  start shipping  -->
													<input type="text" name="ship_name" value="<?php echo $row['shipping']['first_name'] . $row['billing']['last_name']; ?>">
													<input type="text" name="ship_area" value="<?php echo  $row['shipping']['state']  ?>">
													<input type="text" name="ship_city" value="<?php echo  $row['shipping']['city']  ?>">
													<input type="text" name="ship_address" value="<?php echo $row['shipping']['address_1']  ?>">
													<input type="text" name="ship_price" value="<?php echo $row['shipping_total'] ?>">
													<!-- order details  -->
													<input type="text" name="order_details" value="<?php echo $row['customer_note'] ?>">
													<input type="text" name="order_date" value="<?php echo $row['date_created'] ?>">
													<input type="text" name="status" value="<?php echo $row['status'] ?>">
													<input type="text" name="status_value" value="<?php echo $row['status'] ?>">
													<input type="text" name="total_price" value="<?php echo $row['total'] ?>">
													<button name="add_order" type="submit" class="btn btn-primary btn-sm"> اضافة الطلب <i class="fa fa-plus"></i> </button>
												</form>
											</td>
										</tr>
										<?php $i++; ?>
									<?php endforeach; ?>
								</tbody>
						</div>
					</div>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</section>