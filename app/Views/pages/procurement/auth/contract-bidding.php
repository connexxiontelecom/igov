<?= $this->extend('layouts/normal') ?>
<?= $this->section('content') ?>

<div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-body">

            <h4 class="header-title">Contract Bidding</h4>
            <p class="card-title-desc">Complete the form below to submit apply for this contract.</p>

            <form action="<?= route_to('submit-bid') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="row after-add-more mb-2" style="border-bottom: 1px darkred solid">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" name="title[]" placeholder="Title"  class="form-control">
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'title.*') : '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Document</label>
                            <input type="file" name="document[]" placeholder="Document" multiple  class="form-control-file">
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'document') : '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea name="comment[]" style="resize: none;" placeholder="Comment" class="form-control"></textarea>
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'comment.*') : '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="add-more btn-primary btn-sm">Add more</button>
                </div>

                <input type="hidden" name="contract" value="<?= $contract['contract_id'] ?>">
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div class="row copy hide" style="border-bottom: 1px darkred solid">
                <div class="control-group">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" name="title[]" placeholder="Title"  class="form-control">
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'title.*') : '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Document</label>
                            <input type="file" name="document[]" placeholder="Document" multiple  class="form-control-file">
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'document') : '' ?></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Comment</label>
                            <textarea name="comment[]" style="resize: none;" placeholder="Comment" class="form-control"></textarea>
                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'comment.*') : '' ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn-sm btn-danger remove float-right" type="button"><i class=""></i> Remove</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>
<?= $this->section('extra-scripts'); ?>
<script>
    $(document).ready(function(){
        $('.hide').hide();
        $(".add-more").click(function(){
            var html = $(".copy").html();
            $(".after-add-more").after(html);
        });


        $("body").on("click",".remove",function(){
            $(this).parents(".control-group").remove();
        });
    });
</script>
<?= $this->endSection() ?>
