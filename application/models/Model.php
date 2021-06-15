<?php

/**
 * 
 */
class Model extends CI_Model
{
    public function getPage($url, $jenis = '')
    {
        $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
        $numSegments = count($segments);
        $currentSegment = $segments[$numSegments - 1];

        $classActive = ($jenis == 'icon' ? ($url == $currentSegment ? 'text-yellow' : 'text-primary') : ($url == $currentSegment ? 'active' : ''));

        return $classActive;
    }

    function query($query)
    {
        $res = $this->db->query($query)->result_array();
        return $res;
    }

    function ambilData($tbl, $select = '*', $join = [], $where = [], $order = '')
    {
        $this->db->select($select);
        $this->db->from($tbl);
        if (!empty($join)) {
            foreach ($join as $val) {
                $this->db->join($val['tbl'], $val['on'], 'left');
            }
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        if ($order != '') {
            $this->db->order_by($order);
        }
        $res = $this->db->get()->result_array();

        return $res;
    }

    function setTambah($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function setUpdate($table, $data, $where)
    {
        $this->db->set($data);
        $this->db->where($where);
        return $this->db->update($table);
    }

    function setHapus($table, $data)
    {
        return $this->db->delete($table, $data);
    }

    function cekData($tbl, $where)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get_where($tbl, $where);
        return $res->result_array()[0]['total'];
    }

    function ambilTotalData($tbl)
    {
        $this->db->select('count(*) as total');
        $res = $this->db->get($tbl);
        return $res->result_array()[0]['total'];
    }

    function cekRow($table, $kolom, $val, $panjang)
    {
        $query = "SELECT * FROM $table";
        $row = $this->db->query($query)->num_rows() + 1;

        do {
            $no = str_pad($row, $panjang, '0', STR_PAD_LEFT);
            $id = $val . '-' . $no;
            $cek = "SELECT * FROM $table where $kolom = '$id'";
            $query_cek = $this->db->query($cek)->num_rows();
            $row++;
        } while ($query_cek > 0);
        return $id;
    }

    function sendGCM($title, $body, $token)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = 'AAAArVtNi0M:APA91bG0-aoRqHgHrUMyMQQ3sGlU_GrPbbDLvKD2PFuSFqy5uOLtNbhXS35hRMB2iMOgp3VLDNV7xmJEFeYPClsGdLvnU6Ukftpaj0SMYxfnicAaMBtPDg7UovXB9gIpgbj3ECCDEWDK';

        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');

        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');

        $json = json_encode($arrayToSend);

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        $headers[] = 'Authorization: key=' . $serverKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Send the request
        curl_exec($ch);

        curl_close($ch);
    }

    function getWaktu()
    {
        date_default_timezone_set('Asia/Makassar');
        $waktu = date('Y-m-d H:i:s');

        return $waktu;
    }

    function uploadFile($target_dir)
    {
        $fileExtension = ['JPEG', 'JPG', 'PNG'];

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $uploadOk = 1;
        $target_file = $target_dir . basename($_FILES['file']["name"]);
        $FileType = pathinfo($target_file, PATHINFO_EXTENSION);

        // Check file size
        if ($_FILES['file']["size"] > 4048000) {
            echo json_encode(array(false, "File " . basename($_FILES['file']["name"]) . " terlalu besar (Max 2MB)"));
            $uploadOk = 0;
        } else
            if (!in_array(strtoupper($FileType), $fileExtension)) {
            echo json_encode(array(false, "Format file harus (" . join(', ', $fileExtension) . ")"));
            $uploadOk = 0;
        } else
            if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            echo json_encode(array(false, "File gagal diupload"));
        }

        return $uploadOk;
    }

    // function uploadFile($filename)
    // {
    //     $target_dir = "./images/";
    //     if (!file_exists($target_dir)) {
    //         mkdir($target_dir, 0777, true);
    //     }

    //     $uploadOk = 1;
    //     $extension  = pathinfo($_FILES['foto']["name"], PATHINFO_EXTENSION);
    //     $target_file = $target_dir . $filename . '.' . $extension;

    //     // Check file size
    //     if ($_FILES['foto']["size"] > 2048000) {
    //         echo json_encode(array(false, "File " . basename($_FILES['foto']["name"]) . " terlalu besar (Max 2MB)"));
    //         $uploadOk = 0;
    //     } else            
    //         if (move_uploaded_file($_FILES['foto']["tmp_name"], $target_file)) {
    //         $uploadOk = 1;
    //     } else {
    //         $uploadOk = 0;
    //         echo json_encode(array(false, "File gagal diupload"));
    //     }

    //     return $uploadOk;
    // }

    function getNotifikasi($user)
    {
        $cekMasuk = $this->query("SELECT COUNT(jumlah) as total FROM tbl_permintaan WHERE kepada = '$user' AND status = 'Order'")[0]['total'];

        return $cekMasuk;
    }

    function tanggal_indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split    = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0] . ' ' . (isset($split[3]) ? $split[3] : '');

        return $tgl_indo;
    }
}
