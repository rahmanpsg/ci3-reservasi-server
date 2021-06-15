<?php $this->load->view('admin/header') ?>
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-table/bootstrap-table.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-select/bootstrap-select.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/smartphoto/smartphoto.min.css') ?>">
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Customer</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Form Data Customer</h3>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="table" data-url='<?= $TBL_URL ?>' data-toggle="table" data-pagination="true" data-search="true" data-unique-id="uid">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                    <th data-field="foto" data-formatter="fotoFormatter">FOTO</th>
                                    <th data-field="nama">Nama</th>
                                    <th data-field="email">Email</th>
                                    <th data-field="telp">Nomor Telpon</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php $this->load->view('admin/footer') ?>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-validator/id_ID.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/bootstrap-select/bootstrap-select.min.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/moment/min/moment-with-locales.min.js'); ?>"></script>
    <script src="<?= base_url('/assets/js/formProses.js'); ?>"></script>
    <script src="<?= base_url('/assets/vendor/smartphoto/smartphoto.js?v=1') ?>"></script>
    <script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>


    <script>
        formProses = new formProses();
        myTabel = $('#table');
        $(document).ready(() => {
            myTabel.on('post-body.bs.table', function() {
                const sm = new SmartPhoto(".js-img-viewer", {
                    showAnimation: false
                });
            })
        })
    </script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function fotoFormatter(val, row) {
            let foto = `<div class="avatar-sm">
                <a href="#" 
                    class="avatar avatar-sm rounded-circle" 
                    data-toggle="tooltip">
                <img src="../assets/img/images-not-found.png">
                </a>
                </div>`

            if (val !== null) {
                const res = formProses.isUrlFound(val);
                if (res) {
                    foto = `<div class="avatar-sm">
                        <a href="${val}" 
                            class="avatar avatar-sm rounded-circle js-img-viewer" 
                            data-toggle="tooltip"
                            data-caption="${row.nama}" data-id="${row.nama}">
                        <img src="${val}">
                        </a>
                        </div>`
                }
            }

            return foto;
        }

        function tglFormatter(val) {
            moment.locale('id');
            return moment(val).format('DD MMMM YYYY');
        }
    </script>