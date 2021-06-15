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
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Meja</li>
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
                            <h3 class="mb-0">Pengaturan Meja</h3>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <button class="btn btn-sm btn-primary" onclick="tambahMeja()"><i class="fa fa-plus"></i> Meja</button>
                    <button class="btn btn-sm btn-success" onclick="tambahKursi()"><i class="fa fa-plus"></i> Kursi</button>
                    <button class="btn btn-sm btn-primary" onclick="hargaMeja()"><i class="fa fa-funnel-dollar"></i> Pengaturan Harga Meja</button>
                    <button class="btn btn-sm btn-danger" id="btnHapus" disabled onclick="hapusObject()"><i class="fa fa-trash"></i> Hapus</button>
                    <button class="btn btn-sm btn-info" onclick="simpanObject()"><i class="fa fa-save"></i> Simpan</button>
                </div>
                <div class="mt-4"></div>
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
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Pengaturan Daftar Harga</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="table" data-url='<?= $TBL_URL ?>' data-toggle="table" data-unique-id="nomor">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th data-field="nomor">Nomor Meja</th>
                                <th data-field="harga" data-formatter="rupiahFormatter">Harga Per Jam</th>
                                <th data-formatter="aksiFormatter" data-events="window.aksiEvents" class="text-right">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Footer -->
<?php $this->load->view('admin/footer') ?>
<script src="<?= base_url('/assets/js/fabric.js') ?>"></script>
<script src="<?= base_url('/assets/js/formProses.js'); ?>"></script>
<script src="<?= base_url('/assets/vendor/sweetalert/sweetalert.min.js') ?>"></script>

