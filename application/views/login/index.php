<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Reservasi Ruang Seduh Coffee</title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('/assets/img/brand/favicon.png'); ?>" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url('/assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/argon.css') ?>?v=1.2.0" type="text/css">
    <link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-select/bootstrap-select.min.css') ?>">
</head>

<body class="bg-primary">
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header py-7 py-lg-4 pt-lg-3">
        </div>
        <!-- Page content -->
        <div class="container mt--20 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-white border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <img src="./assets/img/logo.jpg">
                            </div>
                            <form id="loginForm">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Username" name="username" type="text" data-bv-notempty="true" data-bv-notempty-message="Username tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Password" name="password" type="password" data-bv-notempty="true" data-bv-notempty-message="Password tidak boleh kosong">
                                    </div>
                                </div>
                            </form>
                            <div class="text-center">
                                <button id="submitBtn" type="submit" class="btn btn-primary my-4 col-md-12">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?= base_url('/assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/js-cookie/js.cookie.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
    <!-- Argon JS -->
    <script src="<?= base_url('/assets/js/argon.js') ?>?v=1.2.0"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/id_ID.js'); ?>"></script>
    <script src="<?= base_url('/assets/js/formProses.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>

    <script>
        formProses = new formProses('<?php echo base_url('login/manajemen') ?>', 'Admin');
        myForm = $('#loginForm');

        $(document).ready(function() {
            myForm.bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'fa fa-exclamation-circle',
                    validating: 'fa fa-spin fa-refresh'
                },
                excluded: ':disabled'
            })
        })

        myForm.submit((evt) => {
            evt.preventDefault();
        })

        $('#submitBtn').on('click', (e) => {
            myForm.data('bootstrapValidator').validate();

            let hasErr = myForm.find(".has-error").length;

            if (hasErr == 0) {
                let data = myForm.serializeArray();

                const res = formProses.getData("<?php echo base_url() ?>" + "login/cekLogin", {
                    data: data
                });

                if (res[0]) {
                    swal({
                        title: 'Berhasil!',
                        text: 'Anda berhasil login',
                        buttons: false,
                        timer: 1500
                    })

                    setTimeout(function() {
                        window.location = "admin/"
                    }, 1000);
                } else {
                    swal({
                        title: 'Gagal!',
                        text: 'Username atau password salah',
                        buttons: false,
                        timer: 1500
                    })
                }
            }
        })
    </script>
</body>

</html>