<?= $this->extend('layouts/normal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <h5>Welcome Back !</h5>
                        <p class="text-muted"><?= $contractor_name ?? '' ?></p>

                        <div class="mt-4">
                            <a href="#" class="btn btn-primary btn-sm">View more <i class="mdi mdi-arrow-right ml-1"></i></a>
                        </div>
                    </div>

                    <div class="col-5 ml-auto">
                        <div>
                            <img src="/nassets/images/widget-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header bg-transparent p-3">
                <h5 class="header-title mb-0">Summary</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="media my-2">

                        <div class="media-body">
                            <p class="text-muted mb-2">Total Bids</p>
                            <h5 class="mb-0"><?= number_format(count($my_bids ?? 0)) ?></h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-layer-group"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Pending </p>
                            <h5 class="mb-0 text-warning"><?= number_format(count($pending)) ?></h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-analytics"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Approved</p>
                            <h5 class="mb-0 text-success"><?= number_format(count($approved)) ?></h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-ruler"></i>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="media my-2">
                        <div class="media-body">
                            <p class="text-muted mb-2">Declined</p>
                            <h5 class="mb-0 text-danger"><?= number_format(count($declined)) ?></h5>
                        </div>
                        <div class="icons-lg ml-2 align-self-center">
                            <i class="uim uim-box"></i>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="float-right ml-2">
                    <a href="#">View all</a>
                </div>
                <h5 class="header-title mb-4">Latest Transaction</h5>

                <div class="table-responsive">
                    <table class="table table-centered table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">S/No.</th>
                            <th scope="col">Title</th>
                            <th scope="col">Opening Date</th>
                            <th scope="col">Closing Date</th>
                            <th scope="col">status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $serial = 1; ?>

                        <?php if(count($my_bids) > 0): foreach ($my_bids as $bid): ?>
                            <tr>
                                <th scope="row">
                                    <a href="javascript:void(0);"><?= $serial++ ?></a>
                                </th>
                                <td><?= $bid['contract_title'] ?></td>
                                <td class="text-success"><?= date('d M, Y', strtotime($bid['contract_opening_date'])) ?></td>
                                <td class="text-danger"><?= date('d M, Y', strtotime($bid['contract_closing_date'])) ?></td>
                                <td>status</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= route_to('contract-details', $bid['contract_slug']) ?>" class="btn btn-outline-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end row -->



<?= $this->endSection() ?>
