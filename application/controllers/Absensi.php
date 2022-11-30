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

	function read_periode(){
		$periode = $this->m_main->getResult('db_periode','status',1);
		$data = [];
		$no = 0;
		foreach ($periode as $list) {
			$no++;
			$row = [];
			$row['No'] = $no;
			$row['Awal'] = date_format(date_create($list->periode_awal),"d-m-Y");
			$row['Akhir'] = date_format(date_create($list->periode_akhir),"d-m-Y");
			$row['Shift'] = $list->jumlah_shift;
			$row['Aksi'] = $list->id_periode;
			$data[] = $row; 
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	function detail_scanlog(){
		$periode = $this->m_main->getRow('db_periode','id_periode',$_POST['id_periode']);
		$scan_count_kawryawan = $this->m_auth->getCountScanKryn();

		$harilibur = $this->m_main->getResult('db_hari_libur','id_periode',$_POST['id_periode']);
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

	function scanlog_karyawan(){
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
		$shift = 0;
		$libur = 0;
		foreach ($scanlog as $list) {
			$lembur = $lembur + intval($list->lembur);
			$terlambat = $terlambat + intval($list->terlambat);
			$shift = $shift + intval($list->shift);
			$libur = $libur + ($list->libur == 1 ? intval($list->shift) : 0);

			$row = [];
			$row['tanggal'] = date_format(date_create($list->tanggal),"d-m-Y");
			$row['jam_masuk'] = $list->jam_masuk == null ? '' : $list->jam_masuk;
			$row['jam_pulang'] = $list->jam_pulang == null ? '' : $list->jam_pulang;
			$row['lembur'] = $list->jam_masuk == null ? '' : $list->lembur;
			$row['terlambat'] = $list->jam_masuk == null ? '' : $list->terlambat;
			$row['shift'] = $list->jam_masuk == null ? '' : $list->shift;
			$row['libur'] = $list->libur == 1 ? 'Ya' : 'Tidak';
			$row['keterangan'] = $list->keterangan == null ? '' : $list->keterangan;
			$row['id_scanlog'] = $list->id_scanlog;
			$data[] = $row; 
		}

		$row = [];
		$row['tanggal'] = '';
		$row['jam_masuk'] = '';
		$row['jam_pulang'] = '';
		$row['lembur'] = $lembur;
		$row['terlambat'] = $terlambat;
		$row['shift'] = $shift;
		$row['libur'] = $libur;
		$row['keterangan'] = '';
		$row['id_scanlog'] = '';
		$data[] = $row; 

		echo json_encode($data);
		exit();
	}

	function edit_scanlog(){
		$data = [
			'jam_masuk' => $_POST['masuk'],
			'jam_pulang' => $_POST['pulang'],
			'lembur' => $_POST['lbr'],
			'terlambat' => $_POST['tlt'],
			'shift' => $_POST['sft'],
			'keterangan' => $_POST['ket'],
			'tgl_edit' => date("Y-m-d H:i:s"),
		];
		$this->m_main->updateIN('db_scanlog','id_scanlog',$_POST['id_scanlog'],$data);
		$output['message'] ="List scanlog berhasil di ubah!";
		$output['result'] = "success";
        echo json_encode($output);
        exit();
	}
    
	function add_scanlog(){
		if (isset($_FILES["file_scanlog"]["name"])) {
			//insert data periode
			$tgl_awal = date_format(date_create($_POST['tgl_awal']),"Y-m-d");
			$tgl_akhir = date_format(date_create($_POST['tgl_akhir']),"Y-m-d");
			$total_hari = $_POST['total_hari'];
			$periode = [
				'periode_awal' => $tgl_awal,
				'periode_akhir' => $tgl_akhir,
				'jumlah_shift' => $total_hari,
				'tgl_input' => date("Y-m-d H:i:s"),
				'tgl_edit' => date("Y-m-d H:i:s"),
				'status' => 1,
				'id_account' => ID_ACCOUNT,
			];
			$prd = $this->m_main->createIN('db_periode',$periode);
			$id_periode = $prd['result'];

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
					for($i=0; $i<count($date_range); $i++){
						$id_hari = date_format(date_create($date_range[$i]),"w");
						$jdwk = $this->m_main->getResultData(
							'db_jadwal_kerja_list',
							'id_jadwal_kerja = '.$account['id_jadwal_kerja'].' AND id_hari = '.$id_hari.' AND status = 1',
							'urutan asc'
						);
						if(count($jdwk)>0){
							$next = false;
							$lpp = 0;
							foreach($jdwk as $list_jdwk){
								$lpp = $lpp+1;
								$jk = $this->m_main->getRow('db_jam_kerja','id_jam_kerja', $list_jdwk->id_jam_kerja);
								if($jk){
									$idx_tgl = date_format(date_create($date_range[$i]),"Ymd").$account['kode'];
									if(!empty($scanlist[$idx_tgl]['tgl'])){
										$cabang = $this->m_main->getRow('db_cabang','sn_mesin',$scanlist[$idx_tgl]['sn']);
										//jam masuk dan pulang kerja
										$jm = $jk['jam_masuk'];
										$sb_jm = date('H:i:s', strtotime("-".$jk['sb_jm']." minutes", strtotime($jm)));
										$st_jm = date('H:i:s', strtotime("+".$jk['st_jm']." minutes", strtotime($jm)));
										$jp = $jk['jam_pulang'];
										$sb_jp = date('H:i:s', strtotime("-".$jk['sb_jp']." minutes", strtotime($jp)));
										$st_jp = date('H:i:s', strtotime("+".$jk['st_jp']." minutes", strtotime($jp)));

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
												$sb_jpx = strtotime($sb_jp);
												$st_jpx = strtotime($st_jp);
												
												if($jamscanx>$sb_jmx && $jamscanx<$st_jmx){
													$jmy = true;
													$jmx = strtotime($jm);
													$lembur = 0;
													if($jamscanx<=$jmx){
														//lembur pagi or tepat waktu
														$lembur += intval(($jmx - $jamscanx) / 60);
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
														$lembur += intval(($jamscanx - $jpx) / 60);
													}
													$jam_pulang = $jamscan[$x];
												}

												if($loop==count($jamscan)){
													if($jmy && $jpy){
														if(!$next){
															$next = true;
															$hdkey = date_format(date_create($date_range[$i]),"Ymd");
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
																'keterangan' => !empty($harilibur[$hdkey]['ket']) ? $harilibur[$hdkey]['ket'] : NULL,
																'libur' => !empty($harilibur[$hdkey]['ket']) ? 1 : ($id_hari==0?1:0),
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
				}
			}
			$output['message'] = "Scanlog berhasil di buat!";
			$output['result'] = "success";
		}else{
			$output['message'] ="Data file tidak tersedia!";
			$output['result'] = "error";
		}
		echo json_encode($output);
		exit();
	}

	private function NullScan($id_periode,$account,$date_range,$id_hari,$harilibur){
		$hdkey = date_format(date_create($date_range),"Ymd");							
		$datax = [
			'id_periode' => $id_periode,
			'id_karyawan' => $account,
			'id_cabang' => NULL,
			'tanggal' => date_format(date_create($date_range),"Y-m-d"),
			'jam_masuk' => NULL,
			'jam_pulang' => NULL,
			'lembur' => 0,
			'terlambat' => 0,
			'pulangawal' => 0,
			'shift' => 0,
			'keterangan' => !empty($harilibur[$hdkey]['ket']) ? $harilibur[$hdkey]['ket'] : ($id_hari==0?'Hari Minggu':NULL),
			'libur' => !empty($harilibur[$hdkey]['ket']) ? 1 : ($id_hari==0?1:0),
			'tgl_input' => date("Y-m-d H:i:s"),
			'tgl_edit' => date("Y-m-d H:i:s"),
			'status' => 1,
		];
		$this->m_main->createIN('db_scanlog',$datax);
	}
}