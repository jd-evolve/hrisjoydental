<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_KOTA',$this->session->userdata('id_kota'));
    }
	
	//================= MEMBER
	public function read_member(){
		$member = $this->m_auth->GetAllMember();
		$data = [];
		$no = 0;
		foreach ($member as $list) {
			// if($list->id_account != 1){
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Kode'] = $list->kode;
				$row['No_induk'] = $list->nomor_induk;
				$row['Nama'] = $list->nama_member;
				$row['Gender'] = $list->gender;
				$row['tempat_lahir'] = $list->tempat_lahir;
				$row['tgl_lahir'] = date_format(date_create($list->tgl_lahir),"d-m-Y");
				$row['Email'] = $list->email;
				$row['Posisi'] = $list->nama_posisi;
				$row['Alamat'] = $list->alamat;
				$row['Nohp'] = $list->telp;
				$row['sisa_cuti'] = floatval($list->sisa_cuti);
				$row['nama_bank'] = $list->nama_bank;
				$row['nama_rek'] = $list->nama_rek;
				$row['no_rek'] = $list->no_rek;
				$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
				$row['Aksi'] = $list->id_account;
				$row['IDposisi'] = $list->id_posisi.'-';
				$row['AlamatLengkap'] = $list->alamat;
				$row['Level'] = $list->level;
				$row['Bagian'] = $list->bagian;
				$row['id_posisi'] = $list->id_posisi;
				$row['id_kota'] = $list->id_kota;
				$row['KotaKlinik'] = $list->nama_kota;
				$row['tgl_masuk'] = date_format(date_create($list->tgl_mulai_kerja),"d-m-Y");
				$data[] = $row; 
			// }
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_member(){
		$cekData = $this->m_main->cekData('db_account','email',$_POST['email']);
		if(!$cekData){
			$data = [
				'id_posisi' => $_POST['posisi'],
				'id_kota' => $_POST['kota'],
				'kode' => $_POST['kode'],
				'nomor_induk' => $_POST['nomor_induk'],
				'nama' => $_POST['nama'],
				'gender' => $_POST['gender'],
				'tempat_lahir' => $_POST['tempat_lahir'],
				'tgl_lahir' => date_format(date_create($_POST['tgl_lahir']),"Y-m-d"),
				'email' => $_POST['email'],
				'alamat' => $_POST['alamat'],
				'telp' => $_POST['nohp'],
				'nama_bank' => $_POST['nama_bank'],
				'nama_rek' => $_POST['nama_rek'],
				'no_rek' => $_POST['no_rek'],
				'level' => $_POST['level'],
				'bagian' => $_POST['bagian'],
				'sisa_cuti' => $_POST['sisa_cuti'],
				'password' => password_hash('12345678', PASSWORD_DEFAULT),
				'tgl_mulai_kerja' => date_format(date_create($_POST['tgl_masuk']),"Y-m-d"),
				'tgl_masuk' => '0000-00-00 00:00:00',
				'tgl_keluar' => '0000-00-00 00:00:00',
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_account',$data);
		
			$output['message'] ="Data member berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Email sudah di gunakan, coba dengan yang lain!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function edit_member(){
		if(!empty($_POST['id_account'])){
			$cekData = $this->m_main->cekData('db_account','email',$_POST['email']);
			$getData = $this->m_main->getRow('db_account','id_account',$_POST['id_account']);
			if(!$cekData || ($_POST['email']==$getData['email'])){
				$data = [
					'id_posisi' => $_POST['posisi'],
					'id_kota' => $_POST['kota'],
					'kode' => $_POST['kode'],
					'nomor_induk' => $_POST['nomor_induk'],
					'nama' => $_POST['nama'],
					'gender' => $_POST['gender'],
					'tempat_lahir' => $_POST['tempat_lahir'],
					'tgl_lahir' => date_format(date_create($_POST['tgl_lahir']),"Y-m-d"),
					'email' => $_POST['email'],
					'alamat' => $_POST['alamat'],
					'telp' => $_POST['nohp'],
					'nama_bank' => $_POST['nama_bank'],
					'nama_rek' => $_POST['nama_rek'],
					'no_rek' => $_POST['no_rek'],
					'level' => $_POST['level'],
					'bagian' => $_POST['bagian'],
					'sisa_cuti' => $_POST['sisa_cuti'],
					'tgl_mulai_kerja' => date_format(date_create($_POST['tgl_masuk']),"Y-m-d"),
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
				$output['message'] ="Data member berhasil di ubah!";
				$output['result'] = "success";
			}else{
				$output['message'] ="Email sudah di gunakan, coba dengan yang lain!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Data id member tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_member(){
		if(!empty($_POST['id_account'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'tgl_keluar' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
			$output['message'] = "Member berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id member tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_member(){
		if(!empty($_POST['id_account'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'tgl_keluar' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
			$output['message'] = "Member berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id member tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_member(){
		if(!empty($_POST['id_account'])){
			$this->m_main->deleteIN('db_account','id_account',$_POST['id_account']);
			$output['message'] = "Member berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id member tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_member(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_POSISI,2,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_POSISI,2,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_POSISI,2,4);
		echo json_encode($output);
	}
    
	//================= Jabatan
	public function read_jabatan(){
		$jabatan = $this->m_auth->GetAllLevel();
		$data = [];
		$no = 0;
		foreach ($jabatan as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Nama'] = $list->nama_posisi;
			$row['Keterangan'] = $list->keterangan;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$row['Aksi'] = $list->id_posisi;
			$row['id_atasan'] = $list->id_atasan;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_jabatan(){
		if(!empty($_POST['numb'])){
			$datax = [
				'id_atasan' => $_POST['list_atasan'],
				'nama_posisi' => $_POST['nama_posisi'],
				'keterangan' => $_POST['keterangan'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$qry = $this->m_main->createIN('db_posisi',$datax);
			$id_posisi = $qry['result'];

			for($i=0; $i<$_POST['numb']; $i++){
				$level = $_POST['lvl'.$i];
				$status = explode(",",$level)[0] == 'true' ? 1 : 0;
				$id_level_submenu = explode(",",$level)[2];
				$id_level_aksi = explode(",",$level)[3];

				$cek = $this->m_auth->cekLevel($id_posisi,$id_level_submenu,$id_level_aksi);
				if(!$cek){
					$data = [
						'id_posisi' => $id_posisi,
						'id_level_submenu' => $id_level_submenu,
						'id_level_aksi' => $id_level_aksi,
						'status' => $status,
					];
					$this->m_main->createIN('db_level_akses',$data);
				}else{
					$stts['status'] = $status;
					$this->m_main->updateIN('db_level_akses','id_level_akses',$cek['id_level_akses'],$stts);
				}
			}
			
			$output['message'] ="Data posisi berhasil di tambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Terjadi kesalahan ketika menyimpan data!";
			$output['result'] = "error";
		}

        echo json_encode($output);
        exit();
	}

	public function edit_jabatan(){
		if(!empty($_POST['numb'])){
			$datax = [
				'id_atasan' => $_POST['list_atasan'],
				'nama_posisi' => $_POST['nama_posisi'],
				'keterangan' => $_POST['keterangan'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$qry = $this->m_main->updateIN('db_posisi','id_posisi',$_POST['id_posisi'],$datax);

			for($i=0; $i<$_POST['numb']; $i++){
				$level = $_POST['lvl'.$i];
				$status = explode(",",$level)[0] == 'true' ? 1 : 0;
				$id_posisi = explode(",",$level)[1];
				$id_level_submenu = explode(",",$level)[2];
				$id_level_aksi = explode(",",$level)[3];
				
				$cek = $this->m_auth->cekLevel($id_posisi,$id_level_submenu,$id_level_aksi);
				if(!$cek){
					$data = [
						'id_posisi' => $id_posisi,
						'id_level_submenu' => $id_level_submenu,
						'id_level_aksi' => $id_level_aksi,
						'status' => $status,
					];
					$this->m_main->createIN('db_level_akses',$data);
				}else{
					$stts['status'] = $status;
					$this->m_main->updateIN('db_level_akses','id_level_akses',$cek['id_level_akses'],$stts);
				}
			}
			
			$output['message'] ="Data posisi berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Terjadi kesalahan ketika menyimpan data!";
			$output['result'] = "error";
		}

        echo json_encode($output);
        exit();
	}
	
	public function remove_jabatan(){
		if(!empty($_POST['id_posisi'])){
			if($_POST['id_posisi'] == 1 || $_POST['id_posisi'] == 2){
				$output['message'] = "Data posisi tidak dapat dihapus!";
				$output['result'] = "error";
			}else{
				$data = [
					'status' => 0,
					'tgl_edit' => date("Y-m-d H:i:s"),
					'id_account' => ID_ACCOUNT,
				];
				$qry = $this->m_main->updateIN('db_posisi','id_posisi',$_POST['id_posisi'],$data);
				$output['message'] = "Jabatan berhasil di hapus!";
				$output['result'] = "success";
			}
		}else{
			$output['message'] = "Data id jabatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_jabatan(){
		if(!empty($_POST['id_posisi'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$qry = $this->m_main->updateIN('db_posisi','id_posisi',$_POST['id_posisi'],$data);
			$output['message'] = "Jabatan berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jabatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_jabatan(){
		if(!empty($_POST['id_posisi'])){
			$this->m_main->deleteIN('db_posisi','id_posisi',$_POST['id_posisi']);
			$output['message'] = "Jabatan berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jabatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function list_jabatan(){
		$id_level = $_POST['id_jabatan'];
		$html = '';
		$no = 0;
		$menu = $this->m_auth->GetLevelMenu();
		foreach($menu as $x) {
			$html .= '<tr class="bg-green-smooth"><th colspan="2">Hak Akses '.$x->nama_menu.'</th></tr>';
			$submenu = $this->m_auth->GetLevelSubmenuList($x->id_level_menu);
			foreach($submenu as $y){
				$html .= '<tr><td style="width:20%;">'.$y->nama_submenu.'</td><td>';
				$aksi = $this->m_auth->GetLevelAksi();
				foreach($aksi as $z){
					if($id_level != null){
						$cekhakakses = $this->m_auth->CekHakAkses($y->id_level_submenu,$z->id_level_aksi,$id_level);
						$checked = $cekhakakses ? ($cekhakakses['status']==1? 'checked' : '' ) : '';
					}else{ $checked = ''; }

					if(in_array($z->id_level_aksi, explode(',',$y->list_aksi))){
						$name = 'lvl'.$no++;
						$html.= $this->html_level($id_level, $y->id_level_submenu, $z->id_level_aksi, $name, $z->nama_aksi, $checked); 
					}
				}
				$html .= '</td></tr>';
			}
		}
		
		$output = [ 
			"html" => $html,
			"numb" => $no,
		];
		echo json_encode($output);
	}

	private function html_level($id_posisi, $id_level_submenu, $id_level_aksi, $name, $nama_aksi, $check){
		$html = '<label class="mr-3"><input type="checkbox" class="mr-1"'.
				'name="'.$name.'" value="'.$id_posisi.','.$id_level_submenu.','.$id_level_aksi.'"'.
				' '.$check.'>'.$nama_aksi.'</label>';
		return $html ;
	}

    //================= KOTA KLINIK
	public function read_kota(){
		$kota = $this->m_main->readIN('db_kota');
		$data = [];
		$no = 0;
		foreach ($kota as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Kota'] = $list->nama_kota;
			$row['Inisial'] = $list->inisial_kota;
			$row['Aksi'] = $list->id_kota;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_kota(){
		if(!empty($_POST['nama_kota'])){
			$data = [
				'nama_kota' => $_POST['nama_kota'],
				'inisial_kota' => $_POST['inisial_kota'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->createIN('db_kota',$data);
			$output['message'] ="Data kota berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Nama kota tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_kota(){
		if(!empty($_POST['id_kota'])){
			$data = [
				'nama_kota' => $_POST['nama_kota'],
				'inisial_kota' => $_POST['inisial_kota'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kota','id_kota',$_POST['id_kota'],$data);
			$output['message'] ="Data kota berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_kota(){
		if(!empty($_POST['id_kota'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kota','id_kota',$_POST['id_kota'],$data);
			$output['message'] = "Kota berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_kota(){
		if(!empty($_POST['id_kota'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kota','id_kota',$_POST['id_kota'],$data);
			$output['message'] = "Kota berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_kota(){
		if(!empty($_POST['id_kota'])){
			$this->m_main->deleteIN('db_kota','id_kota',$_POST['id_kota']);
			$output['message'] = "Kota berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kota tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_kota(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_POSISI,4,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_POSISI,4,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_POSISI,4,4);
		echo json_encode($output);
	}
	
    //================= KEGIATAN
	public function read_kegiatan(){
		$kegiatan = $this->m_main->readIN('db_kegiatan');
		$data = [];
		$no = 0;
		foreach ($kegiatan as $list) {
			$account = $this->m_main->getRow('db_account','id_account',$list->id_account);
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_kegiatan),"d-m-Y");
			$row['Kegiatan'] = $list->kegiatan;
			$row['Oleh'] = $account['nama'];
			$row['Aksi'] = $list->id_kegiatan;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_kegiatan(){
		if(!empty($_POST['tgl_kegiatan'])){
			$data = [
				'kegiatan' => $_POST['kegiatan'],
				'tgl_kegiatan' => date_format(date_create($_POST['tgl_kegiatan']),"Y-m-d"),
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->createIN('db_kegiatan',$data);
			$output['message'] ="Data kegiatan berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Tgl kegiatan tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_kegiatan(){
		if(!empty($_POST['id_kegiatan'])){
			$data = [
				'kegiatan' => $_POST['kegiatan'],
				'tgl_kegiatan' => date_format(date_create($_POST['tgl_kegiatan']),"Y-m-d"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kegiatan','id_kegiatan',$_POST['id_kegiatan'],$data);
			$output['message'] ="Data kegiatan berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kegiatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_kegiatan(){
		if(!empty($_POST['id_kegiatan'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kegiatan','id_kegiatan',$_POST['id_kegiatan'],$data);
			$output['message'] = "Kegiatan berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kegiatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_kegiatan(){
		if(!empty($_POST['id_kegiatan'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_kegiatan','id_kegiatan',$_POST['id_kegiatan'],$data);
			$output['message'] = "Kegiatan berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kegiatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_kegiatan(){
		if(!empty($_POST['id_kegiatan'])){
			$this->m_main->deleteIN('db_kegiatan','id_kegiatan',$_POST['id_kegiatan']);
			$output['message'] = "Kegiatan berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id kegiatan tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_kegiatan(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_POSISI,5,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_POSISI,5,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_POSISI,5,4);
		echo json_encode($output);
	}
}