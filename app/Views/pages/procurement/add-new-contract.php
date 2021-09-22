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
                        <li class="breadcrumb-item active">Create New Contract</li>
                    </ol>
                </div>
                <h4 class="page-title">Create New Contract</h4>
            </div>
        </div>
    </div>
    <?php $validation =  \Config\Services::validation(); ?>
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
    <div class="row" style="padding-bottom: 0px !important;">
        <div class="col-12">
            <form action="<?= route_to('add-new-contract') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="registry-name">Title</label>
                                    <input type="text" placeholder="Title" id="registry-name" name="title" class="form-control" >
                                    <?php if ($validation->getError('title')): ?>
                                        <div class="text-danger">
                                            <?= $validation->getError('title') ?>
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

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="">Opening & Closing Date</label>
                                            <div class="input-group">
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
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="registry-name">Tender Board</label>
                                    <select name="tender_board[]" id="tender_board" class="form-control" multiple>
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
                            </div>

                            <div class="col-xl-6">
                                <div class="form-group mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0">Tender Documents</label>
                                    <input type="file" name="tender_documents[]" multiple class="form-control-file">
                                    <?php if ($tender == 1): ?>
                                        <div class="text-danger">
                                            Kindly upload tender documents
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group mt-3 mt-xl-0">
                                    <label for="projectname" class="mb-0">Certificate of "No Objection"</label>
                                    <input type="file" name="certificate" class="form-control-file">
                                    <?php if ($validation->getError('certificate')): ?>
                                        <div class="text-danger">
                                            <?= $validation->getError('certificate') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle mr-1"></i> Create</button>
                                <button type="button" class="btn btn-light waves-effect waves-light m-1"><i class="fe-x mr-1"></i> Cancel</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
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
