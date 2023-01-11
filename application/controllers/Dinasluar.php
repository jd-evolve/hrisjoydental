<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinasluar extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_JABATAN',$this->session->userdata('id_jabatan'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	public function read_dinasluar(){
		$dinasluar = $this->m_auth->getDinasLuar();
		$data = [];
		$no = 0;
		foreach ($dinasluar as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tujuan'] = $list->kota_tujuan;
			$row['Nama'] = count(explode("   ,",$list->member)) > 1 ? str_replace('   ,','<br>',$list->member) : $list->member;
			$row['Tanggal'] = date_format(date_create($list->tgl_berangkat),"d/m/Y").' s/d '.date_format(date_create($list->tgl_pulang),"d/m/Y");
			$row['Keperluan'] = $list->keperluan;
			$row['Aksi'] = $list->id_dinas_member;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}


}