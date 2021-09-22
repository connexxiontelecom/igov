<?=
$this->extend('layouts/admin')
?>




<?= $this->section('content') ?>


<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">

            <div class="page-title-box">

                <div class="page-title-right">

                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('office') ?>">iGov</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Employees</a></li>
                        <li class="breadcrumb-item active">All Contracts</li>
                    </ol>

                </div>
                <h4 class="page-title">All Contracts</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row" style="margin-top: -50px">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">



                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Title</th>
                            <th>Opening Date</th>
                            <th>Closing Date</th>
                            <th> Status </th>
                            <th> Date </th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <?php $serial = 1; ?>
                        <tbody>
                        <?php foreach ($contracts as $contract): ?>
                            <tr>
                                <td><?= $serial++ ?></td>
                                <td><?= $contract['contract_title'] ?></td>
                                <td class="text-success"><?= date('d M, Y', strtotime($contract['contract_opening_date'])) ?></td>
                                <td class="text-danger"><?= date('d M, Y', strtotime($contract['contract_closing_date'])) ?></td>
                                <td><?php
                                    if($contract['contract_status'] == 0):?>
                                        Unpublished
                                    <?php elseif ($contract['contract_status'] == 1): ?>
                                        Open
                                    <?php else: ?>
                                        Closed
                                    <?php endif; ?>
                                </td>
                                <td><?= $contract['created_at'] ?></td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?= route_to('edit-contract',  $contract['contract_slug']) ?>"><i class="mdi mdi-pencil mr-2 text-muted font-18 vertical-middle"></i>Edit Contract</a>
                                            <a class="dropdown-item" href="<?= route_to('view-contract', $contract['contract_slug']) ?>"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>View Contract</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->


    </div>







    <?= $this->endSection() ?>

    <?= $this->section('extra-scripts') ?>


    <?= $this->endSection() ?>
