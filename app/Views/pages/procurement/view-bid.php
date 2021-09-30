<?= $this->extend('layouts/admin'); ?>

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bid Details</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Bid Details</h4>
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
                            <h4 class="header-title">Bid Details</h4>
                            <p class="text-muted font-13">
                                Details of bid submission
                            </p>
                        </div>
                        <div class="col-lg-4">

                                <div class="btn-group">
                                    <?php if($bid['contract_bd_status'] == 0): ?>
                                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#bidModalApprove" type="button">Approve</button>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#bidModalDecline" type="button">Decline</button>
                                    <?php endif; ?>
                                    <a href="<?= route_to('all-contracts') ?>" class="btn btn-secondary btn-sm">Back</a>
                                </div>
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
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                            <i class="dripicons-dots-3"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-pencil mr-1"></i>Edit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-delete mr-1"></i>Delete</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-email-outline mr-1"></i>Invite</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item"><i class="mdi mdi-exit-to-app mr-1"></i>Leave</a>
                                        </div>
                                    </div>
                                    <!-- project title-->
                                    <h3 class="mt-0 font-20">
                                        <?= $bid['contract_title'] ?>
                                    </h3>
                                    <div class="">
                                        <?php if($bid['contract_bd_status'] == 0): ?>
                                            <label for="" class="badge badge-secondary">Unpublished</label>
                                        <?php elseif ($bid['contract_bd_status'] == 1): ?>
                                            <label for="" class="badge badge-primary">Opened</label>
                                        <?php elseif ($bid['contract_bd_status'] == 2): ?>
                                            <label for="" class="badge badge-warning">Closed</label>
                                        <?php endif; ?>
                                    </div>

                                    <h5>Contract Scope:</h5>

                                    <?= $bid['contract_scope'] ?? '' ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <h5>Opening Date</h5>
                                                <p><?= date('d M, Y', strtotime($bid['contract_opening_date'])) ?> <small class="text-muted"><?= date('h:i a', strtotime($bid['contract_opening_date'])) ?></small></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-4">
                                                <h5>Closing Date</h5>
                                                <p><?= date('d M, Y', strtotime($bid['contract_closing_date'])) ?> <small class="text-muted"><?= date('h:i a', strtotime($bid['contract_closing_date'])) ?></small></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h5>Contractor:</h5>
                                        <p><strong>Name: </strong><?= $bid['contractor_name'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Bid Documents</h5>
                                    <?php if(count($documents) > 0): ?>
                                        <?php foreach($documents as $attachment):?>
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
                                                            <a href="javascript:void(0);" class="text-muted font-weight-bold"><?= substr($attachment['contract_bidding_title'],0,23) ?></a>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a target="_blank" href="/uploads/posts/<?=$attachment['contract_bidding_document'] ?>" class="btn btn-link btn-lg text-muted">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bidModalApprove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= route_to('update-bid-status') ?>" method="post" >
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Are you sure you want to <code>approve</code> this bid request?</label>
                                    <input type="hidden" name="status" value="1">
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <input type="hidden" name="contract_bid_id" value="<?= $bid['contract_bidding_id'] ?>">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm" type="button">Cancel</button>
                                        <button class="btn btn-sm btn-primary" type="submit">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bidModalDecline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= route_to('update-bid-status') ?>" method="post" >
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Are you sure you want to <code>decline</code> this bid request?</label>
                                    <input type="hidden" name="status" value="2">
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-center">
                                <input type="hidden" name="contract_bid_id" value="<?= $bid['contract_bidding_id'] ?>">
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button class="btn btn-secondary btn-sm" type="button">Cancel</button>
                                        <button class="btn btn-sm btn-primary" type="submit">Yes</button>
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
