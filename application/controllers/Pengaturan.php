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
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }
    
	//================= KONFIGURASI
	public function get_konfigurasi(){
		$cuti_tahunan = $this->m_main->getRow('db_ijincuti','id_ijincuti',1);
		$cuti_menikah = $this->m_main->getRow('db_ijincuti','id_ijincuti',2);
		$cuti_melahirkan = $this->m_main->getRow('db_ijincuti','id_ijincuti',3);
		$ijin_pribadi = $this->m_main->getRow('db_ijincuti','id_ijincuti',4);
		$ijin_duka = $this->m_main->getRow('db_ijincuti','id_ijincuti',5);
		$ijin_sakit = $this->m_main->getRow('db_ijincuti','id_ijincuti',6);
		$smtp_host = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_host');
		$smtp_port = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_port');
		$smtp_user = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_user');
		$smtp_pass = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','smtp_pass');
		$initial_name = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','initial_name');
		$keterlambatan = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','keterlambatan');
		$pulang_awal = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','pulang_awal');
		
		$output = [
			'cuti_tahunan' => floatval($cuti_tahunan['potong_cuti']),
			'cuti_menikah' => floatval($cuti_menikah['potong_cuti']),
			'cuti_melahirkan' => floatval($cuti_melahirkan['potong_cuti']),
			'ijin_pribadi' => floatval($ijin_pribadi['potong_cuti']),
			'ijin_duka' => floatval($ijin_duka['potong_cuti']),
			'ijin_sakit' => floatval($ijin_sakit['potong_cuti']),
			'smtp_host' => $smtp_host['isi_konfigurasi'],
			'smtp_port' => $smtp_port['isi_konfigurasi'],
			'smtp_user' => $smtp_user['isi_konfigurasi'],
			'smtp_pass' => $smtp_pass['isi_konfigurasi'],
			'initial_name' => $initial_name['isi_konfigurasi'],
			'keterlambatan' => $keterlambatan['isi_konfigurasi'],
			'pulang_awal' => $pulang_awal['isi_konfigurasi'],
		];
		echo json_encode($output);
	}

	public function edit_konfigurasi(){
        $cuti_tahunan['potong_cuti'] = $_POST['cuti_tahunan'];
        $cuti_menikah['potong_cuti'] = $_POST['cuti_menikah'];
        $cuti_melahirkan['potong_cuti'] = $_POST['cuti_melahirkan'];
        $ijin_pribadi['potong_cuti'] = $_POST['ijin_pribadi'];
        $ijin_duka['potong_cuti'] = $_POST['ijin_duka'];
        $ijin_sakit['potong_cuti'] = $_POST['ijin_sakit'];
        $smtp_host['isi_konfigurasi'] = $_POST['smtp_host'];
        $smtp_port['isi_konfigurasi'] = $_POST['smtp_port'];
        $smtp_user['isi_konfigurasi'] = $_POST['smtp_user'];
        $smtp_pass['isi_konfigurasi'] = $_POST['smtp_pass'];
        $initial_name['isi_konfigurasi'] = $_POST['initial_name'];
        $keterlambatan['isi_konfigurasi'] = $_POST['keterlambatan'];
        $pulang_awal['isi_konfigurasi'] = $_POST['pulang_awal'];
        $tgl['tgl_edit'] = date("Y-m-d H:i:s");

        $this->m_main->updateIN('db_ijincuti','id_ijincuti',1,$cuti_tahunan);
        $this->m_main->updateIN('db_ijincuti','id_ijincuti',2,$cuti_menikah);
        $this->m_main->updateIN('db_ijincuti','id_ijincuti',3,$cuti_melahirkan);
        $this->m_main->updateIN('db_ijincuti','id_ijincuti',4,$ijin_pribadi);
        $this->m_main->updateIN('db_ijincuti','id_ijincuti',5,$ijin_duka);
        $this->m_main->updateIN('db_ijincuti','id_ijincuti',6,$ijin_sakit);

        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_host',$smtp_host);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_port',$smtp_port);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_user',$smtp_user);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','smtp_pass',$smtp_pass);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','initial_name',$initial_name);

        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','keterlambatan',$keterlambatan);
        $this->m_main->updateIN('db_konfigurasi','kode_konfigurasi','pulang_awal',$pulang_awal);
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