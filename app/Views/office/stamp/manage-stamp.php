<?= $this->extend('layouts/admin') ?>
<?=$this->section('extra-styles'); ?>
<link href="/assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
<?=$this->endSection() ?>
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
						<li class="breadcrumb-item"><a href="<?= site_url('manage-registry')?>">Stamp</a></li>
						<li class="breadcrumb-item active">New Stamp</li>
					</ol>
				</div>
				<h4 class="page-title">New Stamp</h4>
			</div>
		</div>
	</div>
	<!-- end page title -->
	<form method="post" enctype="multipart/form-data">
		<div class="row" style="margin-top: -50px">
			<div class="col-lg-6">
				<div class="card-box">
					<h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Stamp Details</h5>
					<div class="form-group mb-3">
						<label for="stamp-type">Stamp Type</label>
						<input type="text" id="stamp-type" name="stamp_type" class="form-control" value="<?=$stamp['stamp_type']?>" required>
					</div>
					<div class="form-group mb-3">
						<label class="mb-2">Status</label>
						<br/>
						<div class="radio form-check-inline">
							<input type="radio" id="inlineRadio1" value="1" name="stamp_status" <?=$stamp['stamp_status'] == 1 ? 'checked': ''?>>
							<label for="inlineRadio1"> Active </label>
						</div>
						<div class="radio form-check-inline">
							<input type="radio" id="inlineRadio2" value="0" name="stamp_status" <?=$stamp['stamp_status'] == 0 ? 'checked': ''?>>
							<label for="inlineRadio2"> Inactive </label>
						</div>
					</div>
					<div class="form-group">
						<label for="file">Stamp Image</label>
						<div class="form-control-wrap">
							<input id="file" type="file" data-plugins="dropify" name="file" accept=".tif,.tiff,.bmp,.jpg,.jpeg,.gif,.png"  data-default-file="/uploads/stamps/<?=$stamp['stamp_image'] ?>" required/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="card-box">
					<h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Stamp Access</h5>
					<div class="custom-control custom-checkbox float-left">
						<input type="checkbox" class="custom-control-input" id="select-all">
						<label class="custom-control-label" for="select-all">
							Select all users
						</label>
					</div>
					<div class="mt-5" style="height: 300px; overflow: auto">
						<?php foreach ($department_employees as $department => $employees): ?>
							<?php if(!empty($employees)):?>
								<h5 class="mb-2 font-size-16"><?=$department?></h5>
								<?php foreach ($employees as $employee):?>
									<div class="custom-control custom-checkbox mt-1">
										<input type="checkbox" class="custom-control-input user" id="<?=$employee['user']['user_id']?>"
                      value="<?=$employee['user']['user_id']?>" name="stamp_users[]"
											<?=in_array($employee['user']['user_id'], $stamp['stamp_users']) ? 'checked' : ''?>
                    >
										<label class="custom-control-label strikethrough" for="<?=$employee['user']['user_id']?>">
											<?=$employee['position']['pos_name'].' ('.$employee['user']['user_name'].')'?>
										</label>
									</div>
								<?php endforeach;?>
							<?php endif;?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="text-center mb-3">
					<a href="<?=site_url('manage-stamp')?>" type="button" class="btn w-sm btn-danger waves-effect">Cancel</a>
					<button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
				</div>
			</div>
		</div>
    <input type="hidden" name="stamp-id" value="<?=$stamp['stamp_id']?>">
  </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('extra-scripts') ?>
<script src="/assets/libs/dropzone/min/dropzone.min.js"></script>
<script src="/assets/libs/dropify/js/dropify.min.js"></script>
<script src="/assets/js/pages/form-fileuploads.init.js"></script>
<script>
  $('#select-all').click(e => {
    let selectAll = $('#select-all')[0]
    let allUserCheckboxes = $('.user')
    allUserCheckboxes.each(function () {
      this.checked = selectAll.checked
    })
  })
</script>
<?= $this->endSection() ?>
