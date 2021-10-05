<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Contractor Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="iGov" name="description" />
    <meta content="Connexxion Telecom" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="/nassets/images/favicon.ico">
    <!-- Bootstrap Css -->
    <link href="/nassets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/nassets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/nassets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="bg-primary bg-pattern">

<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5">
                    <a href="index.html" class="logo"><img src="assets/images/logo-light.png" height="24" alt="logo"></a>
                    <h5 class="font-size-16 text-white-50 mb-4">Responsive Bootstrap 4 Admin Dashboard</h5>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-xl-5 col-sm-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-2">
                            <h5 class="mb-5 text-center">Contractor Login Screen</h5>
                            <?php if(session()->has('error')): ?>
                                <div class="alert alert-warning alert-dismissible fade show mb-2" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?= session()->get('error') ?>
                                </div>
                            <?php endif; ?>
                            <form class="form-horizontal mt-4" action="<?= route_to('contractor-login') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-group-custom mb-4">

                                            <input value="<?= set_value('email') ?>" type="text" placeholder="Email address" class="form-control" id="username" name="email">
                                            <label for="username">Email Address</label>
                                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'email') : '' ?></span>
                                        </div>

                                        <div class="form-group form-group-custom mb-4">
                                            <label for="">Password</label>
                                            <input type="password" name="password" class="form-control" id="userpassword">
                                            <label for="userpassword">Password</label>
                                            <span class="text-danger"><?= isset($validation) ? display_errors($validation, 'password') : '' ?></span>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                                    <label class="custom-control-label" for="customControlInline">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="text-md-right mt-3 mt-md-0">
                                                    <a href="#" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<!-- end Account pages -->

<!-- JAVASCRIPT -->
<script src="/nassets/libs/jquery/jquery.min.js"></script>
<script src="/nassets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/nassets/libs/metismenu/metisMenu.min.js"></script>
<script src="/nassets/libs/simplebar/simplebar.min.js"></script>
<script src="/nassets/libs/node-waves/waves.min.js"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<script src="/nassets/js/app.js"></script>

</body>
</html>
