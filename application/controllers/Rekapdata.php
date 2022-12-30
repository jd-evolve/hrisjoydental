<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapdata extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	public function read_rekapijincuti(){
		$ijincuti = $this->m_auth->GetLlistIjinCuti_Rekap($_POST['id_ijincuti'],$_POST['id_karyawan'],$_POST['periode'],$_POST['status']);
		$data = [];
		$no = 0;
		foreach ($ijincuti as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Periode'] = $list->ket_periode;
			$row['Awal'] = date_format(date_create($list->tgl_awal.' '.$list->jam_awal),"d-m-Y H:i");
			$row['Akhir'] = date_format(date_create($list->tgl_akhir.' '.$list->jam_akhir),"d-m-Y H:i");
			$row['Hari'] = $list->total_hari;
			$row['Jam'] = $list->total_menit;
			$row['IjinCuti'] = $list->nama_ijincuti;
			$row['Potong'] = floatval($list->potong_cuti);
			$row['Atasan'] = $list->atasan;
			$row['Karyawan'] = $list->karyawan;
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_ijincuti_list;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekaplembur(){
		$lembur = $this->m_auth->GetLlistLembur_Rekap($_POST['periode'],$_POST['status'],$_POST['id_karyawan']);
		$data = [];
		$no = 0;
		foreach ($lembur as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Periode'] = $list->ket_periode;
			$row['Atasan'] = $list->atasan;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Jabatan'] = $list->jabatan;
			$row['Total'] = $list->total_lembur.' menit';
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_periode;
			$row['id_karyawan'] = $list->id_karyawan;
			$row['id_atasan'] = $list->id_karyawan;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekapketerlambatan(){
		$terlambat = $this->m_auth->GetLlistTerlambat_Rekap($_POST['periode'],$_POST['status'],$_POST['id_karyawan']);
		$data = [];
		$no = 0;
		foreach ($terlambat as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Periode'] = $list->ket_periode;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Total'] = $list->terlambat.' menit';
			$row['Terlambat'] = $list->jum_terlambat.' hari';
			$row['Status'] = $list->jum_terlambat < 8 ? 1 : ($list->urut5x_terlambat == 1 ? 3 : 2);
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekaplupaabsen(){
		$lupaabsen = $this->m_auth->GetLlistLupaAbsen_Rekap($_POST['periode'],$_POST['id_karyawan']);
		$data = [];
		$no = 0;
		foreach ($lupaabsen as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Periode'] = $list->ket_periode;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Lupa'] = $list->jum_lupa_absen.' hari';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
}