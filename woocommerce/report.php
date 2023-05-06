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
												<form action="post" enctype="multipart/form-data">
													<a href="" class="btn btn-primary btn-sm"> اضافة الطلب <i class="fa fa-plus"></i> </a>
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