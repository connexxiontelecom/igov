<?= $this->extend('layouts/master'); ?>

<?= $this->section('extra-styles') ?>
<link href="/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?= $this->endsection() ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">iGov</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contract Details</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Contract Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="header-title">Contract Detail</h4>
                            <p class="text-muted font-13">
                                Details for this contract
                            </p>
                        </div>
                        <div class="col-lg-4">

                            <div class="float-right">
                                <a href="<?= route_to('all-contracts') ?>" class="btn btn-success btn-sm">Back</a>
                            </div>
                            <?php if($contract['contract_status'] == 0): ?>
                            <button class="btn btn-danger" data-target="#publishContractModal" data-toggle="modal">Publish Contract</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if(session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= session()->get('success') ?>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-xl-8 col-lg-6">
                            <!-- project card -->
                            <div class="card d-block">
                                <div class="card-body">
                                    <!-- project title-->
                                    <h3 class="mt-0 font-20">
                                        <?= $contract['contract_title'] ?? ''?>
                                    </h3>
                                    <div class="">
                                        <?php if($contract['contract_status'] == 0): ?>
                                            <label for="" class="badge badge-secondary">Unpublished</label>
                                        <?php elseif ($contract['contract_status'] == 1): ?>
                                            <label for="" class="badge badge-primary">Opened</label>
                                        <?php elseif ($contract['contract_status'] == 2): ?>
                                            <label for="" class="badge badge-warning">Closed</label>
                                        <?php endif; ?>
                                    </div>

                                    <h5>Contract Scope:</h5>

                                    <?= $contract['contract_scope'] ?? '' ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <h5>Opening Date</h5>
                                                <p><?= date('d M, Y', strtotime($contract['contract_opening_date'])) ?> <small class="text-muted"><?= date('h:i a', strtotime($contract['contract_opening_date'])) ?></small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <h5>Closing Date</h5>
                                                <p><?= date('d M, Y', strtotime($contract['contract_closing_date'])) ?> <small class="text-muted"><?= date('h:i a', strtotime($contract['contract_closing_date'])) ?></small></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h5>Board Members:</h5>
                                        <?php foreach ($participants as $participant): ?>
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $participant->employee_f_name ?? '' ?> <?= $participant->employee_l_name ?? '' ?>" class="d-inline-block">
                                                <img src="/assets/images/users/user-6.jpg" class="rounded-circle img-thumbnail avatar-sm" alt="friend">
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 mb-3">Comments (<?= number_format(count($conversations)) ?>)</h4>
                                    <form action="<?= route_to('leave-comment-contract') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <textarea name="comment" class="form-control form-control-light mb-2" style="resize:none;" placeholder="Write message" id="example-textarea" rows="3"></textarea>
                                        <div class="text-right">
                                            <input type="hidden" name="contract_cm_id" value="<?= $contract['contract_id'] ?>">
                                            <input type="hidden" name="contract_cm_slug" value="<?= $contract['contract_slug'] ?>">
                                            <div class="btn-group mb-2 ml-2">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="mt-2">
                                    <?php foreach ($conversations as $conversation): ?>
                                        <div class="media mb-2">
                                            <img class="mr-2 avatar-sm rounded-circle" src="/assets/images/users/user-3.jpg" alt="Generic placeholder image">
                                            <div class="media-body">
                                                <h5 class="mt-0">
                                                    <a href="#" class="text-reset"><?= $conversation->employee_f_name ?? '' ?> <?= $conversation->employee_l_name ?? '' ?></a> <small class="text-muted"><?= date('d M, Y h:i a', strtotime($conversation->created_at)) ?></small></h5>
                                                <?= $conversation->contract_convo ?? '' ?>
                                                <br>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Tender Documents</h5>
                                    <?php if(count($attachments) > 0): ?>
                                        <?php foreach($attachments as $attachment):?>
                                            <div class="card mb-1 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar-sm">
                                                            <span class="avatar-title badge-soft-primary text-primary rounded">
                                                                DOC
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <div class="col pl-0">
                                                            <a href="javascript:void(0);" class="text-muted font-weight-bold"><?= substr($contract['contract_title'],0,23) ?></a>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a target="_blank" href="/uploads/posts/<?=$attachment->contract_att_attachment ?>" class="btn btn-link btn-lg text-muted">
                                                                <i class="dripicons-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <h5 class="text-center">No attachments</h5>
                                    <?php endif; ?>
                                    <h5 class="card-title mb-3 mt-4">Certificate of "No Objection."</h5>
                                    <?php if(!is_null($contract['contract_certificate'])): ?>
                                            <div class="card mb-1 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="avatar-sm">
                                                            <span class="avatar-title badge-soft-primary text-primary rounded">
                                                                FILE
                                                            </span>
                                                            </div>
                                                        </div>
                                                        <div class="col pl-0">
                                                            <a href="javascript:void(0);" class="text-muted font-weight-bold"><?= substr($contract['contract_title'],0,23) ?></a>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a target="_blank" href="/uploads/posts/<?=$contract['contract_certificate'] ?>" class="btn btn-link btn-lg text-muted">
                                                                <i class="dripicons-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php else: ?>
                                        <h5 class="text-center">No certificate</h5>
                                    <?php endif; ?>
                                    <h5 class="card-title mb-3 mt-4">Bids</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="publishContractModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Publish Contract</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= route_to('publish-contract') ?>" method="post" >
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted">Are you sure you want to publish this contract?</p>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <input type="hidden" name="contract_id" value="<?= $contract['contract_id'] ?>">
                                <input type="hidden" name="contract_slug" value="<?= $contract['contract_slug'] ?>">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm" type="button">Cancel</button>
                                        <button class="btn btn-sm btn-primary" type="submit">Publish Contract</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('extra-scripts'); ?>
<script src="/assets/libs/select2/js/select2.min.js"></script>
<?= $this->endSection(); ?>
