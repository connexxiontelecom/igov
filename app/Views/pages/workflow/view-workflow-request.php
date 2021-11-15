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
                        <li class="breadcrumb-item"><a href="<?= site_url('/workflow-requests')?>">Workflow Requests</a></li>
                        <li class="breadcrumb-item active">Workflow Request Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Workflow Request Details</h4>
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
                            <h4 class="header-title mt-2 mb-4">Workflow Request Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php if(session()->has('error')): ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?= session()->get('error') ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if(session()->has('success')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <?= session()->get('success') ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="btn-group">
                            <a href="<?=site_url('/workflow-requests')?>" type="button" class="btn btn-sm btn-primary float-right">Go Back</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <?= $workflow_request->request_title ?? '' ?>
                    </h3>
                    <?php if($workflow_request->request_status == 0): ?>
                        <div class="badge badge-warning text-white mb-3">Pending</div>
                    <?php elseif ($workflow_request->request_status == 1) : ?>
                        <div class="badge badge-success mb-3">Approved</div>
                    <?php elseif ($workflow_request->request_status == 2): ?>
                        <div class="badge badge-danger mb-3">Declined</div>
                    <?php endif; ?>
                    <h5>Overview:</h5>

                    <?= $workflow_request->request_description ?? '' ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Date</h5>
                                <p><?= date('d M, Y', strtotime($workflow_request->created_at)) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Amount</h5>
                                <p><?= number_format($workflow_request->amount,2) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-4">
                                <h5>Workflow Request Type</h5>
                                <p><?= $workflow_request->workflow_type_name ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h5>Responsible Persons(s):</h5>
                        <?php foreach($responsible_persons as $person):  ?>
                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $person['employee_f_name']  ?> <?= $person['employee_l_name'] ?>" class="d-inline-block">
                                <img src="/assets/images/users/user-6.jpg" class="rounded-circle img-thumbnail avatar-sm" alt="friend">
                            </a>
                            <?php if($person['redirected_to_id'] == $auth_user && $person['request_status'] == 0): ?>
                                <button class="btn btn-sm btn-danger" data-target="#declineRequest" data-toggle="modal">Decline</button>
                                <button class="btn btn-sm btn-success" data-target="#approveRequest" data-toggle="modal">Approve</button>
                                <div id="approveRequest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Approve Request</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>This action cannot be undone. Are you sure you want to approve this request?</h6>
                                                <form action="<?= site_url('/workflow-requests/process-request') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="btn-group float-right mt-3">
                                                        <input type="hidden" name="request" value="<?= $workflow_request->workflow_request_id ?>">
                                                        <input type="hidden" name="workflow_responsible" value="<?= $person['workflow_responsible_people_id'] ?>">
                                                        <input type="hidden" name="action" value="1">
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Yes, please</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                                <div id="declineRequest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Decline Request</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>This action cannot be undone. Are you sure you want to decline this request?</h6>
                                                <form action="<?= site_url('/workflow-requests/process-request') ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <div class="btn-group float-right mt-3">
                                                        <input type="hidden" name="request" value="<?= $workflow_request->workflow_request_id ?>">
                                                        <input type="hidden" name="workflow_responsible" value="<?= $person['workflow_responsible_people_id'] ?>">
                                                        <input type="hidden" name="action" value="2">
                                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Yes, please</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 mb-3">Comments</h4>
                    <form action="<?= site_url('/workflow-requests/leave-comment') ?>" method="post">
                        <?= csrf_field() ?>
                        <textarea style="resize:none;" class="form-control form-control-light mb-2" placeholder="Leave comment..." id="comment-box" name="leave_comment" rows="3"></textarea>
                        <div class="text-right">
                            <div class="btn-group mb-2 ml-2">
                                <input type="hidden" name="workflow_comment" value="<?= $workflow_request->workflow_request_id ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </div>
                    </form>

                    <?php foreach($comments as $comment): ?>
                    <div class="mt-2">
                        <div class="media">
                            <img class="mr-2 avatar-sm rounded-circle" src="/assets/images/users/user-3.jpg"
                                 alt="Generic placeholder image">
                            <div class="media-body">
                                <h5 class="mt-0">
                                    <a href="contacts-profile.html" class="text-reset"><?= $comment['employee_f_name'] ?> <?= $comment['employee_l_name'] ?> </a> <small class="text-muted"><?= date('d M, Y h:ia', strtotime($comment['created_at'])) ?></small></h5>
                                <?= $comment['comment'] ?>
                                <br/>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Attachments</h5>
                    <?php foreach($workflow_attachments as $attachment): ?>
                    <div class="card mb-1 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title badge-soft-primary text-primary rounded">
                                            ZIP
                                        </span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <a href="/uploads/posts/<?= $attachment['attachment'] ?>" target="_blank" class="text-muted font-weight-bold"><?= strlen($attachment['attachment']) > 30 ? substr($attachment['attachment'],0,30).'...' : $attachment['attachment'] ?></a>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a href="/uploads/posts/<?= $attachment['attachment'] ?>" target="_blank" class="btn btn-link btn-lg text-muted">
                                        <i class="dripicons-download"></i>
                                    </a>
	
									<button onclick="embedImages('<?='/uploads/posts/'.$attachment['attachment']; ?>',  '<?='/uploads/signatures/'.$employee_signature; ?>')" class="btn btn-link btn-lg text-muted">
										Sign Document
									</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('extra-scripts'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script src="https://unpkg.com/pdf-lib@1.4.0"></script>
<script src="https://unpkg.com/downloadjs@1.4.7"></script>
<!--<script src="main.js"></script>-->
<script>
    const { PDFDocument, StandardFonts, rgb, degrees } = PDFLib


    async function embedImages(url, sign) {


        const jpgUrls = sign;
        const jpgImageBytess = await fetch(jpgUrls).then((res) => res.arrayBuffer())

        // Create a new PDFDocument
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())

        // Load a PDFDocument from the existing PDF bytes
        const pdfDoc = await PDFDocument.load(existingPdfBytes)

        const jpgImages = await pdfDoc.embedJpg(jpgImageBytess)
       

        const pages = pdfDoc.getPages()
        const firstPage = pages[0]

        const jpgDimss = jpgImages.scale(0.5)

                firstPage.drawImage(jpgImages, {
            x: firstPage.getWidth() - 150,
            y: firstPage.getHeight() /10 + 80,
            width: jpgDimss.width,
            height: jpgDimss.height,
        })

     

        //const pdfBytes = await pdfDoc.save()
		const pdfBytes = await pdfDoc.saveAsBase64({ dataUri: true })
        let fileName = /[^/]*$/.exec(url)[0];
		
        urltoFile(pdfBytes, fileName)
            .then(function(file){
                console.log(file);
                let formdata = new FormData();
                formdata.append("file",file);

                $.ajax({
                    url: '<?=site_url('/workflow-requests/upload-sign') ?>',
                    type: 'post',
                    data: formdata,
                    contentType: false,
                    processData: false,
                    
                    success: function(php_script_response){
                        console.log(php_script_response);
                
                
                    }
                });
            })

    
    }

   async function urltoFile(url, filename, mimeType){
        mimeType = mimeType || (url.match(/^data:([^;]+);/)||'')[1];
        return (fetch(url)
                .then(function(res){return res.arrayBuffer();})
                .then(function(buf){return new File([buf], filename, {type:mimeType});})
        );
    }

    async function post(pdfBytes, url){

    
        
        
	}




   //  async function embedImages(url, sign) {
   //
   // alert(url+'   '+sign);
   //  }




    async function modifyPdf(url) {
        //const url = 'https://pdf-lib.js.org/assets/with_update_sections.pdf'
        const existingPdfBytes = await fetch(url).then(res => res.arrayBuffer())

        // Load a PDFDocument from the existing PDF bytes
        const pdfDoc = await PDFDocument.load(existingPdfBytes)

        // Embed the Helvetica font
        const helveticaFont = await pdfDoc.embedFont(StandardFonts.Helvetica)

        // Get the first page of the document
        const pages = pdfDoc.getPages()
        const firstPage = pages[0]

        // Get the width and height of the first page
        const { width, height } = firstPage.getSize()

        // Draw a string of text diagonally across the first page
        firstPage.drawText('This text was added with JavaScript!', {
            x: 5,
            y: height / 2 + 300,
            size: 50,
            font: helveticaFont,
            color: rgb(0.95, 0.1, 0.1),
            rotate: degrees(-45),
        })

        // Serialize the PDFDocument to bytes (a Uint8Array)
        const pdfBytes = await pdfDoc.save()

        // Trigger the browser to download the PDF document
        download(pdfBytes, url, "application/pdf");
    }


    $(document).ready(function(){
        var quill = new Quill ();
        $("#training-form").on("submit",function(){
            $("#hiddenArea").val($("#snow-editor").html());
        })
    });
</script>
<?= $this->endSection(); ?>




