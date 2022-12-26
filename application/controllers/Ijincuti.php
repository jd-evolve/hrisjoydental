<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ijincuti extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	public function read_accatasan(){
		$ijincuti = $this->m_auth->GetLlistIjinCuti_ACCAtasan(ID_ACCOUNT,$_POST['status']);
		$data = [];
		$no = 0;
		foreach ($ijincuti as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_input),"d-m-Y");
			$row['IjinCuti'] = $list->nama_ijincuti;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_ijincuti_list;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_accpersonalia(){
		$ijincuti = $this->m_auth->GetLlistIjinCuti_ACCPersonalia(ID_ACCOUNT,$_POST['status']);
		$data = [];
		$no = 0;
		foreach ($ijincuti as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_input),"d-m-Y");
			$row['Potongan'] = floatval($list->potong_cuti);
			$row['IjinCuti'] = $list->nama_ijincuti;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_ijincuti_list;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

    public function add_ijincuti(){
		if(!empty($_POST['id_ijincuti'])){
			$potongancuti = $this->m_main->getRow('db_ijincuti','id_ijincuti',$_POST['id_ijincuti']);
			$atasan = $this->m_main->getRow('db_posisi','id_posisi',ID_POSISI);
			$data = [
				'id_ijincuti' => $_POST['id_ijincuti'],
				'id_karyawan' => ID_ACCOUNT,
				'id_atasan' => $atasan['id_atasan'],
				'keperluan' => $_POST['keperluan'],
				'tgl_awal' => date_format(date_create($_POST['tgl_awal']),"Y-m-d"),
				'tgl_akhir' => date_format(date_create($_POST['tgl_akhir']),"Y-m-d"),
				'jam_awal' => date_format(date_create($_POST['tgl_awal']),"H:i:s"),
				'jam_akhir' => date_format(date_create($_POST['tgl_akhir']),"H:i:s"),
				'total_hari' => $_POST['total_hari'],
				'total_jam' => $_POST['total_jam'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'potong_cuti' => $potongancuti['potong_cuti'],
				'status' => 0, //diajukan
				'id_account' => ID_ACCOUNT,
			];
			
			if(!empty($_FILES['file_ijincuti']['name'])) {
				$uploadDIR = './assets/img/ijincuti/';
				$config['upload_path']		= $uploadDIR;
				$config['allowed_types']	= 'jpg|png|jpeg';
				$config['max_size'] 		= 1536; //1.5MB
				$config['file_name']		= 'ijincuti-' . date('ymd') . '-' . substr(md5(rand()), 0, 10);
				$this->load->library('upload', $config);
				if($this->upload->do_upload('file_ijincuti')) {
					$uploadData = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $uploadDIR . $uploadData['file_name'];
					$config['create_thumb'] = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = '100%';
					$config['new_image'] = $uploadDIR . $uploadData['file_name'];
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					$data['file'] = $uploadData['file_name'];
				}
			}
			$ArrIjinCuti = explode("|","-|cuti tahunan|cuti menikah|cuti melahirkan|ijin pribadi|ijin duka");
			$this->m_main->createIN('db_ijincuti_list',$data);
			$output['message'] ="Data ". $ArrIjinCuti[$_POST['id_ijincuti']]." berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Ijin/Cuti tidak diketahui!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
    }

    public function read_ijincuti(){
		$ijincuti = $this->m_auth->GetLlistIjinCuti(ID_ACCOUNT,$_POST['id_ijincuti'],$_POST['status']);
		$data = [];
		$no = 0;
		foreach ($ijincuti as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_awal),"d-m-Y").' sampai '.date_format(date_create($list->tgl_akhir),"d-m-Y");
			$row['Cuti'] = $list->status == 0 || $list->status == 1 ? 'prosess' : floatval($list->potong_cuti).' Cuti';
			$row['Keperluan'] = $list->keperluan;
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_ijincuti_list;
			$row['tgl_create'] = date_format(date_create($list->tgl_input),"d F Y");
			$row['tgl_awal'] = date_format(date_create($list->tgl_awal.' '.$list->jam_awal),"d-m-Y H:i");
			$row['tgl_akhir'] = date_format(date_create($list->tgl_akhir.' '.$list->jam_akhir),"d-m-Y H:i");
			$row['total_hari'] = $list->total_hari;
			$row['total_jam'] = $list->total_jam;
			$row['file'] = $list->file == NULL ? '-' : $list->file;
			$row['alasan_ditolak'] = $list->alasan_ditolak;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function detail_ijincuti(){
		$detail = $this->m_main->getRow('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list']);
		$atasan = $this->m_main->getRow('db_account','id_account',$detail['id_atasan']);
		$karyawan = $this->m_main->getRow('db_account','id_account',$detail['id_karyawan']);
		$jabatan = $this->m_main->getRow('db_posisi','id_posisi',$karyawan['id_posisi']);
		$ijincuti = $this->m_main->getRow('db_ijincuti','id_ijincuti',$detail['id_ijincuti']);

		if($detail['id_personalia'] != null){
			$getName = $this->m_main->getRow('db_account','id_account',$detail['id_personalia']);
			$personalia = $getName['nama'];
		}else{
			$personalia = '_________';
		}

		$data = [];
		$data['tanggal'] = date_format(date_create($detail['tgl_awal']),"d-m-Y").' sampai '.date_format(date_create($detail['tgl_akhir']),"d-m-Y");
		$data['cuti'] = $detail['status'] == 0 ? 'prosess' : floatval($detail['potong_cuti']).' Cuti';
		$data['keperluan'] = $detail['keperluan'];
		$data['status'] = $detail['status'];
		$data['tgl_create'] = date_format(date_create($detail['tgl_input']),"d F Y");
		$data['tgl_awal'] = date_format(date_create($detail['tgl_awal'].' '.$detail['jam_awal']),"d-m-Y H:i");
		$data['tgl_akhir'] = date_format(date_create($detail['tgl_akhir'].' '.$detail['jam_akhir']),"d-m-Y H:i");
		$data['total_hari'] = $detail['total_hari'];
		$data['total_jam'] = $detail['total_jam'];
		$data['file'] = $detail['file'] == NULL ? '-' : $detail['file'];
		$data['alasan_ditolak'] = $detail['alasan_ditolak'];
		$data['karyawan'] = $karyawan['nama'];
		$data['bagian'] = $karyawan['bagian'];
		$data['jam_perhari'] = $karyawan['jam_perhari'];
		$data['jabatan'] = $jabatan['nama_posisi'];
		$data['id_atasan'] = $detail['id_atasan'];
		$data['id_personalia'] = $detail['id_personalia'];
		$data['nama_atasan'] = $atasan['nama'];
		$data['nama_personalia'] = $personalia;
		$data['potong_cuti'] = $detail['potong_cuti'];
		$data['ijincuti'] = strtoupper('FORM '.$ijincuti['nama_ijincuti']);
		echo json_encode($data);
	}

	public function accatasan_ijincuti(){
		if(!empty($_POST['id_ijincuti_list'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list'],$data);
			$output['message'] = "Pengajuan Ijin/Cuti telah disetujui!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id ijin/cuti tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function accpersonalia_ijincuti(){
		if(!empty($_POST['id_ijincuti_list'])){
			$data = [
				'status' => 2,
				'potong_cuti' => $_POST['potong_cuti'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
				'id_personalia' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list'],$data);
			
			$ijincuti = $this->m_main->getRow('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list']);
			$karyawan = $this->m_main->getRow('db_account','id_account',$ijincuti['id_karyawan']);

			$cuti = [
				'sisa_cuti' => $karyawan['sisa_cuti'] - $_POST['potong_cuti'],
			];
			$this->m_main->updateIN('db_account','id_account',$karyawan['id_account'],$cuti);

			$output['message'] = "Pengajuan Ijin/Cuti telah disetujui!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id ijin/cuti tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function tolakatasan_ijincuti(){
		if(!empty($_POST['id_ijincuti_list'])){
			$data = [
				'status' => 3,
				'potong_cuti' => 0,
				'alasan_ditolak' => $_POST['alasan_ditolak'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list'],$data);
			$output['message'] = "Pengajuan ijin/cuti telah ditolak!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id ijin/cuti tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function tolakpersonalia_ijincuti(){
		if(!empty($_POST['id_ijincuti_list'])){
			$ijincuti = $this->m_main->getRow('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list']);
			$karyawan = $this->m_main->getRow('db_account','id_account',$ijincuti['id_karyawan']);

			if($ijincuti['status']==2){
				$cuti = [
					'sisa_cuti' => $karyawan['sisa_cuti'] + $ijincuti['potong_cuti'],
				];
				$this->m_main->updateIN('db_account','id_account',$karyawan['id_account'],$cuti);
			}

			$data = [
				'status' => 3,
				'potong_cuti' => 0,
				'alasan_ditolak' => $_POST['alasan_ditolak'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
				'id_personalia' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_ijincuti_list','id_ijincuti_list',$_POST['id_ijincuti_list'],$data);
			$output['message'] = "Pengajuan ijin/cuti telah ditolak!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id ijin/cuti tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function read_rekapijincuti(){
		$ijincuti = $this->m_auth->GetLlistIjinCuti_Rekap($_POST['id_ijincuti'],$_POST['id_karyawan']);
		$data = [];
		$no = 0;
		foreach ($ijincuti as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_input),"d-m-Y");
			$row['Awal'] = date_format(date_create($list->tgl_awal.' '.$list->jam_awal),"d-m-Y H:i");
			$row['Akhir'] = date_format(date_create($list->tgl_akhir.' '.$list->jam_akhir),"d-m-Y H:i");
			$row['Hari'] = $list->total_hari;
			$row['Jam'] = $list->total_jam;
			$row['IjinCuti'] = $list->nama_ijincuti;
			$row['Potongan'] = floatval($list->potong_cuti);
			$row['Karyawan'] = $list->karyawan;
			$row['Aksi'] = $list->id_ijincuti_list;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
}