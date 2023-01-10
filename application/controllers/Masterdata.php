<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterdata extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_JABATAN',$this->session->userdata('id_jabatan'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }
	
	//================= ACCOUNT
	public function read_account(){
		$account = $this->m_auth->GetAllAccount();
		$pph21_persen_gaji = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','pph21_persen_gaji');
		$pph21_ketentuan_gaji = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','pph21_ketentuan_gaji');
		$data = [];
		$no = 0;
		foreach ($account as $list) {
			// if($list->id_account != 1){
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Kode'] = $list->kode;
				$row['nomor_induk'] = $list->nomor_induk;
				$row['nama_account'] = $list->nama_account;
				$row['gender'] = $list->gender;
				$row['tempat_lahir'] = $list->tempat_lahir;
				$row['tgl_lahir'] = date_format(date_create($list->tgl_lahir),"d-m-Y");
				$row['email'] = $list->email;
				$row['nama_jabatan'] = $list->nama_jabatan;
				$row['alamat'] = $list->alamat;
				$row['telp'] = $list->telp;
				$row['sisa_cuti'] = floatval($list->sisa_cuti);
				$row['jam_perhari'] = $list->jam_perhari;
				$row['nama_bank'] = $list->nama_bank;
				$row['nama_rek'] = $list->nama_rek;
				$row['no_rek'] = $list->no_rek;
				$row['status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
				$row['Aksi'] = $list->id_account;
				$row['IDjabatan'] = $list->id_jabatan.'-';
				$row['level'] = $list->level;
				$row['bagian'] = $list->bagian;
				$row['id_jabatan'] = $list->id_jabatan;
				$row['id_cabang'] = $list->id_cabang;
				$row['nama_cabang'] = $list->nama_cabang;
				$row['nama_jadwal_kerja'] = $list->nama_jadwal_kerja;
				$row['id_jadwal_kerja'] = $list->id_jadwal_kerja;
				$row['tgl_masuk'] = date_format(date_create($list->tgl_kerja),"d-m-Y");
				$row['no_ktp'] = $list->no_ktp;
				$row['no_npwp'] = $list->no_npwp;
				$row['nama_ibu'] = $list->nama_ibu;
				$row['telp_referensi'] = $list->telp_referensi;
				$row['pendidikan_terakhir'] = $list->pendidikan_terakhir;
				$row['lulus_dari'] = $list->lulus_dari;
				$row['alamat_ktp'] = $list->alamat_ktp;
				$row['status_karyawan'] = $list->status_karyawan;
				$row['tgl_evaluasi'] = $list->tgl_evaluasi != NULL ? date_format(date_create($list->tgl_evaluasi),"d-m-Y") : '';
				$row['tgl_resign'] = $list->tgl_resign != NULL ? date_format(date_create($list->tgl_resign),"d-m-Y") : '';
				$row['alasan_resign'] = $list->alasan_resign;
				$row['gaji_tetap'] = number_format($list->gaji_tetap,0,',','.');
				$row['insentif'] = number_format($list->insentif,0,',','.');
				$row['uang_makan'] = number_format($list->uang_makan,0,',','.');
				$row['uang_transport'] = number_format($list->uang_transport,0,',','.');
				$row['uang_hlibur'] = number_format($list->uang_hlibur,0,',','.');
				$row['uang_lembur'] = number_format($list->uang_lembur,0,',','.');
				$row['uang_shift'] = number_format($list->uang_shift,0,',','.');
				$row['bpjs_kesehatan'] = number_format($list->bpjs_kesehatan,0,',','.');
				$row['bpjs_tk'] = number_format($list->bpjs_tk,0,',','.');
				$row['bpjs_corporate'] = number_format($list->bpjs_corporate,0,',','.');
				$row['tunjangan_jabatan'] = number_format($list->tunjangan_jabatan,0,',','.');
				$row['tunjangan_str'] = number_format($list->tunjangan_str,0,',','.');
				$row['tunjangan_pph21'] = number_format($list->tunjangan_pph21,0,',','.');
				$row['pph21_persen_gaji'] = floatval($pph21_persen_gaji['isi_konfigurasi']);
				$row['pph21_ketentuan_gaji'] = intval($pph21_ketentuan_gaji['isi_konfigurasi']);

				$masa_kerja = date_diff(date_create($list->tgl_kerja),date_create(date("Y-m-d")));
				$row['masa_kerja'] = ($masa_kerja->y).' Thn, '.($masa_kerja->m).' Bln';
				$data[] = $row; 
			// }
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_account(){
		$cekData = $this->m_main->cekData('db_account','email',$_POST['email']);
		if(!$cekData){
			$data = [
				'id_jabatan' => $_POST['jabatan'],
				'id_cabang' => $_POST['cabang'],
				'id_jadwal_kerja' => $_POST['jadwal_kerja'],
				'kode' => $_POST['kode'],
				'nomor_induk' => $_POST['nomor_induk'],
				'no_ktp' => $_POST['nomor_ktp'],
				'no_npwp' => $_POST['nomor_npwp'],
				'nama_ibu' => $_POST['nama_ibu'],
				'nama' => $_POST['nama'],
				'gender' => $_POST['gender'],
				'tempat_lahir' => $_POST['tempat_lahir'],
				'tgl_lahir' => date_format(date_create($_POST['tgl_lahir']),"Y-m-d"),
				'telp' => $_POST['nohp'],
				'telp_referensi' => $_POST['nohp2'],
				'sisa_cuti' => $_POST['sisa_cuti'],
				'jam_perhari' => $_POST['jam_perhari'],
				'pendidikan_terakhir' => $_POST['pendidikan_terakhir'],
				'lulus_dari' => $_POST['lulus_dari'],
				'email' => $_POST['email'],
				'alamat' => $_POST['alamat'],
				'alamat_ktp' => $_POST['alamat2'],
				'nama_bank' => $_POST['nama_bank'],
				'nama_rek' => $_POST['nama_rek'],
				'no_rek' => $_POST['no_rek'],
				'level' => $_POST['level'],
				'bagian' => $_POST['bagian'],
				'status_karyawan' => $_POST['status_karyawan'],
				'alasan_resign' => $_POST['alasan_keluar'],
				'password' => password_hash('12345678', PASSWORD_DEFAULT),
				'tgl_kerja' => date_format(date_create($_POST['tgl_masuk']),"Y-m-d"),
				'tgl_evaluasi' => $_POST['tgl_evaluasi'] != '' ? date_format(date_create($_POST['tgl_evaluasi']),"Y-m-d") : NULL,
				'tgl_resign' => $_POST['tgl_keluar'] != '' ? date_format(date_create($_POST['tgl_keluar']),"Y-m-d") : NULL,
				'tgl_masuk' => '0000-00-00 00:00:00',
				'tgl_keluar' => '0000-00-00 00:00:00',
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
			];
			$this->m_main->createIN('db_account',$data);
		
			$output['message'] ="Data account berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Email sudah di gunakan, coba dengan yang lain!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function edit_account(){
		if(!empty($_POST['id_account'])){
			$cekData = $this->m_main->cekData('db_account','email',$_POST['email']);
			$getData = $this->m_main->getRow('db_account','id_account',$_POST['id_account']);
			if(!$cekData || ($_POST['email']==$getData['email'])){
				$data = [
					'id_jabatan' => $_POST['jabatan'],
					'id_cabang' => $_POST['cabang'],
					'id_jadwal_kerja' => $_POST['jadwal_kerja'],
					'kode' => $_POST['kode'],
					'nomor_induk' => $_POST['nomor_induk'],
					'no_ktp' => $_POST['nomor_ktp'],
					'no_npwp' => $_POST['nomor_npwp'],
					'nama_ibu' => $_POST['nama_ibu'],
					'nama' => $_POST['nama'],
					'gender' => $_POST['gender'],
					'tempat_lahir' => $_POST['tempat_lahir'],
					'tgl_lahir' => date_format(date_create($_POST['tgl_lahir']),"Y-m-d"),
					'telp' => $_POST['nohp'],
					'telp_referensi' => $_POST['nohp2'],
					'sisa_cuti' => $_POST['sisa_cuti'],
					'jam_perhari' => $_POST['jam_perhari'],
					'pendidikan_terakhir' => $_POST['pendidikan_terakhir'],
					'lulus_dari' => $_POST['lulus_dari'],
					'email' => $_POST['email'],
					'alamat' => $_POST['alamat'],
					'alamat_ktp' => $_POST['alamat2'],
					'nama_bank' => $_POST['nama_bank'],
					'nama_rek' => $_POST['nama_rek'],
					'no_rek' => $_POST['no_rek'],
					'level' => $_POST['level'],
					'bagian' => $_POST['bagian'],
					'status_karyawan' => $_POST['status_karyawan'],
					'alasan_resign' => $_POST['alasan_keluar'],
					'tgl_kerja' => date_format(date_create($_POST['tgl_masuk']),"Y-m-d"),
					'tgl_evaluasi' => $_POST['tgl_evaluasi'] != '' ? date_format(date_create($_POST['tgl_evaluasi']),"Y-m-d") : NULL,
					'tgl_resign' => $_POST['tgl_keluar'] != '' ? date_format(date_create($_POST['tgl_keluar']),"Y-m-d") : NULL,
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
				$output['message'] ="Data account berhasil di ubah!";
				$output['result'] = "success";
			}else{
				$output['message'] ="Email sudah di gunakan, coba dengan yang lain!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Data id account tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function edit_account_salary(){
		if(!empty($_POST['id_account'])){
			$cekData = $this->m_main->cekData('db_account','id_account',$_POST['id_account']);
			$data = [
				'gaji_tetap' => str_replace(".","",$_POST['gaji_tetap']),
				'insentif' => str_replace(".","",$_POST['insentif']),
				'uang_makan' => str_replace(".","",$_POST['uang_makan']),
				'uang_transport' => str_replace(".","",$_POST['uang_transport']),
				'uang_hlibur' => str_replace(".","",$_POST['uang_hlibur']),
				'uang_lembur' => str_replace(".","",$_POST['uang_lembur']),
				'uang_shift' => str_replace(".","",$_POST['uang_shift']),
				'tunjangan_jabatan' => str_replace(".","",$_POST['tunjangan_jabatan']),
				'tunjangan_str' => str_replace(".","",$_POST['tunjangan_str']),
				'tunjangan_pph21' => str_replace(".","",$_POST['tunjangan_pph21']),
				'bpjs_kesehatan' => str_replace(".","",$_POST['bpjs_kesehatan']),
				'bpjs_tk' => str_replace(".","",$_POST['bpjs_tk']),
				'bpjs_corporate' => str_replace(".","",$_POST['bpjs_corporate']),
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
			$output['message'] ="Data account salary berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id account tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_account(){
		if(!empty($_POST['id_account'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'tgl_keluar' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
			$output['message'] = "Account berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id account tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_account(){
		if(!empty($_POST['id_account'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'tgl_keluar' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_account','id_account',$_POST['id_account'],$data);
			$output['message'] = "Account berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id account tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_account(){
		if(!empty($_POST['id_account'])){
			$this->m_main->deleteIN('db_account','id_account',$_POST['id_account']);
			$output['message'] = "Account berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id account tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_account(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_JABATAN,2,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_JABATAN,2,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_JABATAN,2,4);
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
			$row['Nama'] = $list->nama_jabatan;
			$row['Keterangan'] = $list->keterangan;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$row['Aksi'] = $list->id_jabatan;
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
				'nama_jabatan' => $_POST['nama_jabatan'],
				'keterangan' => $_POST['keterangan'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$qry = $this->m_main->createIN('db_jabatan',$datax);
			$id_jabatan = $qry['result'];

			for($i=0; $i<$_POST['numb']; $i++){
				$level = $_POST['lvl'.$i];
				$status = explode(",",$level)[0] == 'true' ? 1 : 0;
				$id_level_submenu = explode(",",$level)[2];
				$id_level_aksi = explode(",",$level)[3];

				$cek = $this->m_auth->cekLevel($id_jabatan,$id_level_submenu,$id_level_aksi);
				if(!$cek){
					$data = [
						'id_jabatan' => $id_jabatan,
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
			
			$output['message'] ="Data jabatan berhasil di tambah!";
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
				'nama_jabatan' => $_POST['nama_jabatan'],
				'keterangan' => $_POST['keterangan'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jabatan','id_jabatan',$_POST['id_jabatan'],$datax);

			for($i=0; $i<$_POST['numb']; $i++){
				$level = $_POST['lvl'.$i];
				$status = explode(",",$level)[0] == 'true' ? 1 : 0;
				$id_jabatan = explode(",",$level)[1];
				$id_level_submenu = explode(",",$level)[2];
				$id_level_aksi = explode(",",$level)[3];
				
				$cek = $this->m_auth->cekLevel($id_jabatan,$id_level_submenu,$id_level_aksi);
				if(!$cek){
					$data = [
						'id_jabatan' => $id_jabatan,
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
			
			$output['message'] ="Data jabatan berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Terjadi kesalahan ketika menyimpan data!";
			$output['result'] = "error";
		}

        echo json_encode($output);
        exit();
	}
	
	public function remove_jabatan(){
		if(!empty($_POST['id_jabatan'])){
			if($_POST['id_jabatan'] == 1 || $_POST['id_jabatan'] == 2){
				$output['message'] = "Data jabatan tidak dapat dihapus!";
				$output['result'] = "error";
			}else{
				$data = [
					'status' => 0,
					'tgl_edit' => date("Y-m-d H:i:s"),
					'id_account' => ID_ACCOUNT,
				];
				$this->m_main->updateIN('db_jabatan','id_jabatan',$_POST['id_jabatan'],$data);
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
		if(!empty($_POST['id_jabatan'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jabatan','id_jabatan',$_POST['id_jabatan'],$data);
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
		if(!empty($_POST['id_jabatan'])){
			$this->m_main->deleteIN('db_jabatan','id_jabatan',$_POST['id_jabatan']);
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

	private function html_level($id_jabatan, $id_level_submenu, $id_level_aksi, $name, $nama_aksi, $check){
		$html = '<label class="mr-3"><input type="checkbox" class="mr-1"'.
				'name="'.$name.'" value="'.$id_jabatan.','.$id_level_submenu.','.$id_level_aksi.'"'.
				' '.$check.'>'.$nama_aksi.'</label>';
		return $html ;
	}

    //================= CABANG
	public function read_cabang(){
		$cabang = $this->m_main->getResultData('db_cabang','status IS NOT NULL','tgl_edit desc');
		$data = [];
		$no = 0;
		foreach ($cabang as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Cabang'] = $list->nama_cabang;
			$row['Kode'] = $list->kode_cabang;
			$row['PT'] = $list->nama_pt;
			$row['Alamat'] = $list->alamat_cabang;
			$row['SN'] = $list->sn_mesin;
			$row['Aksi'] = $list->id_cabang;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_cabang(){
		if(!empty($_POST['nama_cabang'])){
			$data = [
				'nama_cabang' => $_POST['nama_cabang'],
				'kode_cabang' => $_POST['kode_cabang'],
				'nama_pt' => $_POST['nama_pt'],
				'alamat_cabang' => $_POST['alamat_cabang'],
				'sn_mesin' => $_POST['sn_mesin'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->createIN('db_cabang',$data);
			$output['message'] ="Data cabang berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Nama cabang tidak boleh kosong!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_cabang(){
		if(!empty($_POST['id_cabang'])){
			$data = [
				'nama_cabang' => $_POST['nama_cabang'],
				'kode_cabang' => $_POST['kode_cabang'],
				'nama_pt' => $_POST['nama_pt'],
				'alamat_cabang' => $_POST['alamat_cabang'],
				'sn_mesin' => $_POST['sn_mesin'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$data);
			$output['message'] ="Data cabang berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function remove_cabang(){
		if(!empty($_POST['id_cabang'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$data);
			$output['message'] = "Cabang berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_cabang(){
		if(!empty($_POST['id_cabang'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_cabang','id_cabang',$_POST['id_cabang'],$data);
			$output['message'] = "Cabang berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_cabang(){
		if(!empty($_POST['id_cabang'])){
			$this->m_main->deleteIN('db_cabang','id_cabang',$_POST['id_cabang']);
			$output['message'] = "Cabang berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id cabang tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_cabang(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_JABATAN,4,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_JABATAN,4,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_JABATAN,4,4);
		echo json_encode($output);
	}
	
    //================= KEGIATAN
	public function read_kegiatan(){
		$kegiatan = $this->m_main->getResultData('db_kegiatan','status IS NOT NULL','tgl_edit desc');
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
		$output['tambah'] = $this->m_auth->cekAksi(ID_JABATAN,5,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_JABATAN,5,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_JABATAN,5,4);
		echo json_encode($output);
	}
}