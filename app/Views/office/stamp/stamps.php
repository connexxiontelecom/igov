<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?= site_url('office') ?>">iGov</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Messaging Settings</a></li>
						<li class="breadcrumb-item active">Stamp</li>
					</ol>
				</div>
				<h4 class="page-title">Stamp</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->
	<div class="row" style="margin-top: -50px">
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<?php if(session()->has('action')): ?>
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<i class="mdi mdi-check-all mr-2"></i><strong>Action Successful !</strong>
						</div>
					<?php endif; ?>
					<div>
						<a href="<?=site_url('new-stamp')?>" type="button" class="btn btn-primary" style="float: right"> <i class="mdi mdi-plus mr-2"></i>New Stamp</a>
					</div>
					<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
						<thead>
						<tr>
							<th>S/N</th>
							<th>Stamp Type</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tbody>
						<?php if ($stamps):
							$i = 1;
							foreach ($stamps as $stamp):
								?>
								<tr>
									<td><?=$i++;?></td>
									<td><?=$stamp['stamp_type']?></td>
									<td><?=$stamp['stamp_status'] == 0 ? 'Inactive' : 'Active'?></td>
									<td>
										<a href="<?=site_url('manage-stamp/').$stamp['stamp_id']?>" type="button" class="btn btn-primary"><i class="mdi mdi-pen-lock"></i></a>
									</td>
								</tr>
							<?php endforeach; endif;?>
						</tbody>
					</table>
				</div> <!-- end card-body -->
			</div> <!-- end card-->
		</div> <!-- end col -->
	</div>
</div>
<?= $this->endSection() ?>

