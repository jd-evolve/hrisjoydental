<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_auth', 'm_auth');
    }

	public function index(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->session->userdata('email')){
			redirect('dashboard');
		}else {
			$this->load->view('home/login');
		}
	}

	public function login(){
		if($_POST['email']){
			$email = $_POST['email'];
			$password = $_POST['password'];
			$account = $this->m_auth->getRow('account','email',$email);
			if($account){
				if($account['status'] == 1){
					if(password_verify($password, $account['password'])){
						$this->m_auth->updateIN('account','id_account',$account['id_account'],['tgl_masuk' => date("Y-m-d H:i:s")]);
						
						$data = [
							'id_account' => $account['id_account'],
							'id_kota' => $account['id_kota'],
							'id_posisi' => $account['id_posisi'],
							'nama' => $account['nama'],
							'email' => $account['email'],
							'tgl_masuk' => date("Y-m-d H:i:s"),
							'login' => true,
						];
						$this->session->sess_expiration = '86400';
						$this->session->set_userdata($data);

						$output['message'] = base_url();
						$output['result'] = $data;
					}else{
						$output['message'] = "Password salah, coba kembali!";
						$output['result'] = "error";
					}
				}else{
					$output['message'] = "Mohon maaf, akun anda sudah terhapus!";
					$output['result'] = "error";
				}
			}else{
				$output['message'] = "Akun anda tidak terdaftar!";
				$output['result'] = "error";
			}
	
			echo json_encode($output);
			exit();
		}else{
			redirect('home');
		}
	}

	public function logout(){
		if($this->session->userdata('id_account')){
			$this->m_auth->updateIN('account','id_account',$this->session->userdata('id_account'),['tgl_keluar' => date("Y-m-d H:i:s")]);
		}
		$data = [
			'id_account',
			'id_kota',
			'id_posisi',
			'nama',
			'email',
			'tgl_masuk',
			'login',
		];
		$this->session->unset_userdata($data);
		redirect('login');
	}
}