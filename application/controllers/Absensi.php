<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Absensi extends CI_Controller {
    
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

    //================= SCAN LOG
	public function read_periode(){
		$periode = $this->m_main->getResultData('db_periode','status = 1','tgl_edit desc');
		$data = [];
		$no = 0;
		foreach ($periode as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Awal'] = date_format(date_create($list->periode_awal),"d-m-Y");
			$row['Akhir'] = date_format(date_create($list->periode_akhir),"d-m-Y");
			$row['Shift'] = $list->jumlah_shift;
			$row['Ket'] = $list->keterangan;
			$row['Status'] = $list->status_periode;
			$row['Aksi'] = $list->id_periode;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_periode(){
		$tgl_awal = date_format(date_create($_POST['tgl_awal']),"Y-m-d");
		$tgl_akhir = date_format(date_create($_POST['tgl_akhir']),"Y-m-d");
		$total_hari = $_POST['total_hari'];
		$keterangan = $_POST['keterangan'];
		
		$cekData = $this->m_main->cekData('db_periode','status_periode',0);
		if(!$cekData){
			$periode = [
				'periode_awal' => $tgl_awal,
				'periode_akhir' => $tgl_akhir,
				'jumlah_shift' => $total_hari,
				'keterangan' => $keterangan,
				'status_periode' => 0,
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->createIN('db_periode',$periode);
			$output['message'] = "Data periode berhasil ditambah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Masih terdapat status 'process' harap selesaikan terlebih dahulu!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function edit_periode(){
		$tgl_awal = date_format(date_create($_POST['tgl_awal']),"Y-m-d");
		$tgl_akhir = date_format(date_create($_POST['tgl_akhir']),"Y-m-d");
		$total_hari = $_POST['total_hari'];
		$keterangan = $_POST['keterangan'];
		$periode = [
			'periode_awal' => $tgl_awal,
			'periode_akhir' => $tgl_akhir,
			'jumlah_shift' => $total_hari,
			'keterangan' => $keterangan,
			'tgl_edit' => date("Y-m-d H:i:s"),
			'id_account' => ID_ACCOUNT,
		];
		$this->m_main->updateIN('db_periode','id_periode',$_POST['id_periode'],$periode);
		$output['message'] = "Data periode berhasil diubah!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
	}
	
	public function stop_periode(){
		if(!empty($_POST['id_periode'])){
			$cekData = $this->m_main->cekData('db_periode','status_periode',1);
			if(!$cekData){
				$data = [
					'status_periode' => 1,
					'tgl_edit' => date("Y-m-d H:i:s"),
					'id_account' => ID_ACCOUNT,
				];
				$this->m_main->updateIN('db_periode','id_periode',$_POST['id_periode'],$data);
				$output['message'] = "Proses periode berhasil di hentikan dan status menjadi 'waiting'!";
				$output['result'] = "success";
			}else{
				$output['message'] = "Masih terdapat status 'waiting' harap selesaikan terlebih dahulu!";
				$output['result'] = "error";
			}
		}else{
			$output['message'] = "Data id periode tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function detail_scanlog(){
		$periode = $this->m_main->getRow('db_periode','id_periode',$_POST['id_periode']);
		$scan_count_kawryawan = $this->m_auth->getCountScanKryn();

		$harilibur = $this->m_main->getResultData('db_hari_libur','id_periode = '.$_POST['id_periode'],'tgl_hari_libur asc');
		$data_libur = [];
		$no = 0;
		foreach ($harilibur as $list) {
			$no++;
			$row = [];
			$row['no'] = $no;
			$row['tanggal'] = date_format(date_create($list->tgl_hari_libur),"d-m-Y");
			$row['keterangan'] = $list->keterangan;
			$data_libur[] = $row;
		}

		$output = array(
			"periode_awal" => date_format(date_create($periode['periode_awal']),"d-m-Y"),
			"periode_akhir" => date_format(date_create($periode['periode_akhir']),"d-m-Y"),
			"jumlah_shift" => $periode['jumlah_shift'],
			"karyawan" => $scan_count_kawryawan['total'],
			"dataLibur" => $data_libur,
		);
		echo json_encode($output);
		exit();
	}

	public function scanlog_karyawan(){
		$scanlog = $this->m_main->getResultData(
			('db_scanlog'),
			(
				'id_periode = '.$_POST['id_periode'].' AND '.
				'id_karyawan = '.$_POST['id_karyawan'].' AND '.
				'status = 1'
			),
			('tanggal asc')
		);
		$data = [];
		$lembur = 0;
		$terlambat = 0;
		$pulangawal = 0;
		$shift = 0;
		$bonus = 0;
		$ijincuti = 0;
		$libur = 0;
		$lupa = 0;
		$jumterlambat = 0;
		$urutterlambat = 0;
		foreach ($scanlog as $list) {
			$cekIC = $this->m_auth->cekScanIjinCutiShift($_POST['id_periode'], $_POST['id_karyawan'], $list->tanggal);

			$ijincuti = $ijincuti + ($cekIC ? 1 : 0);
			$lembur = $lembur + intval($list->lembur);
			$terlambat = $terlambat + intval($list->terlambat);
			$pulangawal = $pulangawal + intval($list->pulangawal);
			$shift = $shift + intval($list->shift);
			$bonus = $bonus + (intval($list->shift) == 2 ? 1 : 0);
			$libur = $libur + ($list->libur == 1 ? intval($list->shift) : 0);
			$lupa = $lupa + ($list->lupa == 1 ? intval($list->shift) : 0);

			if(intval($list->shift) > 0){
				$jumterlambat = $jumterlambat + ($list->terlambat > 0 ? 1 : 0);
				if($urutterlambat <= 4){
					if($list->terlambat > 0){
						$urutterlambat = $urutterlambat + 1;
					}else{
						$urutterlambat = 0;
					}
				}
			}

			$row = [];
			$row['tanggal'] = date_format(date_create($list->tanggal),"d-m-Y");
			$row['jam_masuk'] = $list->jam_masuk == null ? '' : $list->jam_masuk;
			$row['jam_pulang'] = $list->jam_pulang == null ? '' : $list->jam_pulang;
			$row['lembur'] = $list->jam_masuk == null ? '' : $list->lembur;
			$row['terlambat'] = $list->jam_masuk == null ? '' : $list->terlambat;
			$row['pulangawal'] = $list->jam_masuk == null ? '' : $list->pulangawal;
			$row['shift'] = $list->shift == 0 ? '' : $list->shift;
			$row['ijincuti'] = $cekIC ? 1 : 0;
			$row['libur'] = $list->libur == 1 ? '<i class="text-danger fas fa-check-circle">' : '';
			$row['lupa'] = $list->lupa == 1 ? '<i class="text-default fas fa-exclamation-triangle">' : '';
			$row['keterangan'] = $list->keterangan == null ? '' : $list->keterangan;
			$row['id_scanlog'] = $list->id_scanlog;
			$data[] = $row; 
		}

		//Triger update keterlambatan, lupa, bonus shift
		if($jumterlambat > 0 || $lupa > 0 || $bonus > 0){
			$scandata = $this->m_main->getData('db_scanlog_kehadiran','id_periode = '.$_POST['id_periode'].' AND id_karyawan = '.$_POST['id_karyawan']);
			if($scandata){
				$dtscn = [
					'shift_total' => $shift,
					'bonus_shift' => $bonus,
					'terlambat' => $terlambat,
					'jum_terlambat' => $jumterlambat,
					'urut5x_terlambat' => $urutterlambat > 4 ? 1 : 0,
					'jum_lupa_absen' => $lupa,
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 1,
				];
				$this->m_auth->updateRekScanlog($_POST['id_periode'],$_POST['id_karyawan'],$dtscn);
			}else{
				$dtscn = [
					'id_periode' => $_POST['id_periode'],
					'id_karyawan' => $_POST['id_karyawan'],
					'shift_total' => $shift,
					'bonus_shift' => $bonus,
					'terlambat' => $terlambat,
					'jum_terlambat' => $jumterlambat,
					'urut5x_terlambat' => $urutterlambat > 4 ? 1 : 0,
					'jum_lupa_absen' => $lupa,
					'tgl_input' => date("Y-m-d H:i:s"),
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 1,
				];
				$this->m_main->createIN('db_scanlog_kehadiran',$dtscn);
			}
		}else{
			$scandata = $this->m_main->getData('db_scanlog_kehadiran','id_periode = '.$_POST['id_periode'].' AND id_karyawan = '.$_POST['id_karyawan']);
			if($scandata){
				$dtscn = [
					'shift_total' => $shift,
					'bonus_shift' => 0,
					'terlambat' => 0,
					'jum_terlambat' => 0,
					'urut5x_terlambat' => 0,
					'jum_lupa_absen' => 0,
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 0,
				];
				$this->m_auth->updateRekScanlog($_POST['id_periode'],$_POST['id_karyawan'],$dtscn);
			}
		}

		$row = [];
		$row['tanggal'] = '';
		$row['jam_masuk'] = '';
		$row['jam_pulang'] = '';
		$row['lembur'] = $lembur;
		$row['terlambat'] = $terlambat;
		$row['pulangawal'] = $pulangawal;
		$row['shift'] = $shift;
		$row['ijincuti'] = $ijincuti;
		$row['libur'] = $libur;
		$row['lupa'] = $lupa > 0 ? 'Ya' : 'Tidak';
		$row['jumterlambat'] = $jumterlambat;
		$row['urutterlambat'] = $urutterlambat > 4 ? 'Ya' : 'Tidak';
		$row['keterangan'] = '';
		$row['id_scanlog'] = '';
		$data[] = $row; 

		echo json_encode($data);
		exit();
	}

	public function edit_scanlog(){
		$data = [
			'jam_masuk' => $_POST['masuk'] ? $_POST['masuk'] : null,
			'jam_pulang' => $_POST['pulang'] ? $_POST['pulang'] : null,
			'lembur' => $_POST['lbr'],
			'terlambat' => $_POST['tlt'],
			'pulangawal' => $_POST['pla'],
			'shift' => $_POST['sft'],
			'lupa' => $_POST['lupa'],
			'keterangan' => $_POST['ket'],
			'tgl_edit' => date("Y-m-d H:i:s"),
		];
		$this->m_main->updateIN('db_scanlog','id_scanlog',$_POST['id_scanlog'],$data);
		$output['message'] = "List scanlog berhasil di ubah!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
	}

	public function add_scanlog(){
		if (isset($_FILES["file_scanlog"]["name"])) {
			//get data periode
			$id_periode = $_POST['id_periode'];
			$this->m_main->updateIN('db_periode','id_periode',$id_periode,['status_periode' => 2]);
			$periode = $this->m_main->getRow('db_periode','id_periode',$id_periode);
			$tgl_awal = $periode['periode_awal'];
			$tgl_akhir = $periode['periode_akhir'];

			//simpan data penggajian karyawan
			$karyawan = $this->m_main->getResultData('db_account','status = 1','nomor_induk asc');
			$bpjs_dtwan_kesehatan = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','bpjs_dtwan_kesehatan');
			$bpjs_dtwan_tk = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','bpjs_dtwan_tk');
			foreach($karyawan as $list){
				$dtpgj = [
					'id_periode' => $id_periode,
					'id_karyawan' => $list->id_account,
					'gaji_tetap' => $list->gaji_tetap,
					'insentif' => $list->insentif,
					'uang_makan' => $list->uang_makan,
					'uang_transport' => $list->uang_transport,
					'uang_hlibur' => $list->uang_hlibur,
					'uang_lembur' => $list->uang_lembur,
					'uang_shift' => $list->uang_shift,
					'tunjangan_jabatan' => $list->tunjangan_jabatan,
					'tunjangan_str' => $list->tunjangan_str,
					'tunjangan_pph21' => $list->tunjangan_pph21,
					'bpjs_kesehatan' => $list->bpjs_kesehatan,
					'bpjs_tk' => $list->bpjs_tk,
					'bpjs_corporate' => $list->bpjs_corporate,
					'bpjs_persen_kesehatan' => $bpjs_dtwan_kesehatan['isi_konfigurasi'],
					'bpjs_persen_tk' => $bpjs_dtwan_tk['isi_konfigurasi'],
					'tgl_input' => date("Y-m-d H:i:s"),
					'tgl_edit' => date("Y-m-d H:i:s"),
					'status' => 1,
					'id_account' => ID_ACCOUNT,
				];
				$this->m_main->createIN('db_penggajian',$dtpgj);
			}

			//insert data hari libur
			$harilibur = [];
			$hari_libur = json_decode($_POST['hari_libur']);
			foreach($hari_libur as $list){
				$libur = [
					'id_periode' => $id_periode,
					'tgl_hari_libur' => date_format(date_create($list->tgl_libur),"Y-m-d"),
					'keterangan' => $list->ket_libur,
				];
				$this->m_main->createIN('db_hari_libur',$libur);

				$keydate = date_format(date_create($list->tgl_libur),"Ymd");
				if(!array_key_exists($keydate, $harilibur)){
					$harilibur[$keydate]['ket'] = $list->ket_libur;
				}
			}

			//insert scanlog dari excel
			$path = $_FILES["file_scanlog"]["tmp_name"];
        	$extension = explode('.', $_FILES['file_scanlog']['name'])[1];
			if('csv' == $extension){     
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			}else if('xls' == $extension){     
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			}else{
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx(); 
			}

			$spreadsheet = $reader->load($path);
			$sheet = $spreadsheet->getActiveSheet()->toArray();
			$scanlist = [];
			$scankryn = [];
			foreach($sheet as $key => $val) {
				if($key != 0){
					$jam = $val[2];
					$sn = $val[5];
					$pin = substr(strval($val[3]),-3);
					$tgl = date_format(date_create($val[1]),"Y-m-d");
					$idx = date_format(date_create($val[1]),"Ymd").$pin;
					if($tgl && $jam){
						if(!array_key_exists($idx, $scanlist)){
							$scanlist[$idx]['tgl'] = $tgl;
							$scanlist[$idx]['jam'] = $jam;
							$scanlist[$idx]['pin'] = $pin;
							$scanlist[$idx]['sn'] = $sn;
						}else{
							$scanlist[$idx]['jam'] .= ('-'.$jam);
						}

						if(!array_key_exists($pin, $scankryn)){
							$scankryn[$pin]['pin'] = $pin;
						}
					}
				}
			}

			#tgl_awal
			$day1 = date_format(date_create($tgl_awal),"d");
			$month1 = date_format(date_create($tgl_awal),"m");
			$year1 = date_format(date_create($tgl_awal),"Y");
			#tgl_akhir
			$day2 = date_format(date_create($tgl_akhir),"d");
			$month2 = date_format(date_create($tgl_akhir),"m");
			$year2 = date_format(date_create($tgl_akhir),"Y");

			$date_range = array();
			$jumtgl1 = cal_days_in_month(CAL_GREGORIAN,$month1,$year1);
			for($i=$day1; $i<=$jumtgl1; $i++){
				$tgl = date('d-m-Y', mktime(0,0,0,$month1,$i,$year1));
				array_push($date_range,$tgl);
			}
			$jumtgl2 = $day2;
			for($i=1; $i<=$jumtgl2; $i++){
				$tgl = date('d-m-Y', mktime(0,0,0,$month2,$i,$year2));
				array_push($date_range,$tgl);
			}

			foreach($scankryn as $list){
				$account = $this->m_main->getRow('db_account','kode',$list['pin']);
				if($account){
					$hitungterlambat = 0;
					$hitungshift = 0;
					$hitungbonus = 0;
					$jumterlambat = 0;
					$urutterlambat = 0;
					for($i=0; $i<count($date_range); $i++){
						$id_hari = date_format(date_create($date_range[$i]),"w");
						$jdwk = $this->m_main->getResultData(
							'db_jadwal_kerja_list',
							'id_jadwal_kerja = '.$account['id_jadwal_kerja'].' AND id_hari = '.$id_hari,
							'urutan asc'
						);
						if(count($jdwk)>0){
							$next = false;
							$lpp = 0;
							foreach($jdwk as $list_jdwk){
								$lpp = $lpp+1;
								$jk = $this->m_main->getData('db_jam_kerja','id_jam_kerja = '. $list_jdwk->id_jam_kerja. ' AND status = 1');
								if($jk){
									$idx_tgl = date_format(date_create($date_range[$i]),"Ymd").$account['kode'];
									if(!empty($scanlist[$idx_tgl]['tgl'])){
										$cabang = $this->m_main->getRow('db_cabang','sn_mesin',$scanlist[$idx_tgl]['sn']);
										//jam masuk dan pulang kerja
										$jm = $jk['jam_masuk'];
										$sb_jm = date('H:i:s', strtotime("-".$jk['sb_jm']." minutes", strtotime($jm)));
										$st_jm = date('H:i:s', strtotime("+".$jk['st_jm']." minutes", strtotime($jm)));
										$dl_jm = date('H:i:s', strtotime("-".$jk['dl_jm']." minutes", strtotime($jm)));
										$jp = $jk['jam_pulang'];
										$sb_jp = date('H:i:s', strtotime("-".$jk['sb_jp']." minutes", strtotime($jp)));
										$st_jp = date('H:i:s', strtotime("+".$jk['st_jp']." minutes", strtotime($jp)));
										$dl_jp = date('H:i:s', strtotime("+".$jk['dl_jp']." minutes", strtotime($jp)));

										$jamscan = explode("-",$scanlist[$idx_tgl]['jam']);
										if(count($jamscan)>1){
											$loop = 0;
											$jmy = false;
											$jpy = false;
											$terlambat = 0;
											$pulangawal = 0;
											$pulangawal = 0;
											for($x=0; $x<count($jamscan); $x++){
												$loop = $loop+1;
												$jamscanx = strtotime($jamscan[$x]);
												$sb_jmx = strtotime($sb_jm);
												$st_jmx = strtotime($st_jm);
												$dl_jmx = strtotime($dl_jm);
												$sb_jpx = strtotime($sb_jp);
												$st_jpx = strtotime($st_jp);
												$dl_jpx = strtotime($dl_jp);
												
												if($jamscanx>$sb_jmx && $jamscanx<$st_jmx){
													$jmy = true;
													$jmx = strtotime($jm);
													$jmx_dl = strtotime($jm);
													$lembur = 0;
													if($jamscanx<=$jmx){
														//lembur pagi or tepat waktu
														if($jamscanx<=$dl_jmx){
															$lembur += intval(($jmx - $jamscanx) / 60);
														}else{
															$lembur += 0;
														}
													}else if($jamscanx>$jmx){
														//terlambat
														$terlambat = intval(($jamscanx - $jmx) / 60);
													}
													$jam_masuk = $jamscan[$x];
												}

												if($jamscanx>$sb_jpx && $jamscanx<$st_jpx){
													$jpy = true;
													$jpx = strtotime($jp);
													if($jamscanx<$jpx){
														//pulang awal
														$pulangawal = intval(($jpx - $jamscanx) / 60);
													}else if($jamscanx>$jpx){
														//lembur sore or tepat waktu
														if($jamscanx>$dl_jpx){
															$lembur += intval(($jamscanx - $jpx) / 60);
														}else{
															$lembur += 0;
														}
													}
													$jam_pulang = $jamscan[$x];
												}

												if($loop==count($jamscan)){
													if($jmy && $jpy){
														if(!$next){
															//Konfigurasi Ijin/Cuti
															$next = true;
															$hdkey = date_format(date_create($date_range[$i]),"Ymd");
															$cekIC = $this->m_auth->cekScanIjinCutiJam($id_periode, $account['id_account'], date_format(date_create($date_range[$i]),"Y-m-d"));
															if($cekIC){
																if($cekIC['ket_ijincuti'] == '1'){
																	$terlambat = $terlambat - intval($cekIC['total_menit']);
																}else if($cekIC['ket_ijincuti'] == '2'){
																	$pulangawal = $pulangawal - intval($cekIC['total_menit']);
																}
																$terlambat = $terlambat < 0 ? 0 : $terlambat;
																$pulangawal = $pulangawal < 0 ? 0 : $pulangawal;
															}
															$keterangan = $cekIC ? $cekIC['nama_ijincuti'] : (!empty($harilibur[$hdkey]['ket']) ? $harilibur[$hdkey]['ket'] : NULL);

															//Cek keterlambatan
															if($jk['dihitung'] > 0){
																$hitungterlambat = $hitungterlambat + intval($terlambat);
																$jumterlambat = $jumterlambat + ($terlambat > 0 ? 1 : 0);
																if($urutterlambat <= 4){
																	if($terlambat > 0){
																		$urutterlambat = $urutterlambat + 1;
																	}else{
																		$urutterlambat = 0;
																	}
																}
															}

															//Hitung shift dan bonus
															$hitungshift = $hitungshift + intval($jk['dihitung']);
															$hitungbonus = $hitungbonus + (intval($jk['dihitung']) == 2 ? 1 : 0);
															
															//Pembulatan keterlambatan dan pulang awal
															$dt_keterlambatan = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','keterlambatan');
															$dt_pulang_awal = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','pulang_awal');
															$pembulat_terlambat = intval($dt_keterlambatan['isi_konfigurasi']);
															$pembulat_pulang_awal = intval($dt_pulang_awal['isi_konfigurasi']);
															if($pembulat_terlambat > 0 && $terlambat > 0){
																$terlambat = ceil($terlambat/$pembulat_terlambat)*$pembulat_terlambat;
															}
															if($pembulat_pulang_awal > 0 && $pulangawal > 0){
																$pulangawal = ceil($pulangawal/$pembulat_pulang_awal)*$pembulat_pulang_awal;
															}

															//Simpan data scanlog
															$datax = [
																'id_periode' => $id_periode,
																'id_karyawan' => $account['id_account'],
																'id_cabang' => $cabang['id_cabang'],
																'tanggal' => date_format(date_create($date_range[$i]),"Y-m-d"),
																'jam_masuk' => $jam_masuk,
																'jam_pulang' => $jam_pulang,
																'lembur' => $lembur,
																'terlambat' => $terlambat,
																'pulangawal' => $pulangawal,
																'shift' => $jk['dihitung'],
																'keterangan' => $keterangan,
																'libur' => !empty($harilibur[$hdkey]['ket']) ? 1 : ($id_hari==0?1:0),
																'lupa' => 0,
																'tgl_input' => date("Y-m-d H:i:s"),
																'tgl_edit' => date("Y-m-d H:i:s"),
																'status' => 1,
															];
															$this->m_main->createIN('db_scanlog',$datax);
															$jmy = false;
															$jpy = false;
															$terlambat = 0;
															$pulangawal = 0;
															$pulangawal = 0;
														}
													}else{ 
														if(!$next && count($jdwk) == $lpp){
															$this->NullScan($id_periode,$account['id_account'],$date_range[$i],$id_hari,$harilibur); 
														}
													}
												}
											}
										}else{ $this->NullScan($id_periode,$account['id_account'],$date_range[$i],$id_hari,$harilibur); }
									}else{ $this->NullScan($id_periode,$account['id_account'],$date_range[$i],$id_hari,$harilibur); }
								}else{ $this->NullScan($id_periode,$account['id_account'],$date_range[$i],$id_hari,$harilibur); }
							}
						}else{ $this->NullScan($id_periode,$account['id_account'],$date_range[$i],$id_hari,$harilibur); }
					}
					//Simpan data keterlambatan
					if($jumterlambat > 0){
						$dtrlmbt = [
							'id_periode' => $id_periode,
							'id_karyawan' => $account['id_account'],
							'shift_total' => $hitungshift,
							'bonus_shift' => $hitungbonus,
							'terlambat' => $hitungterlambat,
							'jum_terlambat' => $jumterlambat,
							'urut5x_terlambat' => $urutterlambat > 4 ? 1 : 0,
							'jum_lupa_absen' => 0,
							'tgl_input' => date("Y-m-d H:i:s"),
							'tgl_edit' => date("Y-m-d H:i:s"),
							'status' => 1,
						];
						$this->m_main->createIN('db_scanlog_kehadiran',$dtrlmbt);
					}
				}
			}
			$output['message'] = "Scanlog berhasil di buat!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data file tidak tersedia!";
			$output['result'] = "error";
		}
		echo json_encode($output);
		exit();
	}

	private function NullScan($id_periode,$id_karyawan,$date_range,$id_hari,$harilibur){
		$cekIC = $this->m_auth->cekScanIjinCutiShift($id_periode, $id_karyawan, date_format(date_create($date_range),"Y-m-d"));
		$hdkey = date_format(date_create($date_range),"Ymd");
		$datax = [
			'id_periode' => $id_periode,
			'id_karyawan' => $id_karyawan,
			'id_cabang' => NULL,
			'tanggal' => date_format(date_create($date_range),"Y-m-d"),
			'jam_masuk' => NULL,
			'jam_pulang' => NULL,
			'lembur' => 0,
			'terlambat' => 0,
			'pulangawal' => 0,
			'shift' => $cekIC ? 1 : 0,
			'keterangan' => $cekIC ? $cekIC['nama_ijincuti'] : (!empty($harilibur[$hdkey]['ket']) ? $harilibur[$hdkey]['ket'] : ($id_hari==0?'Hari Minggu':NULL)),
			'libur' => !empty($harilibur[$hdkey]['ket']) ? 1 : ($id_hari==0?1:0),
			'tgl_input' => date("Y-m-d H:i:s"),
			'tgl_edit' => date("Y-m-d H:i:s"),
			'status' => 1,
		];
		$this->m_main->createIN('db_scanlog',$datax);
	}

	public function cek_form_pengajuan(){
		$ceklembur = $this->m_main->countData('db_lembur','id_periode = '.$_POST['id_periode'].' AND status = 1');
		$cekijincuti = $this->m_main->countData('db_ijincuti_list','id_periode = '.$_POST['id_periode'].' AND (status = 0 OR status = 1)');
		if($ceklembur['count']){
			$output['val'] = "ada-lembur";
		}else if($cekijincuti['count']){
			$output['val'] = "ada-ijincuti";
		}else{
			$output['val'] = "null";
		}
		echo json_encode($output);
		exit();
	}
	
    //================= JAM KERJA
	public function read_jamkerja(){
		$jamkerja = $this->m_main->getResultData('db_jam_kerja','id_jam_kerja IS NOT NULL','tgl_edit desc');
		$data = [];
		$no = 0;
		foreach ($jamkerja as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Nama'] = $list->nama_jam_kerja;
			$row['Keterangan'] = $list->keterangan;
			$row['Masuk'] = $list->jam_masuk;
			$row['Pulang'] = $list->jam_pulang;
			$row['Dihitung'] = $list->dihitung;
			$row['sb_jm'] = $list->sb_jm;
			$row['st_jm'] = $list->st_jm;
			$row['dl_jm'] = $list->dl_jm;
			$row['sb_jp'] = $list->sb_jp;
			$row['st_jp'] = $list->st_jp;
			$row['dl_jp'] = $list->dl_jp;
			$row['Aksi'] = $list->id_jam_kerja;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_jamkerja(){
		$data = [
			'nama_jam_kerja' => $_POST['nama'],
			'keterangan' => $_POST['keterangan'],
			'jam_masuk' => $_POST['masuk'],
			'jam_pulang' => $_POST['pulang'],
			'dihitung' => $_POST['dihitung'],
			'sb_jm' => $_POST['sb_jm'],
			'st_jm' => $_POST['st_jm'],
			'dl_jm' => $_POST['dl_jm'],
			'sb_jp' => $_POST['sb_jp'],
			'st_jp' => $_POST['st_jp'],
			'dl_jp' => $_POST['dl_jp'],
			'tgl_input' => date("Y-m-d H:i:s"),
			'tgl_edit' => date("Y-m-d H:i:s"),
			'status' => 1,
			'id_account' => ID_ACCOUNT,
		];
		$this->m_main->createIN('db_jam_kerja',$data);
		$output['message'] = "Data jam kerja berhasil ditambah!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
	}
	
	public function edit_jamkerja(){
		if(!empty($_POST['id_jam_kerja'])){
			$data = [
				'nama_jam_kerja' => $_POST['nama'],
				'keterangan' => $_POST['keterangan'],
				'jam_masuk' => $_POST['masuk'],
				'jam_pulang' => $_POST['pulang'],
				'dihitung' => $_POST['dihitung'],
				'sb_jm' => $_POST['sb_jm'],
				'st_jm' => $_POST['st_jm'],
				'dl_jm' => $_POST['dl_jm'],
				'sb_jp' => $_POST['sb_jp'],
				'st_jp' => $_POST['st_jp'],
				'dl_jp' => $_POST['dl_jp'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jam_kerja','id_jam_kerja',$_POST['id_jam_kerja'],$data);
			$output['message'] = "Data jam kerja berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jam kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function remove_jamkerja(){
		if(!empty($_POST['id_jam_kerja'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jam_kerja','id_jam_kerja',$_POST['id_jam_kerja'],$data);
			$output['message'] = "Jam kerja berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jam kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_jamkerja(){
		if(!empty($_POST['id_jam_kerja'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jam_kerja','id_jam_kerja',$_POST['id_jam_kerja'],$data);
			$output['message'] = "Jam kerja berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jam kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_jamkerja(){
		if(!empty($_POST['id_jam_kerja'])){
			$this->m_main->deleteIN('db_jam_kerja','id_jam_kerja',$_POST['id_jam_kerja']);
			$output['message'] = "Jam kerja berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jam kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_jamkerja(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_POSISI,17,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_POSISI,17,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_POSISI,17,4);
		echo json_encode($output);
	}
	
    //================= JADWAL KERJA
	public function read_jadwalkerja(){
		$jadwalkerja = $this->m_main->getResultData('db_jadwal_kerja','id_jadwal_kerja IS NOT NULL','tgl_edit desc');
		$data = [];
		$no = 0;
		foreach ($jadwalkerja as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Nama'] = $list->nama_jadwal_kerja;
			$row['Keterangan'] = $list->keterangan;
			$row['Aksi'] = $list->id_jadwal_kerja;
			$row['Status'] = $list->status == 1 ? 'aktif-' : 'hapus-';
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function list_jadwalkerja(){
		$jdwk_list = $this->m_main->getResultData(
			'db_jadwal_kerja_list',
			'id_jadwal_kerja = '.$_POST['id_jadwal_kerja'],
			'id_hari asc'
		);
		$data = [];
		if($jdwk_list){
			foreach($jdwk_list as $jdwk){
				if($jdwk->libur != 1){
					$idx = 'jk'.$jdwk->id_hari.'-'.$jdwk->urutan;
				}else{
					$idx = 'lbr-'.$jdwk->id_hari;
				}
				$row = [];
				$row['libur'] = $jdwk->libur;
				$row['id'] = $idx;
				$row['id_jk'] = $jdwk->id_jam_kerja;
				$data[] = $row; 
			}
		}
		echo json_encode($data);
	}

	public function edit_add_jadwalkerja(){
		$data_list = json_decode($_POST['list']);
		if($_POST['id_jadwal_kerja'] == null){
			$jdwk = [
				'nama_jadwal_kerja' => $_POST['nama'],
				'keterangan' => $_POST['keterangan'],
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$idjdwk = $this->m_main->createIN('db_jadwal_kerja',$jdwk);
			$id_jadwal_kerja = $idjdwk['result'];

			foreach($data_list as $list){
				$list_jdwk = [
					'id_jadwal_kerja' => $id_jadwal_kerja,
					'id_hari' => $list->id_hari,
					'id_jam_kerja' => $list->id_jam_kerja,
					'libur' => $list->libur,
					'urutan' => $list->urutan,
				];
				$this->m_main->createIN('db_jadwal_kerja_list',$list_jdwk);
			}

			$output['message'] = "Jadwal kerja berhasil di tambah!";
			$output['result'] = "success";
		}
		else{
			$id_jadwal_kerja = $_POST['id_jadwal_kerja'];
			$this->m_main->deleteIN('db_jadwal_kerja_list','id_jadwal_kerja',$id_jadwal_kerja);
			
			$jdwk = [
				'nama_jadwal_kerja' => $_POST['nama'],
				'keterangan' => $_POST['keterangan'],
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jadwal_kerja','id_jadwal_kerja',$id_jadwal_kerja,$jdwk);

			foreach($data_list as $list){
				$list_jdwk = [
					'id_jadwal_kerja' => $id_jadwal_kerja,
					'id_hari' => $list->id_hari,
					'id_jam_kerja' => $list->id_jam_kerja,
					'libur' => $list->libur,
					'urutan' => $list->urutan,
				];
				$this->m_main->createIN('db_jadwal_kerja_list',$list_jdwk);
			}
			$output['message'] = "Jadwal kerja berhasil di ubah";
			$output['result'] = "success";
		}
        echo json_encode($output);
        exit();
	}

	public function remove_jadwalkerja(){
		if(!empty($_POST['id_jadwal_kerja'])){
			$data = [
				'status' => 0,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jadwal_kerja','id_jadwal_kerja',$_POST['id_jadwal_kerja'],$data);
			$output['message'] = "Jadwal kerja berhasil di hapus!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jadwal kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function restore_jadwalkerja(){
		if(!empty($_POST['id_jadwal_kerja'])){
			$data = [
				'status' => 1,
				'tgl_edit' => date("Y-m-d H:i:s"),
				'id_account' => ID_ACCOUNT,
			];
			$this->m_main->updateIN('db_jadwal_kerja','id_jadwal_kerja',$_POST['id_jadwal_kerja'],$data);
			$output['message'] = "Jadwal kerja berhasil di pulihkan!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jadwal kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
	
	public function delete_jadwalkerja(){
		if(!empty($_POST['id_jadwal_kerja'])){
			$this->m_main->deleteIN('db_jadwal_kerja','id_jadwal_kerja',$_POST['id_jadwal_kerja']);
			$output['message'] = "Jadwal kerja berhasil di hapus permanen!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id jadwal kerja tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

	public function level_jadwalkerja(){
		$output['tambah'] = $this->m_auth->cekAksi(ID_POSISI,18,2);
		$output['ubah'] = $this->m_auth->cekAksi(ID_POSISI,18,3);
		$output['hapus'] = $this->m_auth->cekAksi(ID_POSISI,18,4);
		echo json_encode($output);
	}
	
    //================= JADWAL KERJA
	public function read_lembur(){
		$lembur = $this->m_auth->GetLemburPeriode($_POST['id_periode']);
		$data = [];
		$no = 0;
		foreach ($lembur as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Tanggal'] = date_format(date_create($list->tgl_lembur),"d-m-Y");
			$row['Waktu'] = date_format(date_create($list->jam_mulai),"H:i").'-'.date_format(date_create($list->jam_selesai),"H:i");
			$row['Mulai'] = date_format(date_create($list->jam_mulai),"H:i");
			$row['Selesai'] = date_format(date_create($list->jam_selesai),"H:i");
			$row['Jumlah'] = $list->jumlah;
			$row['Kategori'] = $list->kategori;
			$row['Keterangan'] = $list->keterangan;
			$row['Ket_periode'] = $list->ket_periode;
			$row['Status'] = $list->status;
			$row['Alasan'] = $list->alasan_ditolak;
			$row['Aksi'] = $list->id_lembur;
			$row['st_periode'] = $list->status_periode;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function add_lembur(){
		$atasan = $this->m_main->getRow('db_posisi','id_posisi',ID_POSISI);
		$data = [
			'id_periode' => $_POST['id_periode'],
			'id_karyawan' => ID_ACCOUNT,
			'id_atasan' => $atasan['id_atasan'],
			'kategori' => $_POST['kategori'],
			'tgl_lembur' => date_format(date_create($_POST['tgl_lembur']),"Y-m-d"),
			'jam_mulai' => $_POST['jam_mulai'],
			'jam_selesai' => $_POST['jam_selesai'],
			'jumlah' => $_POST['jumlah'],
			'keterangan' => $_POST['keterangan'],
			'tgl_input' => date("Y-m-d H:i:s"),
			'tgl_edit' => date("Y-m-d H:i:s"),
			'status' => 1
		];
		$this->m_main->createIN('db_lembur',$data);
		$output['message'] = "Form lembur berhasil diajukan!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
	}
	
	public function edit_lembur(){
		if(!empty($_POST['id_lembur'])){
			$data = [
				'kategori' => $_POST['kategori'],
				'tgl_lembur' => date_format(date_create($_POST['tgl_lembur']),"Y-m-d"),
				'jam_mulai' => $_POST['jam_mulai'],
				'jam_selesai' => $_POST['jam_selesai'],
				'jumlah' => $_POST['jumlah'],
				'keterangan' => $_POST['keterangan'],
				'tgl_edit' => date("Y-m-d H:i:s"),
			];
			$this->m_main->updateIN('db_lembur','id_lembur',$_POST['id_lembur'],$data);
			$output['message'] = "Form lembur berhasil di ubah!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data id form lembur tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}

    //================= LEMBUR
	public function read_acclembur(){
		$lembur = $this->m_auth->GetLlistLembur_ACC(ID_ACCOUNT,$_POST['status'],$_POST['periode']);
		$data = [];
		$no = 0;
		foreach ($lembur as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Periode'] = $list->ket_periode;
			$row['Karyawan'] = $list->karyawan;
			$row['Bagian'] = $list->bagian;
			$row['Jabatan'] = $list->jabatan;
			$row['Total'] = $list->total_lembur.' menit';
			$row['Status'] = $list->status;
			$row['Aksi'] = $list->id_periode;
			$row['id_karyawan'] = $list->id_karyawan;
			$row['id_atasan'] = ID_ACCOUNT;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function karyawan_lembur(){
		$listlembur = $this->m_main->getResultData(
			'db_lembur',
			('id_periode = '.$_POST['id_periode'].' AND id_karyawan = '.$_POST['id_karyawan']),
			'tgl_lembur asc'
		);
		$data = [];
		foreach ($listlembur as $list) {
			$row = [];
			$row['tanggal'] = date_format(date_create($list->tgl_lembur),"d-m-Y");
			$row['jm_mulai'] = date_format(date_create($list->jam_mulai),"H:i");
			$row['jm_selesai'] = date_format(date_create($list->jam_selesai),"H:i");
			$row['jumlah'] = $list->jumlah;
			$row['kategori'] = $list->kategori;
			$row['keterangan'] = $list->keterangan;
			$row['id_lembur'] = $list->id_lembur;
			$row['status'] = $list->status;
			$row['alasan'] = $list->alasan_ditolak;
			$data[] = $row;
		}
		echo json_encode($data);
	}

	public function acc_lembur(){
		if(!empty($_POST['count_lembur'])){
			for($i=0; $i<$_POST['count_lembur']; $i++){
				$data = [];
				$data = [
					'kategori' => $_POST['kategori'.$i],
					'jam_mulai' => $_POST['mulai'.$i],
					'jam_selesai' => $_POST['selesai'.$i],
					'jumlah' => $_POST['jumlah'.$i],
					'keterangan' => $_POST['keterangan'.$i],
					'status' => $_POST['status'.$i],
					'alasan_ditolak' => $_POST['alasan'.$i],
					'tgl_edit' => date("Y-m-d H:i:s"),
				];
				$this->m_main->updateIN('db_lembur','id_lembur',$_POST['id_lembur'.$i],$data);
			}

			$output['message'] = "Pengajuan lembur telah disetujui!";
			$output['result'] = "success";
		}else{
			$output['message'] = "Data form lembur tidak tersedia!";
			$output['result'] = "error";
		}
        echo json_encode($output);
        exit();
	}
}