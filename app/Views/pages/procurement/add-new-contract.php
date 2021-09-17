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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">General Settings</a></li>
                        <li class="breadcrumb-item"><a href="<?= site_url('manage-registry')?>">Registry</a></li>
                        <li class="breadcrumb-item active">New Registry</li>
                    </ol>
                </div>
                <h4 class="page-title">New Registry</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if(session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- end page title -->
    <?php $validation =  \Config\Services::validation(); ?>

    <form action="<?= route_to('add-new-contract') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row" style="margin-top: -50px">
            <div class="col-lg-6">
                <div class="card-box">
                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Contract Details</h5>
                    <div class="form-group mb-3">
                        <label for="registry-name">Title</label>
                        <input type="text" placeholder="Title" id="registry-name" name="title" class="form-control" >
                        <?php if ($validation->getError('title')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('title') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="registry-name">Tender Board</label>
                        <select name="tender_board" id="tender_board" class="form-control" multiple>
                            <option disabled selected>-- Select members --</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= $employee['employee_id'] ?>"><?= $employee['employee_f_name'] ?> <?= $employee['employee_l_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($validation->getError('tender_board')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('tender_board') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="">Opening & Closing Date</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Opening Date</span>
                            </div>
                            <input type="date" class="form-control" name="opening_date" placeholder="Opening Date" aria-label="Opening Date" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Closing Date</span>
                            </div>
                            <input type="date" class="form-control" name="closing_date" placeholder="Closing Date" aria-label="Closing Date" aria-describedby="basic-addon1">
                        </div>
                        <?php if ($validation->getError('opening_date')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('opening_date') ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($validation->getError('closing_date')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('closing_date') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Tender Document(s)</label>
                        <input type="file" name="tender_documents[]" class="form-control-file">
                        <?php if ($validation->getError('tender_documents')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('tender_documents') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Certificate of "No Objection"</label>
                        <input type="file" name="certificate" class="form-control-file">
                        <?php if ($validation->getError('certificate')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('certificate') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="site-desc">Scope of Work</label>
                        <textarea class="form-control" placeholder="Scope of Work" name="scope" id="site-desc" rows="4"></textarea>
                        <?php if ($validation->getError('scope')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('scope') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="site-desc">Eligibility</label>
                        <textarea class="form-control" placeholder="Eligibility" name="eligibility" id="site-desc" rows="4"></textarea>
                        <?php if ($validation->getError('eligibility')): ?>
                            <div class="text-danger">
                                <?= $validation->getError('eligibility') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-box">
                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Registry Access</h5>
                    <div class="custom-control custom-checkbox float-left">
                        <input type="checkbox" class="custom-control-input" id="select-all">
                        <label class="custom-control-label" for="select-all">
                            Select all users
                        </label>
                    </div>
                    <div class="mt-5" style="height: 300px; overflow: auto">

                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-3">
                    <a href="<?=site_url('manage-registry')?>" type="button" class="btn w-sm btn-danger waves-effect">Cancel</a>
                    <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('extra-scripts') ?>
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
