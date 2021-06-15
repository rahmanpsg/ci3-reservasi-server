<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');

defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Model');
		$this->db->query("SET sql_mode = '' ");
	}

	public function index()
	{
		phpinfo();
	}

	public function registrasiUser()
	{
		foreach ($_POST as $key => $value) {
			$data[$key] = $value;
		}

		if (!empty($_FILES)) {
			$this->Model->uploadFile('./file/foto/');
			$target_dir = base_url('file/foto/');
			$data['foto'] = $target_dir . basename($_FILES['file']["name"]);
		}

		$cek = $this->Model->query("SELECT COUNT(uid) as total FROM tbl_customer WHERE uid = '$data[uid]'")[0]['total'];
		$where = array('uid' => $data['uid']);

		if ($cek > 0) {
			$query = $this->Model->setUpdate('tbl_customer', $data, $where);
		} else {
			$query = $this->Model->setTambah('tbl_customer', $data);
		}
		$res = $this->Model->ambilData('tbl_customer', 'nama, telp, foto', '', $where)[0];

		echo json_encode(array($query, $res));
	}

	public function getProfil()
	{
		$uid = $this->input->get('uid');

		$this->db->select('email, nama, telp, foto');
		$data = $this->db->get_where('tbl_customer', ['uid' => $uid])->result()[0];

		echo json_encode($data);
	}

	public function loadObjects()
	{
		$tanggal = $this->input->post('tanggal');
		$jam = $this->input->post('jam');
		$durasi = $this->input->post('durasi');

		$dataKursi = $this->Model->ambilData('tbl_kursi');

		$this->db->select('nomor, lantai, attribut');
		if ($durasi !== null) {
			$this->db->select("ROUND(harga * ($durasi/60)) as harga");
		} else {
			$this->db->select('harga');
		}
		$dataMeja = $this->db->get('tbl_meja')->result();

		$dataReserved = [];

		if ($tanggal !== NULL and $jam !== NULL and $durasi !== NULL) {
			//Periksa semua meja yg telah di reservasi berdasarkan tanggal, jam dan durasi
			$mejaReserved = $this->Model->query("SELECT daftarMeja, jam, durasi FROM tbl_order WHERE tanggal = '$tanggal' AND status = 'Sukses'");

			$explodeJam = explode(':', $jam);

			//nilai awal jam setelah dikonversi
			$startJam = $explodeJam[0] + (intval($explodeJam[1]) / 100);

			$endJam = $startJam + ($durasi / 60);

			for ($i = $startJam; $i < $endJam; $i += 0.01) {
				if ($i - floor($i) > 0.59) continue;
				$arrayJam[] = $i;
			}

			foreach ($mejaReserved as $value) {
				$explJamReserv = explode(':', $value['jam']);

				$startJamReserv = $explJamReserv[0] + (intval($explJamReserv[1]) / 100);

				$endJamReserv = $startJamReserv + ($value['durasi'] / 60);

				for ($i = $startJamReserv; $i < $endJamReserv; $i += 0.01) {
					if ($i - floor($i) > 0.59) continue;
					$arrayJamReserv[] = $i;
				}

				$cek = array_intersect($arrayJam, $arrayJamReserv);

				if (count($cek) > 0) {
					$dataReserved[] = array('meja' => json_decode($value['daftarMeja']));
				}
			}
		} else 
		if ($tanggal !== NULL) {
			$mejaReserved = $this->Model->query("SELECT daftarMeja, jam, durasi FROM tbl_order WHERE tanggal = '$tanggal' AND status = 'Sukses'");

			foreach ($mejaReserved as $val) {
				$dataReserved[] = array('meja' => json_decode($val['daftarMeja']));
			}
		}

		echo json_encode(array('meja' => $dataMeja, 'kursi' => $dataKursi, 'dataReserved' => $dataReserved));
	}

	public function getDataMejaReserved()
	{
		$nomor = $this->input->get('nomor');

		$this->db->select("b.nama, TIME_FORMAT(a.jam, '%H:%i') jam, a.durasi");
		$this->db->from('tbl_order a');
		$this->db->join('tbl_customer b', 'a.uid = b.uid', 'join');
		$this->db->where("JSON_SEARCH(a.daftarMeja, 'one', $nomor) IS NOT NULL");
		$this->db->where('a.status', 'Sukses');
		$this->db->where('a.tanggal', date('Y-m-d'));
		$data = $this->db->get()->result();

		echo json_encode($data);
	}

	public function simpanObjects()
	{
		$meja = $this->input->post('meja');
		$kursi = $this->input->post('kursi');

		//ambil daftar harga sebelumnya
		$harga = $this->Model->ambilData('tbl_meja', 'nomor, harga');

		$daftarHarga = [];
		foreach ($harga as $value) {
			$daftarHarga[$value['nomor']] = $value['harga'];
		}

		//hapus semua data
		$this->db->truncate('tbl_meja');
		$this->db->truncate('tbl_kursi');

		foreach ($meja as $value) {
			//cek jika harga meja telah ada sebelumnya
			$nomor = $value['nomor'];
			if (array_key_exists($nomor, $daftarHarga)) {
				$value['harga'] = $daftarHarga[$nomor];
			}

			$simpanMeja = $this->Model->setTambah('tbl_meja', $value);
		}

		foreach ($kursi as $value) {
			$simpanKursi = $this->Model->setTambah('tbl_kursi', $value);
		}

		echo json_encode($simpanMeja && $simpanKursi);
	}

	public function simpanPembayaran()
	{
		foreach ($_POST as $key => $value) {
			$data[$key] = $value;
		}

		$data['ditambahkan_pada'] = $this->Model->getWaktu();

		$simpan = $this->Model->setTambah('tbl_order', $data);

		echo json_encode($simpan);
	}

	public function getDataPembayaran()
	{
		$id = $this->input->get('id');

		$data = $this->Model->query("SELECT durasi, daftarMeja, totalHarga, DATE_ADD(ditambahkan_pada, INTERVAL 1 HOUR) as waktuBerakhir FROM tbl_order WHERE id = '$id'")[0];

		$durasi = $data['durasi'];

		$kode = explode('-', $id)[3];

		$data['totalTransfer'] = ($data['totalHarga'] * (50 / 100)) + $kode;

		$daftarMeja = implode(', ', json_decode($data['daftarMeja']));

		$dataMeja = $this->Model->query("SELECT nomor, ROUND(harga * ($durasi / 60)) as harga FROM tbl_meja WHERE nomor IN ($daftarMeja)");

		$dataBank = $this->Model->ambilData('tbl_bank', 'norek, nama')[0];

		echo json_encode(array('order' => $data, 'meja' => $dataMeja, 'bank' => $dataBank));
	}

	public function getDaftarPesanan()
	{
		$uid = $this->input->get('uid');

		if ($uid !== NULL) {
			$data = $this->Model->query("SELECT id, totalHarga, FLOOR(totalHarga * 50 / 100) + SUBSTRING(id, -3, 3) totalTransfer, tanggal, jam, durasi, daftarMeja, ditambahkan_pada, IF(DATE_ADD(ditambahkan_pada, INTERVAL 1 HOUR) > now(), IF(status IS NULL, 'Belum diupload', IF(status = 'Sudah diupload', 'Menunggu konfirmasi', status)), 'Expired') as status FROM tbl_order WHERE uid = '$uid' AND (IF(DATE_ADD(ditambahkan_pada, INTERVAL 1 HOUR) > now(), IF(status IS NULL, 'Belum diupload', IF(status = 'Sudah diupload', 'Menunggu konfirmasi', status)), 'Expired') NOT IN ('Expired','Sukses')) ORDER BY ditambahkan_pada DESC");
		} else {
			$data = $this->Model->query("SELECT a.id, a.tanggal, a.jam, a.durasi, a.daftarMeja, a.totalHarga, FLOOR(a.totalHarga * 50 / 100) + SUBSTRING(id, -3, 3) totalTransfer, a.file, b.uid, b.nama,  IF(DATE_ADD(a.ditambahkan_pada, INTERVAL 1 HOUR) > now(), IF(a.status IS NULL, 'Belum diupload', IF(a.status = 'Sudah diupload', 'Menunggu konfirmasi', a.status)), IF(a.status = 'Sukses', status, 'Expired')) as status FROM tbl_order a LEFT JOIN tbl_customer b ON a.uid = b.uid ORDER BY a.ditambahkan_pada DESC");
		}

		echo json_encode($data);
	}

	public function getTotalPesanan()
	{
		$uid = $this->input->get('uid');

		$data = $this->Model->query("SELECT COUNT(id) as total FROM tbl_order WHERE (status IS NULL OR status = 'Sudah diupload') AND DATE_ADD(ditambahkan_pada, INTERVAL 1 HOUR) > now() AND uid = '$uid'")[0]['total'];

		echo json_encode($data);
	}

	public function uploadBuktiPembayaran()
	{
		$id = $this->input->post('id');

		$data['status'] = 'Sudah diupload';

		$data['file'] = basename($_FILES['file']["name"]);
		//Proses Upload
		$target_dir = "./file/buktiPembayaran/" . $id . "/";
		$upload = $this->Model->uploadFile($target_dir);

		if ($upload == 1) {
			$data['ditambahkan_pada'] = $this->Model->getWaktu();
			$update = $this->Model->setUpdate('tbl_order', $data, array('id' => $id));

			if ($update) {
				echo json_encode(array($update, $data));
			}
		}
	}

	public function getDaftarTransaksi()
	{
		$uid = $this->input->get('uid');

		$data = $this->Model->query("SELECT id, totalHarga, FLOOR(totalHarga * 50 / 100) + SUBSTRING(id, -3, 3) totalTransfer, tanggal, jam, durasi, daftarMeja, status, ditambahkan_pada FROM tbl_order WHERE status = 'Sukses' AND uid = '$uid' ORDER BY ditambahkan_pada DESC");

		echo json_encode($data);
	}

	public function getDaftarCustomer()
	{
		$data = $this->Model->ambilData('tbl_customer');

		echo json_encode($data);
	}

	public function getDaftarHargaMeja()
	{
		$data = $this->Model->ambilData('tbl_meja', 'nomor, harga');

		echo json_encode($data);
	}

	public function updateData()
	{
		$table = $this->input->post('table');
		$data = $this->input->post('data');
		$where = $this->input->post('where');

		$update = $this->Model->setUpdate($table, $data, $where);

		echo json_encode($update);
	}

	public function cancelPesanan()
	{
		$id = $this->input->post('id');

		$this->db->set('status', 'Batal');
		$this->db->where('id', $id);
		$update = $this->db->update('tbl_order');

		echo json_encode($update);
	}

	public function konfirmasiPesanan()
	{
		$uid = $this->input->post('uid');
		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$update = $this->Model->setUpdate('tbl_order', ['status' => $status], ['id' => $id]);

		if ($update) {
			$title = 'Reservasi Ruang Seduh Coffe';
			$token = $this->Model->query("SELECT token FROM tbl_customer WHERE UID = '$uid'")[0]['token'];

			switch ($status) {
				case 'Sukses':
					$body = "Pembayaran anda untuk ID Pemesanan {$id} telah dikonfirmasi";
					break;
				case 'Ditolak':
					$body = "Maaf, Pembayaran anda untuk ID Pemesanan {$id} ditolak";
					break;
			}

			$this->Model->sendGCM($title, $body, $token);
		}

		echo json_encode($update);
	}

	public function getNotifikasi()
	{
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache');

		ignore_user_abort(true);

		$last_insert = '';

		while (true) {
			if (connection_aborted()) {
				exit();
			} else {
				$data = $this->Model->query("SELECT a.last_update, b.id, b.tanggal, b.jam, b.durasi, b.daftarMeja, b.totalHarga, b.file, b.uid, c.nama, IF(b.status IS NULL, IF(DATE_ADD(b.ditambahkan_pada, INTERVAL 1 HOUR) > now(), 'Belum diupload' , 'Expired'), b.status) as status FROM tbl_notifikasi a LEFT JOIN tbl_order b ON a.id = b.id LEFT JOIN tbl_customer c ON b.uid = c.uid ORDER BY a.last_update DESC LIMIT 1")[0];

				if ($last_insert != $data['last_update']) {
					echo "event: update" . PHP_EOL;
					echo "data: " . json_encode($data) . PHP_EOL;
					echo PHP_EOL;
					// ob_flush();
					flush();

					$last_insert = $data['last_update'];
				}
			}
			sleep(3);
		}
	}
}
