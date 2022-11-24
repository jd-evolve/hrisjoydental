<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

    public function kegiatan(){
		$kegiatan = $this->m_auth->GetAllKegiatan();
        $grafik = array();
		foreach ($kegiatan as $list) {
			$row = [];
			$row['start'] = $list->tgl_kegiatan;
			$row['end'] = $list->tgl_kegiatan;
			$grafik[] =  $row;
		}
        echo json_encode($grafik);
        exit();
	}
    
    public function list_kegiatan(){
		$kegiatan = $this->m_auth->GetListKegiatan($_POST['full_date']);
		$data = [];
		foreach ($kegiatan as $list) {
            $mons = explode(" ","Nul Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec");
            $month = $mons[intval(date_format(date_create($list->tgl_kegiatan),"m"))];
            $day = date_format(date_create($list->tgl_kegiatan),"d");
            $date = $month.' '.$day;
			$row = [];
			$row['Tanggal'] = $date;
			$row['Kegiatan'] = $list->kegiatan;
			$data[] =  $row;
		}
        echo json_encode($data);
        exit();
    }
}