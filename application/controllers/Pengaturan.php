<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_KOTA',$this->session->userdata('id_kota'));
    }
    
	//================= KONFIGURASI
	public function get_konfigurasi(){
		$cuti_tahunan = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','cuti_tahunan');
		$cuti_menikah = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','cuti_menikah');
		$cuti_melahirkan = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','cuti_melahirkan');
		$ijin_pribadi = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','ijin_pribadi');
		$ijin_duka = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','ijin_duka');
		$ijin_dinas = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','ijin_dinas');
		$smtp_host = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_host');
		$smtp_port = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_port');
		$smtp_user = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_user');
		$smtp_pass = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_pass');
		$initial_name = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','initial_name');
		
		$output = [
			'cuti_tahunan' => $cuti_tahunan['isi_konfigurasi'],
			'cuti_menikah' => $cuti_menikah['isi_konfigurasi'],
			'cuti_melahirkan' => $cuti_melahirkan['isi_konfigurasi'],
			'ijin_pribadi' => $ijin_pribadi['isi_konfigurasi'],
			'ijin_duka' => $ijin_duka['isi_konfigurasi'],
			'ijin_dinas' => $ijin_dinas['isi_konfigurasi'],
			'smtp_host' => $smtp_host['isi_konfigurasi'],
			'smtp_port' => $smtp_port['isi_konfigurasi'],
			'smtp_user' => $smtp_user['isi_konfigurasi'],
			'smtp_pass' => $smtp_pass['isi_konfigurasi'],
			'initial_name' => $initial_name['isi_konfigurasi'],
		];
		echo json_encode($output);
	}

	public function edit_konfigurasi(){
        $cuti_tahunan['isi_konfigurasi'] = $_POST['cuti_tahunan'];
        $cuti_menikah['isi_konfigurasi'] = $_POST['cuti_menikah'];
        $cuti_melahirkan['isi_konfigurasi'] = $_POST['cuti_melahirkan'];
        $ijin_pribadi['isi_konfigurasi'] = $_POST['ijin_pribadi'];
        $ijin_duka['isi_konfigurasi'] = $_POST['ijin_duka'];
        $ijin_dinas['isi_konfigurasi'] = $_POST['ijin_dinas'];
        $smtp_host['isi_konfigurasi'] = $_POST['smtp_host'];
        $smtp_port['isi_konfigurasi'] = $_POST['smtp_port'];
        $smtp_user['isi_konfigurasi'] = $_POST['smtp_user'];
        $smtp_pass['isi_konfigurasi'] = $_POST['smtp_pass'];
        $initial_name['isi_konfigurasi'] = $_POST['initial_name'];
        $tgl['tgl_edit'] = date("Y-m-d H:i:s");

        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','cuti_tahunan',$cuti_tahunan);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','cuti_menikah',$cuti_menikah);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','cuti_melahirkan',$cuti_melahirkan);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','ijin_pribadi',$ijin_pribadi);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','ijin_duka',$ijin_duka);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','ijin_dinas',$ijin_dinas);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_host',$smtp_host);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_port',$smtp_port);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_user',$smtp_user);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_pass',$smtp_pass);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','initial_name',$initial_name);
        $this->m_main->updateIN('db_konfigurasi','status',1,$tgl);
        
        $output['message'] ="Data konfigurasi berhasil diubah!";
        $output['result'] = "success";
        echo json_encode($output);
        exit();
	}

    public function logout_all(){
		$data = [
			'tgl_masuk' => date("Y-m-d H:i:s"),
		];
		$account = $this->m_main->getRow('db_account','email',EMAIL);
		$this->m_main->updateIN('db_account','tgl_masuk >',$account['tgl_keluar'],$data);
		$output['message'] ="Seluruh akun yang login berhasil di logout semua!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
    }

}