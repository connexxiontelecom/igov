<?= $this->extend('layouts/normal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title">My Bids</h4>
                <p class="card-title-desc">List of all your bids
                </p>

                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Contract Title</th>
                        <th>Opening Date</th>
                        <th>Closing Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    <?php $serial = 1; ?>
                    <?php foreach ($my_bids as $contract): ?>
                        <tr>
                            <td><?= $serial++ ?></td>
                            <td><?= strlen($contract['contract_title']) > 45 ? substr($contract['contract_title'],0,42).'...' : $contract['contract_title']  ?></td>
                            <td class="text-success"><?= date('d M, Y', strtotime($contract['contract_opening_date'])) ?></td>
                            <td class="text-danger"><?= date('d M, Y', strtotime($contract['contract_closing_date'])) ?></td>
                            <td>
                                <?php if($contract['contract_status'] == 0): ?>
                                    <label for="" class="label label-warning">Unpublished</label>
                                <?php elseif ($contract['contract_status'] == 1): ?>
                                    <label for="" class="label label-success">Opened</label>
                                <?php elseif ($contract['contract_status'] == 2): ?>
                                    <label for="" class="label label-danger">Closed</label>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= route_to('contract-details', $contract['contract_slug']) ?>" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<?= $this->endSection() ?>
