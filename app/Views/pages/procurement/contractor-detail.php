<?= $this->extend('layouts/master'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">iGov</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contractor Details</a></li>
                    </ol>
                </div>
                <h4 class="page-title">Contractor Details</h4>
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
                            <?php if(session()->has('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?= session()->get('success') ?>
                                </div>
                            <?php endif; ?>
                            <h4 class="header-title">Contractor Details</h4>
                            <p class="text-muted font-13">
                                Details of registered contractor
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-lg-right mt-lg-0">
                                <div class="btn-group mr-2">
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateStatusModal"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>Update Status</a>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" data-target="#renewLicenseModal" data-toggle="modal" class="btn btn-success btn-sm"><i class="mdi mdi-plus-circle mr-1"></i> Renew License</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4" style="margin-top: -50px">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">Contractor Details</h5>
                                <div class="form-group mb-3">
                                    <label for="registry-name">Contractor Name</label>
                                    <input type="text" readonly  class="form-control" value="<?= $contractor->contractor_name ?>" required="">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="registry-name">Contractor Address</label>
                                    <input type="text" readonly  class="form-control" value="<?= $contractor->contractor_address ?>" required="">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="registry-name">Contractor Email</label>
                                    <input type="text" readonly  class="form-control" value="<?= $contractor->contractor_email ?>" required="">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="registry-name">Contractor Mobile No.</label>
                                    <input type="text" readonly  class="form-control" value="<?= $contractor->contractor_mobile_no ?>" required="">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="registry-name">Contractor Website</label>
                                    <input type="text" readonly  class="form-control" value="<?= $contractor->contractor_website ?>" required="">
                                </div>

                                <div class="form-group">
                                    <label for="site-desc">About Contractor</label>
                                    <textarea class="form-control" readonly name="registry_description" id="site-desc" rows="4"><?= $contractor->about_contractor ?> </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card-box">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Documents</h5>
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Renewal Log</h5>
                                <div class="mt-5" style="height: 300px; overflow: auto">
                                    <ul class="list-unstyled p-2">
                                   <?php foreach ($licenses as $license): ?>
                                       <li>
                                           <span class="active-dot dot"></span>
                                           <h5 class="mt-0 mb-1">Category Name</h5>
                                           <em><?= $license->category_name ?></em>
                                           <p class="text-muted">
                                               <label for="" class="text-primary"> Start Date</label>
                                               <small class="text-muted">
                                                   <?= date('d M, Y', strtotime($license->contractor_license_start_date)) ?>
                                               </small>
                                               |
                                               <label for="" class="text-danger">End Date</label>
                                               <small class="text-muted">
                                                   <?= date('d M, Y', strtotime($license->contractor_license_end_date)) ?>
                                               </small>
                                               |
                                               <label for="" class="text-success">Amount</label>
                                               <small class="text-muted">
                                                   <?= number_format($license->license_amount) ?>
                                               </small>
                                           </p>
                                       </li>

                                    <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>
<div class="modal fade" id="renewLicenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Renewal License</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('renew-license') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">License Category</label>
                                <select name="license_category" id="" class="form-control">
                                    <option selected disabled>--Select category--</option>
                                    <?php foreach($categories as $cat): ?>
                                        <option value="<?= $cat['contractor_license_category_id'] ?>"><?= $cat['category_name'] ?? '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Year</label>
                                <input type="text" name="start_date" placeholder="Year" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Subscription</label>
                                <input type="number" name="amount" step="0.01" placeholder="Amount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="description"  placeholder="Type description here..."  class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="contractorId" value="<?= $contractor->contractor_id ?>">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('renew-license') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option selected disabled>--Select status--</option>
                                    <option value="1">Whitelist</option>
                                    <option value="2">Blacklist</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Reason</label>
                                <textarea class="form-control" name="reason" placeholder="State reason" id="reason" style="resize: none;"></textarea>
                            </div>
                        </div>
                         </div>
                    <div class="row">
                        <input type="hidden" name="contractorId" value="<?= $contractor->contractor_id ?>">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('extra-scripts'); ?>

<?= $this->endSection(); ?>


