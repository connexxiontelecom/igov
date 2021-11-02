<?=
$this->extend('layouts/master')
?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= site_url('office') ?>">iGov</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contract</a></li>
                        <li class="breadcrumb-item active">All Bids</li>
                    </ol>
                </div>
                <h4 class="page-title">All Bids</h4>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: -50px">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Contract Title</th>
                            <th>Contractor</th>
                            <th>Opening Date</th>
                            <th>Closing Date</th>
                            <th> Status </th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <?php $serial = 1; ?>
                        <tbody>
                        <?php foreach ($bids as $bid): ?>
                            <tr>
                                <td><?= $serial++ ?></td>
                                <td><?= $bid['contract_title'] ?></td>
                                <td><?= $bid['contractor_name'] ?></td>
                                <td class="text-success"><?= date('d M, Y', strtotime($bid['contract_opening_date'])) ?></td>
                                <td class="text-danger"><?= date('d M, Y', strtotime($bid['contract_closing_date'])) ?></td>
                                <td><?php
                                    if($bid['contract_bd_status'] == 0):?>
                                        Pending
                                    <?php elseif ($bid['contract_status'] == 1): ?>
                                        Approved
                                    <?php else: ?>
                                        Declined
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-horizontal"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="<?= route_to('view-bid', $bid['contract_bidding_id']) ?>"><i class="mdi mdi-check-all mr-2 text-muted font-18 vertical-middle"></i>View Bid</a>
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
