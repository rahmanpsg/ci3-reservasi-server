<?php $this->load->view('admin/header') ?>
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-table/bootstrap-table.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-validator/bootstrapValidator.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-select/bootstrap-select.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/smartphoto/smartphoto.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('/assets/vendor/lobibox/css/lobibox.min.css') ?>">
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
                            <li class="breadcrumb-item active" aria-current="page">Data Order</li>
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
                            <h3 class="mb-0">Form Data Order</h3>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="toolbar">
                        <div class="form-group form-inline">
                            <select id="select" class="form-control form-control-sm" name="filterSelect">
                                <option value="semua" selected>Semua</option>
                                <option value="Sukses">Sukses</option>
                                <option value="Belum diupload">Belum diupload</option>
                                <option value="Sudah diupload">Menunggu Konfirmasi</option>
                                <option value="Expired">Expired</option>
                                <option value="Batal">Batal</option>
                            </select>
                            &nbsp;
                            <button class="btn btn-sm btn-primary" id="filterBy">Filter Data</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="table" data-toolbar=".toolbar" data-url='<?= $TBL_URL ?>' data-toggle="table" data-pagination="true" data-search="true" data-pagination="true" data-page-size="5" data-page-list="[5, 10, 25, 50, 100, ALL]" data-show-footer="true" data-footer-style="footerStyle" data-unique-id="id">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th data-field="no" data-formatter="indexFormatter" class="font-14 text-center">#</th>
                                    <th data-field="id" class="font-14 text-center">ID Pemesanan</th>
                                    <th data-field="tanggal" data-formatter="tanggalFormmater" data-sortable="true">Tanggal Reservasi</th>
                                    <th data-field="durasi" data-formatter="durasiFormatter">Durasi</th>
                                    <th data-field="daftarMeja" data-formatter="daftarMejaFormatter">Meja</th>
                                    <th data-field="nama" data-footer-formatter="customerFooterFormatter">Customer</th>
                                    <th data-field="status" data-formatter="statusFormatter" data-footer-formatter="statusFooterFormatter">Status</th>
                                    <th data-field="totalTransfer" data-formatter="rupiahFormatter" data-footer-formatter="totalHargaFooterFormatter" data-sortable="true">Total Transfer</th>
                                    <th data-field="totalHarga" data-formatter="rupiahFormatter" data-footer-formatter="totalHargaFooterFormatter" data-sortable="true">Total Bayar</th>
                                    <th data-formatter="aksiFormatter" data-events="window.aksiEvents"></th>
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
    <script src="<?= base_url('/assets/vendor/lobibox/js/lobibox.js') ?>"></script>

    <script>
        formProses = new formProses();
        myTabel = $('#table');

        $(document).ready(() => {
            myTabel.on('post-body.bs.table', function() {
                const sm = new SmartPhoto(".js-img-viewer", {
                    showAnimation: false
                });
            })

            // run_server_notification();

        })

        //Overriding default options        
        Lobibox.notify.DEFAULTS = $.extend({}, Lobibox.notify.DEFAULTS, {
            iconSource: 'fontAwesome',
            soundPath: '<?= base_url('assets/sounds/') ?>'
        });
        Lobibox.notify.OPTIONS = $.extend({}, Lobibox.notify.OPTIONS, {
            'class': 'animated-fast',
            mini: {
                'class': 'notify-mini',
                messageHeight: 32
            },
            success: {
                'title': 'Success',
                'class': 'bg-primary text-white',
                'icon': 'ni ni-check-bold',
                sound: 'sound1'
            }
        });

        function run_server_notification() {
            console.log("Memanggil server untuk mengambil notifikasi");

            if (!!window.EventSource) {

                let source = new EventSource('<?= base_url('api/getNotifikasi') ?>');

                source.addEventListener('update', function(e) {
                    const data = JSON.parse(e.data);

                    console.log(data);

                    const last = moment(data.last_update).add(30, 'seconds');

                    if (moment(new Date()).isBefore(last)) {
                        const pesan = data.status == 'Belum diupload' ? 'Anda memiliki reservasi baru!' : `Bukti pembayaran untuk ID Pesanan ${data.id} telah diupload oleh customer!`;

                        Lobibox.notify('success', {
                            size: 'mini',
                            msg: pesan,
                            sound: false
                        });

                        setTimeout(() => {
                            // myTabel.bootstrapTable('refresh');
                            if (data.status == 'Belum diupload') {
                                myTabel.bootstrapTable('insertRow', {
                                    index: 0,
                                    row: data
                                })
                            } else {
                                myTabel.bootstrapTable('updateByUniqueId', {
                                    id: data.id,
                                    row: data
                                })
                            }
                        }, 100);
                    }
                });
            }
        }

        $('#filterBy').click(function() {
            const status = $('[name="filterSelect"]').val();

            let filterBy = {};

            if (status !== 'semua') {
                filterBy = {
                    status
                }
            }

            myTabel.bootstrapTable('filterBy', filterBy)
        })
    </script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function tanggalFormmater(val, row) {
            return moment(new Date(`${val} ${row.jam}`)).format('DD/MM/YYYY HH:mm')
        }

        function durasiFormatter(val) {
            return `${val} Jam`
        }

        function daftarMejaFormatter(val, row) {
            return JSON.parse(val).join(', ')
        }

        function tglFormatter(val) {
            moment.locale('id');
            return moment(val).format('DD MMMM YYYY');
        }

        function statusFormatter(val) {
            const badge = (val, color) => {
                return `<span class="badge badge-dot mr-4">
                        <i class="bg-${color}"></i>
                        <span>${val}</span>
                      </span>`
            }

            switch (val) {
                case 'Belum diupload':
                    return badge(val, 'warning')
                    break;
                case 'Menunggu konfirmasi':
                    return badge(val, 'info')
                    break;
                case 'Sukses':
                    return badge(val, 'success')
                    break;
                default:
                    return badge(val, 'danger')
                    break;
            }
        }

        function rupiahFormatter(val) {
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

        function customerFooterFormatter(val) {
            return 'Total'
        }

        function statusFooterFormatter(val) {
            return val.length
        }

        function totalHargaFooterFormatter(data) {
            const field = this.field

            const total = data.map(function(row) {
                return +row[field]
            }).reduce(function(sum, i) {
                return sum + i
            }, 0)

            return rupiahFormatter(total.toString())
        }

        function footerStyle(column) {
            return {
                nama: {
                    css: {
                        'font-weight': 'bold'
                    }
                },
                status: {
                    css: {
                        'font-weight': 'bold'
                    }
                },
                totalTransfer: {
                    css: {
                        'font-weight': 'bold'
                    }
                },
                totalHarga: {
                    classes: 'text-primary',
                    css: {
                        'font-weight': 'bold'
                    }
                }
            } [column.field]
        }

        function aksiFormatter(val, row) {
            let aksi = `<div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">`

            switch (row.status) {
                case 'Belum diupload':
                    aksi += `<a class="dropdown-item">Belum ada aksi</a>`
                    break;
                case 'Menunggu konfirmasi':
                    const photoUrl = `<?= base_url('file/buktiPembayaran/') ?>/${row.id}/${row.file}`;

                    aksi += `<a class="dropdown-item text-success js-img-viewer" href="${photoUrl}" data-caption="${row.id} | ${row.nama}" data-id="${row.id}" data-group="${row.id}"><i class="fa fa-eye"></i> Lihat Bukti Transfer</a>
                          <a class="dropdown-item text-info" href="#" id="konfirmasi"><i class="ni ni-check-bold"></i> Konfirmasi</a>
                          <a class="dropdown-item text-primary" href="#" id="tolak"><i class="ni ni-fat-remove"></i> Tolak</a>`
                    break;
                case 'Sukses':
                    aksi += `<a class="dropdown-item">Selesai</a>`
                    break;
                default:
                    aksi += `<a class="dropdown-item">Tidak ada aksi</a>`
                    break;
            }

            aksi += `</div></div>`

            return aksi
        }

        window.aksiEvents = {
            'click #konfirmasi': function(e, value, row, index) {
                setAksi('konfirmasi', row.id, row.uid)
            },
            'click #tolak': function(e, value, row, index) {
                setAksi('tolak', row.id, row.uid)
            }
        }

        function setAksi(status, id, uid) {
            const newStatus = (status == 'konfirmasi' ? 'Sukses' : 'Ditolak');

            swal({
                    text: `Pembayaran akan di${status}?`,
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Batal",
                            value: null,
                            visible: true
                        },
                        confirm: {
                            text: "OK",
                            closeModal: false
                        }
                    }
                })
                .then(simpan => {
                    if (simpan !== null) {
                        const send = {
                            id,
                            uid,
                            status: newStatus
                        }

                        formProses.post('<?= base_url('api/konfirmasiPesanan') ?>', send)
                            .then(res => {
                                if (res == undefined) {
                                    return;
                                }
                                if (res) {
                                    swal(`Data berhasil di${status}`, {
                                        icon: "success",
                                        buttons: false,
                                        timer: 1000,
                                    });

                                    $('#table').bootstrapTable('updateByUniqueId', {
                                        id,
                                        row: {
                                            status: newStatus
                                        }
                                    });
                                } else {
                                    swal(`Data gagal di${status}`, {
                                        icon: "error",
                                        buttons: false,
                                        timer: 1000,
                                    });
                                }
                            }).catch(err => {
                                console.log(err);
                                if (err) {
                                    swal("Terjadi masalah di server", "The AJAX request failed!", "error");
                                } else {
                                    swal.stopLoading();
                                    swal.close();
                                }
                            });
                    }
                })
        }
    </script>