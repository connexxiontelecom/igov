<?= $this->extend('layouts/normal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?= $contract['contract_title'] ?></h4>
                <p class="card-title-desc">
                    Contract details
                </p>

                <div class="row">
                    <div class="col-lg-12">
                        <p class="">
                            <span>Opening Date: </span> <span class="text-success"><?= date('d M, Y', strtotime($contract['contract_opening_date']))?></span>
                            <span>Closing Date: </span> <span class="text-danger"><?= date('d M, Y', strtotime($contract['contract_closing_date']))?></span>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <h5>Contract Scope</h5>
                        <?= $contract['contract_scope'] ?? '' ?>
                        <h5 class="mt-3">Eligibility</h5>
                        <?= $contract['contract_eligibility'] ?? '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-xl-end mb-4">
                    <div class="btn-group " role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary">Back</button>
                        <?php if(empty($bidding)): ?>
                        <a href="<?= route_to('contract-bidding', $contract['contract_slug']) ?>" class="btn btn-primary">Bid</a>
                        <?php endif; ?>
                    </div>

                </div>
                <h4 class="header-title">Tender Documents</h4>
                <?php if(count($attachments) > 0): ?>
                <?php foreach($attachments as $attachment):?>
                        <a href="/uploads/posts/<?=$attachment->contract_att_attachment ?>" target="_blank" class="">
                            <img src="/nassets/images/pdf.png" width="64" height="64" alt="">
                        </a>
                <?php endforeach; ?>
                <?php endif; ?>
                <h4 class="header-title mt-4">Certificate of "No Objection"</h4>

                <?php if(!empty($bidding)): ?>
                    <h4 class="header-title mt-4 bg-dark p-2 text-white">Your Bid Submission</h4>
                    <p>Status:
                    <?php if($bidding['contract_bd_status'] == 0): ?>
                        <label for="" class="badge badge-warning">Pending</label>
                    <?php elseif($bidding['contract_bd_status'] == 1): ?>
                            <label for="" class="badge badge-success">Approve</label>
                    <?php elseif($bidding['contract_bd_status'] == 2): ?>
                            <label for="" class="badge badge-danger">Declined</label>
                    <?php endif; ?>
                    </p>
                    <?php foreach ($bid_documents as $doc): ?>
                        <div class="form-group">
                            <p for=""><strong>Title: </strong><?= $doc['contract_bidding_title'] ?? '' ?></p>
                            <a href="/uploads/posts/<?= $doc['contract_bidding_document'] ?>" target="_blank" class="">
                                <img src="/nassets/images/pdf.png" width="64" height="64" alt="<?= $doc['contract_bidding_title'] ?? '' ?>">
                            </a>
                            <p><strong>Comment: </strong> <?= $doc['contract_bidding_comment'] ?? '' ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
