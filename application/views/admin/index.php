<?php $this->load->view('admin/header') ?>
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Meja</h5>
                                    <span class="h2 font-weight-bold mb-0"><?= $totalMeja; ?></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-yellow text-white rounded-circle shadow">
                                        <i class="ni ni-collection"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Reservasi</h5>
                                    <span class="h2 font-weight-bold mb-0"><?= $totalReservasi; ?></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                        <i class="ni ni-book-bookmark"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Total Customer</h5>
                                    <span class="h2 font-weight-bold mb-0"><?= $totalCustomer; ?></span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                        <i class="ni ni-single-02"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <h1>SELAMAT DATANG DI SISTEM RESERVASI RUANG SEDUH COFFEE</h1>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-1">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Daftar Meja</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>
                        KETERANGAN :
                        <div class="badge badge-warning">Tersedia</div>
                        <div class="badge badge-success">Sudah dipesan</div>
                    </p>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-lantai1-tab" data-toggle="tab" href="#nav-lantai1" role="tab" aria-controls="nav-lantai1" aria-selected="true">Lantai 1</a>
                            <a class="nav-item nav-link" id="nav-lantai2-tab" data-toggle="tab" href="#nav-lantai2" role="tab" aria-controls="nav-lantai2" aria-selected="false">Lantai 2</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-lantai1" role="tabpanel" aria-labelledby="nav-lantai1-tab">
                            <center>
                                <canvas id="canvas" width="auto" height="812"></canvas>
                            </center>
                        </div>
                        <div class="tab-pane fade" id="nav-lantai2" role="tabpanel" aria-labelledby="nav-lantai2-tab">
                            <center>
                                <canvas id="canvas2" width="auto" height="812"></canvas>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-1">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Detail Meja</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="isi">
                        <h4>Silahkan klik pada salah satu meja untuk melihat data</h4>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-1">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Data Reservasi Meja</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" id="table" data-toggle="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                        <th data-field="nama">Customer</th>
                                        <th data-field="jam">Jam Reservasi</th>
                                        <th data-field="durasi" data-formatter="durasiFormatter">Durasi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php $this->load->view('admin/footer') ?>
        <script src="<?= base_url('/assets/js/fabric.js') ?>"></script>
        <script src="<?= base_url('/assets/js/formProses.js'); ?>"></script>
        <script src="<?= base_url('/assets/vendor/moment/min/moment.min.js') ?>"></script>

        <script>
            formProses = new formProses();
            let canvas, canvas2, number;

            const grid = 20
            const backgroundColor = '#f8f8f8'
            const lineStroke = '#ebebeb'
            const tableFill = 'rgba(255, 107, 34)';
            const tableFillReserv = '#4cd964';
            const tableStroke = '#694d23'
            const tableSelected = '#f7f54d'
            const tableShadow = 'rgba(0, 0, 0, 0.4) 3px 3px 7px'
            const chairFill = 'rgba(208, 99, 59, 1)'
            const chairStroke = '#32230b'
            const chairShadow = 'rgba(0, 0, 0, 0.4) 3px 3px 7px'

            let lantai1 = new fabric.Canvas('canvas')
            let lantai2 = new fabric.Canvas('canvas2')

            $(document).ready(() => {
                initCanvas(lantai1)
                initCanvas(lantai2)

                loadObjects();


            })

            function indexFormatter(val, row, index) {
                return index + 1;
            }

            function durasiFormatter(val) {
                const hours = Math.floor(val / 60);
                const minutes = val % 60;
                return `${hours} jam ${minutes > 0 ? minutes + ` menit` : ''}`
            }

            const rupiahFormatter = (val) => {
                let number_string = val != null ? val.replace(/[^,\d]/g, '').toString() : '',
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                // tambahkan titik jika yang di input sudah menjadi angka ribuan
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp ' + (rupiah ? rupiah : '');
            }

            const detailMeja = (nomor, harga, status) => {
                return `<div class="table-responsive table-upgrade">
                            <table class="table">
                                <tr>
                                    <td><b>NOMOR MEJA</b></td>
                                    <td>${nomor}</td>
                                </tr>
                                <tr>
                                    <td><b>HARGA PER JAM</b></td>
                                    <td>${rupiahFormatter(harga)}</td>
                                </tr>
                                <tr>
                                    <td><b>STATUS</b></td>
                                    <td>${status ? 'SUDAH DIRESERVASI' : 'KOSONG'}</td>
                                </tr>
                            </table>
                        </div>`
            }


            function initCanvas(canvas) {
                canvas.backgroundColor = backgroundColor
                canvas.observe('object:selected', function(e) {
                    const {
                        number,
                        harga,
                        reserved
                    } = e.target

                    $('#isi').html(detailMeja(number, harga, reserved))

                    $('#table').bootstrapTable('refreshOptions', {
                        url: '<?= base_url('api/getDataMejaReserved?nomor=') ?>' + number
                    })
                })
            }

            function addRect(canvas, reserved, nomor, harga, left, top, width, height, angle = 0) {
                const id = generateId()
                const o = new fabric.Rect({
                    width: width,
                    height: height,
                    fill: (!reserved ? tableFill : tableFillReserv),
                    stroke: tableStroke,
                    strokeWidth: 2,
                    shadow: tableShadow,
                    originX: 'center',
                    originY: 'center',
                    centeredRotation: true,
                    snapAngle: 45,
                    selectable: true,
                    hasRotatingPoint: true,
                })
                o.set('angle', angle);

                const t = new fabric.IText(nomor.toString(), {
                    fontFamily: 'Calibri',
                    fontSize: 14,
                    fill: '#fff',
                    textAlign: 'center',
                    originX: 'center',
                    originY: 'center'
                })
                const g = new fabric.Group([o, t], {
                    left: left,
                    top: top,
                    centeredRotation: true,
                    snapAngle: 45,
                    selectable: true,
                    type: 'table',
                    id: id,
                    number: nomor,
                    harga,
                    reserved,
                    hasControls: false,
                    lockMovementX: true,
                    lockMovementY: true,
                    borderColor: tableSelected,
                    borderScaleFactor: 2.5
                })
                canvas.add(g)
                number++
                return g
            }

            function addChair(canvas, left, top, width, height) {
                const o = new fabric.Rect({
                    left: left,
                    top: top,
                    width,
                    height,
                    fill: chairFill,
                    stroke: chairStroke,
                    strokeWidth: 2,
                    shadow: chairShadow,
                    originX: 'left',
                    originY: 'top',
                    centeredRotation: true,
                    snapAngle: 45,
                    selectable: false,
                    type: 'chair',
                    id: generateId()
                })
                canvas.add(o)
                return o
            }

            async function loadObjects() {
                const tanggal = moment(new Date()).format('YYYY-MM-DD')

                const data = await formProses.getData('<?= base_url('api/loadObjects') ?>', {
                    tanggal
                })

                for (let item of data.kursi) {
                    const lantai = item.lantai;
                    const {
                        left,
                        top,
                        width,
                        height
                    } = JSON.parse(item.attribut);

                    addChair(lantai == 1 ? lantai1 : lantai2, left, top, width, height)
                }

                //Periksa Meja Reserved
                let mejaReserved = [];
                for (let item of data.dataReserved) {
                    for (let m of item.meja) {
                        mejaReserved.push(m);
                    }
                }

                for (let item of data.meja) {
                    const {
                        lantai,
                        nomor,
                        harga
                    } = item;

                    const {
                        left,
                        top,
                        width,
                        height,
                        angle
                    } = JSON.parse(item.attribut);

                    const reserved = mejaReserved.includes(nomor);

                    const o = addRect(lantai == 1 ? lantai1 : lantai2, reserved, nomor, harga, left,
                        top,
                        width,
                        height, angle)
                }

                lantai1.selection = false
                lantai1.hoverCursor = 'pointer'
                lantai2.selection = false
                lantai2.hoverCursor = 'pointer'

            }

            function generateId() {
                return Math.random().toString(36).substr(2, 8)
            }
        </script>