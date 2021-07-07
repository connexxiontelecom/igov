<?= $this->extend('layouts/master'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
	<!-- start page title -->
	<div class="row">
		<?php if($type == 1): ?>
		
		<?php endif; ?>
		<?php if($type == 2): ?>
		<div class="col-12">
			<div class="page-title-box">
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?= site_url('/') ?>">iGov</a></li>
						<li class="breadcrumb-item"><a href="javascript: void(0);">Messaging</a></li>
						<li class="breadcrumb-item"><a href="<?= site_url('/circulars')?>">circular Board</a></li>
						<li class="breadcrumb-item"><a href="<?= site_url('/my-circulars')?>">My circulars</a></li>
						<li class="breadcrumb-item active">New circular</li>
					</ol>
				</div>
				<h4 class="page-title">View Circular</h4>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<!-- end page title -->
	<div class="row">
		<div class="col-xl-8 col-lg-7">
			<!-- project card -->
			<div class="card d-block">
				<div class="card-body">
					
					<div class="clearfix"></div>
					
					<h4><?=$post['p_subject'] ?></h4>
					
					
					
					<?=$post['p_body'] ?>
					
					<div class="row">
						
						
						<div class="col-md-4">
							<!-- start due date -->
							<p class="mt-2 mb-1 text-muted">Created By</p>
							<div class="media">
								<img src="../assets/images/users/user-9.jpg" alt="Arya S"
									 class="rounded-circle mr-2" height="24" />
								
								<div class="media-body">
									<h5 class="mt-1 font-size-14">
										<?=$post['created_by'] ?>
									</h5>
								</div>
							</div>
							<!-- end due date -->
						</div>
						
						<div class="col-md-4">
							<!-- start due date -->
							<p class="mt-2 mb-1 text-muted">Signed By</p>
							<div class="media">
								<img src="../assets/images/users/user-9.jpg" alt="Arya S"
									 class="rounded-circle mr-2" height="24" />
								
								<div class="media-body">
									<h5 class="mt-1 font-size-14">
										<?=$post['user_name'] ?>
									</h5>
								</div>
							</div>
							<!-- end due date -->
						</div> <!-- end col -->
						
						<div class="col-md-4">
							<!-- assignee -->
							<p class="mt-2 mb-1 text-muted">Date</p>
							<div class="media">
								<i class='mdi mdi-calendar-month-outline font-18 text-success mr-1'></i>
								<div class="media-body">
									<h5 class="mt-1 font-size-14">
										<?php
											$date = date_create($post['p_date']);
											echo date_format($date,"d M Y H:i a");
										?>
									</h5>
								</div>
							</div>
							<!-- end assignee -->
						</div> <!-- end col -->
					</div> <!-- end row -->
					<!-- start sub tasks/checklists -->
					
					<!-- end sub tasks/checklists -->
				
				</div> <!-- end card-body-->
			
			</div> <!-- end card-->
			
			
			<!-- end card-->
		</div> <!-- end col -->
		
		<div class="col-xl-4 col-lg-5">
			
			<div class="card">
				<div class="card-body">
					
					
					<h5 class="card-title font-16 mb-3">Attachments</h5>
					
					
					
					<?php if(!empty($attachments)):
						foreach ($attachments as $attachment):
						?>
					<div class="card mb-1 shadow-none border">
						<div class="p-2">
							<div class="row align-items-center">
								<div class="col-auto">
									<div class="avatar-sm">
                                                            <span class="avatar-title badge-soft-primary text-primary rounded">
                                                               <?php echo strtoupper(substr($attachment['pa_link'], strpos($attachment['pa_link'], ".") + 1)); ?>
                                                            </span>
									</div>
								</div>
								<div class="col pl-0">
									
									<p class="mb-0 font-12"><?php
											$filename = 'uploads/posts/'.$attachment['pa_link'];
//											$handle = fopen($filename, "r");
//											$contents = fread($handle, filesize($filename));
											//echo $filename;
											$size = round(filesize($filename)/(1024 * 1024), 2);
											echo $size."MB";
//											fclose($handle);
											
										?></p>
								</div>
								<div class="col-auto">
									<!-- Button -->
									<a href="<?='/uploads/posts/'.$attachment['pa_link']; ?>" target="_blank" class="btn btn-link font-16 text-muted">
										<i class="dripicons-download"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; else: echo "No Attachments"; endif; ?>
					
					
				</div>
			</div>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('extra-scripts'); ?>
<?//=view('pages/posts/_circular-scripts.php')?>
<?= $this->endSection(); ?>
