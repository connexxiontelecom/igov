<?= $this->extend('layouts/admin'); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">iGov</a></li>
                        <li class="breadcrumb-item active">Contractor License Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Contractor License Category</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <?php $validation =  \Config\Services::validation(); ?>
            <?php if(session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>
            <div class="card-box">
                <button type="button" data-target="#addLicenseCategoryModal" data-toggle="modal" class="btn btn-sm btn-blue waves-effect waves-light float-right">
                    <i class="mdi mdi-plus-circle"></i> Add New License Category
                </button>
                <h4 class="header-title mb-4">Contractor License Categories</h4>

                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table">
                    <thead>
                    <tr>
                        <th>
                            S/No.
                        </th>
                        <th>Category Name</th>
                        <th>Max. # of Contracts</th>
                        <th>Subscription</th>
                        <th class="hidden-sm">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $serial = 1; ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $serial++ ?></td>
                            <td><?= $cat['category_name'] ?? '' ?></td>
                            <td><?= $cat['max_contracts'] ?? '' ?></td>
                            <td class="text-right"><?= number_format($cat['category_amount'],2) ?? '' ?></td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalCat_<?=$cat['contractor_license_category_id'] ?>">View</a>
                                <div class="modal fade" id="modalCat_<?=$cat['contractor_license_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Contractor License Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= route_to('update-contractor-license-category') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Category Name</label>
                                                                <input type="text" name="category_name" value="<?= $cat['category_name'] ?>" placeholder="Category Name" class="form-control">
                                                                <?php if ($validation->getError('category_name')): ?>
                                                                    <div class="text-danger">
                                                                        <?= $validation->getError('category_name') ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Max. # of Contracts Name</label>
                                                                <input type="number" value="<?= $cat['max_contracts'] ?>" name="max_contracts" placeholder="Max. # of Contracts" class="form-control">
                                                                <?php if ($validation->getError('max_contracts')): ?>
                                                                    <div class="text-danger">
                                                                        <?= $validation->getError('max_contracts') ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="">Amount</label>
                                                                <input type="number" value="<?= $cat['category_amount'] ?>" step="0.01" class="form-control" placeholder="Amount" name="amount">
                                                                <?php if ($validation->getError('amount')): ?>
                                                                    <div class="text-danger">
                                                                        <?= $validation->getError('amount') ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                                <input type="hidden" name="cat" value="<?=$cat['contractor_license_category_id'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 d-flex justify-content-center">
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addLicenseCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Contractor License Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route_to('contractor-license-category') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Category Name</label>
                                <input type="text" name="category_name" placeholder="Category Name" class="form-control">
                                <?php if ($validation->getError('category_name')): ?>
                                    <div class="text-danger">
                                        <?= $validation->getError('category_name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Max. # of Contracts Name</label>
                                <input type="number" name="max_contracts" placeholder="Max. # of Contracts" class="form-control">
                                <?php if ($validation->getError('max_contracts')): ?>
                                    <div class="text-danger">
                                        <?= $validation->getError('max_contracts') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Amount</label>
                                <input type="number" step="0.01" class="form-control" placeholder="Amount" name="amount">
                                <?php if ($validation->getError('amount')): ?>
                                    <div class="text-danger">
                                        <?= $validation->getError('amount') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

