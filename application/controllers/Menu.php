<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('U_VERSI', '01.20.50'); //Setiap edit program wajib di ganti untuk clear chace!
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_KOTA',$this->session->userdata('id_kota'));
		$account = $this->m_main->getRow('db_account','email',EMAIL);
		define('JAM_MASUK_OLD',$account['tgl_masuk']);
		define('JAM_MASUK',$this->session->userdata('tgl_masuk'));
    }

	public function error_404(){
		header("Location:".base_url());
	}
	
	private function DataLevel(){
		$menu = $this->m_auth->GetLevelMenu();
		foreach ($menu as $list) {
			$data[$list->uri_menu] = $this->m_auth->cekMenu(ID_POSISI,$list->id_level_menu);
		}
		$submenu = $this->m_auth->GetLevelSubmenu();
		foreach ($submenu as $list) {
			$data[$list->uri_submenu] = $this->m_auth->cekSubmenu(ID_POSISI,$list->id_level_submenu);
		}
		return $data;
	}
	
	public function dashboard(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI;
			$data['title'] = 'Dashboard';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['posisi'] = $this->m_main->getRow('db_posisi','id_posisi',ID_POSISI);
			$data['kota'] = $this->m_main->getRow('db_kota','id_kota',ID_KOTA);
			$data['cekmenu'] = $this->DataLevel();
			$data['account_online'] = $this->m_auth->GetAccountOnline();
			$this->load->view('layout/header', $data);
			$this->load->view('dashboard/dashboard');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
	}

	public function profil(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Profil';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('profil/profil');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
	
    public function member(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Member';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['posisi'] = $this->m_main->getRow('db_posisi','id_posisi',ID_POSISI);
			$data['kota'] = $this->m_main->getRow('db_kota','id_kota',ID_KOTA);
			$data['cekmenu'] = $this->DataLevel();
			$data['data_posisi'] = $this->m_main->getResult('db_posisi','status',1);
			$data['data_kota'] = $this->m_main->getResult('db_kota','status',1);
			$this->load->view('layout/header', $data);
			$this->load->view('masterdata/member');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
	
    public function level_member(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Level Member';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['posisi'] = $this->m_main->getRow('db_posisi','id_posisi',ID_POSISI);
			$data['kota'] = $this->m_main->getRow('db_kota','id_kota',ID_KOTA);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('masterdata/level_member');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
	
    public function kota_klinik(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Kota Klinik';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('masterdata/kota_klinik');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
	
    public function kegiatan_pengumuman(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI; 
			$data['title'] = 'Kegiatan Pengumuman';
			$data['account'] = $this->m_main->getRow('db_account','email',EMAIL);
			$data['cekmenu'] = $this->DataLevel();
			$this->load->view('layout/header', $data);
			$this->load->view('masterdata/kegiatan_pengumuman');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
}