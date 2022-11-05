<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_auth', 'm_auth');
		$this->load->model('M_dashboard', 'm_dashboard');
		define('U_VERSI', '01.20.50'); //Setiap edit program wajib di ganti untuk clear chace!
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		$account = $this->m_auth->getRow('account','email',EMAIL);
		define('JAM_MASUK_OLD',$account['tgl_masuk']);
		define('JAM_MASUK',$this->session->userdata('tgl_masuk'));
    }

	public function error_404(){
		header("Location:".base_url());
	}
	
	public function dashboard(){
		if(EMAIL && (JAM_MASUK == JAM_MASUK_OLD)){
			$data['vrs'] = U_VERSI;
			$data['title'] = 'Dashboard';
			$data['account'] = $this->m_auth->getRow('account','email',EMAIL);
			$data['account_online'] = $this->m_dashboard->GetAccountOnline();
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
			$data['account'] = $this->m_auth->getRow('account','email',EMAIL);
			$this->load->view('layout/header', $data);
			$this->load->view('profil/profil');
			$this->load->view('layout/footer');
		}else{
			redirect('logout');
		}
    }
	
}