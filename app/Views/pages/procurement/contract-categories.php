<?= $this->extend('layouts/master'); ?>

<?= $this->section('content'); ?>
<?php $validation =  \Config\Services::validation(); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">iGov</a></li>
                        <li class="breadcrumb-item active">Contract Categories</li>
                    </ol>
                </div>
                <h4 class="page-title">Contract Category</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-4">
            <div class="card-box">
                <form action="<?= route_to('contract-categories') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-12">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea  name="description" placeholder="Description..." class="form-control"></textarea>
                                <?php if ($validation->getError('description')): ?>
                                    <div class="text-danger">
                                        <?= $validation->getError('description') ?>
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
        <div class="col-8">

            <?php if(session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= session()->get('success') ?>
                </div>
            <?php endif; ?>
            <div class="card-box">
                <h4 class="header-title mb-4">Contract Categories</h4>

                <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="tickets-table">
                    <thead>
                    <tr>
                        <th>
                            S/No.
                        </th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th class="hidden-sm">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $serial = 1; ?>
                    <?php foreach ($contractcategories as $cat): ?>
                        <tr>
                            <td><?= $serial++ ?></td>
                            <td><?= $cat['contract_cat_name'] ?? '' ?></td>
                            <td><?= $cat['contract_cat_description'] ?? '' ?></td>
                            <td>
                                <a href="javascript:void(0);" data-target="#catModal_<?= $cat['contract_category_id'] ?>"  data-toggle="modal" class="btn btn-sm btn-info">View</a>
                                <div class="modal fade" id="catModal_<?= $cat['contract_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?= route_to('edit-contract-categories') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Category Name</label>
                                                                <input type="text" name="category_name" value="<?= $cat['contract_cat_name'] ?>" placeholder="Category Name" class="form-control">
                                                                <?php if ($validation->getError('category_name')): ?>
                                                                    <div class="text-danger">
                                                                        <?= $validation->getError('category_name') ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Description</label>
                                                                <textarea  name="description" placeholder="Description..." class="form-control"><?= $cat['contract_cat_description'] ?></textarea>
                                                                <?php if ($validation->getError('description')): ?>
                                                                    <div class="text-danger">
                                                                        <?= $validation->getError('description') ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 d-flex justify-content-center">
                                                            <div class="btn-group">
                                                                <input type="hidden" name="catid" value="<?= $cat['contract_category_id'] ?>">
                                                                <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save Changes</button>
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

<?= $this->endSection(); ?>