<script>
    formProses = new formProses();
    let canvas, canvas2, number;

    const grid = 20
    const backgroundColor = '#f8f8f8'
    const lineStroke = '#ebebeb'
    const tableFill = 'rgba(255, 107, 34)';
    const tableFillReserv = '#4cd964';
    const tableStroke = '#694d23'
    const tableSelected = '#38A62E'
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


    function initCanvas(canvas) {

        number = 1
        canvas.backgroundColor = backgroundColor

        canvas.on('object:moving', function(e) {
            snapToGrid(e.target)
        })

        canvas.on('object:scaling', function(e) {
            if (e.target.scaleX > 5) {
                e.target.scaleX = 5
            }
            if (e.target.scaleY > 5) {
                e.target.scaleY = 5
            }
            if (!e.target.strokeWidthUnscaled && e.target.strokeWidth) {
                e.target.strokeWidthUnscaled = e.target.strokeWidth
            }
            if (e.target.strokeWidthUnscaled) {
                e.target.strokeWidth = e.target.strokeWidthUnscaled / e.target.scaleX
                if (e.target.strokeWidth === e.target.strokeWidthUnscaled) {
                    e.target.strokeWidth = e.target.strokeWidthUnscaled / e.target.scaleY
                }
            }
        })

        canvas.on('object:modified', function(e) {
            e.target.scaleX = e.target.scaleX >= 0.25 ? (Math.round(e.target.scaleX * 2) / 2) : 0.5
            e.target.scaleY = e.target.scaleY >= 0.25 ? (Math.round(e.target.scaleY * 2) / 2) : 0.5
            snapToGrid(e.target)
            if (e.target.type === 'table') {
                canvas.bringToFront(e.target)
            } else {
                canvas.sendToBack(e.target)
            }
            sendLinesToBack(canvas)
        })

        canvas.observe('object:moving', function(e) {
            checkBoudningBox(canvas, e)
        })
        canvas.observe('object:rotating', function(e) {
            checkBoudningBox(canvas, e)
        })
        canvas.observe('object:scaling', function(e) {
            checkBoudningBox(canvas, e)
        })

        canvas.observe('object:selected', function(e) {
            $('#btnHapus').attr('disabled', false);
        })
    }

    function addRect(canvas, nomor, harga, left, top, width, height, angle = 0) {
        const id = generateId()
        const o = new fabric.Rect({
            width: width,
            height: height,
            fill: tableFill,
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
            harga
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
            selectable: true,
            type: 'chair',
            id: generateId()
        })
        canvas.add(o)
        return o
    }

    function snapToGrid(target) {
        target.set({
            left: Math.round(target.left / (grid / 2)) * grid / 2,
            top: Math.round(target.top / (grid / 2)) * grid / 2
        })
    }

    function checkBoudningBox(canvas, e) {
        const obj = e.target

        if (!obj) {
            return
        }
        obj.setCoords()

        const objBoundingBox = obj.getBoundingRect()
        if (objBoundingBox.top < 0) {
            obj.set('top', 0)
            obj.setCoords()
        }
        if (objBoundingBox.left > canvas.width - objBoundingBox.width) {
            obj.set('left', canvas.width - objBoundingBox.width)
            obj.setCoords()
        }
        if (objBoundingBox.top > canvas.height - objBoundingBox.height) {
            obj.set('top', canvas.height - objBoundingBox.height)
            obj.setCoords()
        }
        if (objBoundingBox.left < 0) {
            obj.set('left', 0)
            obj.setCoords()
        }
    }

    function sendLinesToBack(canvas) {
        canvas.getObjects().map(o => {
            if (o.type === 'line') {
                canvas.sendToBack(o)
            }
        })
    }

    async function loadObjects() {

        const data = await formProses.getData('<?= base_url('api/loadObjects') ?>')

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

            const o = addRect(lantai == 1 ? lantai1 : lantai2, nomor, harga, left,
                top,
                width,
                height, angle)
        }

    }

    function generateId() {
        return Math.random().toString(36).substr(2, 8)
    }

    function tambahKursi() {
        let canvas = $('#nav-tab a.active')[0]['id'] == 'nav-lantai1-tab' ? lantai1 : lantai2;

        const o = addChair(canvas, 0, 0, 15, 15)
        canvas.setActiveObject(o)
    }

    function tambahMeja() {
        let canvas = $('#nav-tab a.active')[0]['id'] == 'nav-lantai1-tab' ? lantai1 : lantai2;

        swal({
                text: "Masukkan Nomor Meja?",
                buttons: ["Batal", "Oke"],
                content: {
                    element: "input",
                    attributes: {
                        type: "number"
                    },
                }
            })
            .then((nomor) => {
                if (nomor) {
                    const o = addRect(canvas, nomor, '0', 0, 0, 60, 40)
                    canvas.setActiveObject(o)
                }
            });
    }

    function hapusObject() {
        let canvas = $('#nav-tab a.active')[0]['id'] == 'nav-lantai1-tab' ? lantai1 : lantai2;

        const o = canvas.getActiveObject()
        if (o) {
            o.remove()
            canvas.remove(o)
            canvas.discardActiveObject()
            canvas.renderAll()

            number--;

            $('#btnHapus').attr('disabled', true);
        }
    }

    function hargaMeja() {
        $('#table').bootstrapTable('refresh')
        $('#myModal').modal('toggle')

    }

    function simpanObject() {

        let meja = [],
            kursi = [];

        const daftarCanvas = [lantai1, lantai2];

        lantai1.renderAll()
        lantai2.renderAll()

        daftarCanvas.map((canvas, lantai) => {
            canvas.getObjects().map(o => {
                if (o.type === 'chair') {

                    // const {
                    //     left,
                    //     top,
                    // width,
                    // height
                    // } = o;

                    const left = o.getLeft(),
                        top = o.getTop(),
                        width = o.getWidth(),
                        height = o.getHeight(),
                        angle = o.getAngle()

                    const attribut = JSON.stringify({
                        left,
                        top,
                        width,
                        height,
                        angle
                    })

                    kursi.push({
                        lantai: lantai + 1,
                        attribut
                    })

                } else if (o.type === 'table') {

                    const {
                        number,
                        //     left,
                        //     top,
                        //     width,
                        //     height
                    } = o;

                    const
                        left = o.getLeft(),
                        top = o.getTop(),
                        width = o.getWidth(),
                        height = o.getHeight(),
                        angle = o.getAngle()

                    const attribut = JSON.stringify({
                        left,
                        top,
                        width,
                        height,
                        angle
                    })

                    meja.push({
                        nomor: number,
                        lantai: lantai + 1,
                        attribut
                    })

                }
            })
        })

        swal({
                title: "Data akan disimpan?",
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
                },
            })
            .then(simpan => {
                if (simpan !== null) {
                    formProses.post('<?= base_url('api/simpanObjects') ?>', {
                        meja,
                        kursi
                    }).then(res => {
                        console.log(res);
                        if (res === false) {
                            return swal("Data gagal disimpan", {
                                icon: "error",
                                buttons: false,
                                timer: 1000,
                            });
                        }
                        if (res === true) {
                            swal("Data berhasil disimpan", {
                                icon: "success",
                                buttons: false,
                                timer: 1000
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

<script>
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

    function aksiFormatter(val, row) {
        return ["<button data-toggle='tooltip' title='Ubah' class='ubah btn btn-info btn-sm'>",
            "<i class='fa fa-edit'></i>",
            "</button>"
        ].join(' ');
    }

    window.aksiEvents = {
        'click .ubah': function(e, value, row, index) {
            const nomor = row.nomor

            swal({
                button: {
                    text: "Simpan",
                    closeModal: false,
                },
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Masukkan harga",
                        type: "number",
                        name: 'inputHarga'
                    },
                },
            }).then(input => {
                if (input !== null) {
                    const harga = $('input[name=inputHarga]').val()

                    const send = {
                        table: 'tbl_meja',
                        data: {
                            harga
                        },
                        where: {
                            nomor
                        }
                    }

                    formProses.post('<?= base_url('api/updateData') ?>', send)
                        .then(res => {
                            if (res === false) {
                                return swal("Data gagal disimpan", {
                                    icon: "error",
                                    buttons: false,
                                    timer: 1000,
                                });
                            }
                            swal.stopLoading();
                            swal.close();

                            const harga = $('input[name=inputHarga]').val()

                            $('#table').bootstrapTable('updateByUniqueId', {
                                id: nomor,
                                row: {
                                    harga
                                }
                            });
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

            $('input[name=inputHarga]').val(row.harga).focus()

        }
    }
</script>