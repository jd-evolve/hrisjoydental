<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekapdata extends CI_Controller {
        
    function __construct(){
        parent::__construct();
		$this->load->model('M_main', 'm_main');
		$this->load->model('M_auth', 'm_auth');
		define('EMAIL',$this->session->userdata('email'));
		define('ID_ACCOUNT',$this->session->userdata('id_account'));
		define('ID_POSISI',$this->session->userdata('id_posisi'));
		define('ID_CABANG',$this->session->userdata('id_cabang'));
    }

	public function read_rekapgaji(){
		$data = [];
		if($_POST['periode']){
			$gaji = $this->m_auth->GetLlistGaji_Rekap($_POST['periode'],$_POST['id_karyawan']);
			$no = 0;
			foreach ($gaji as $list) {
				//Uang Lembur
				$lembur_diluar_jk = $this->m_main->sumData(
					'db_lembur',
						'id_periode = '.$list->id_periode.' AND '.
						'id_karyawan = '.$list->id_karyawan.' AND '.
						'kategori = 1 AND '.
						'status = 2',
					'jumlah'
				);
				$lembur_range_jk = $this->m_main->sumData(
					'db_lembur',
						'id_periode = '.$list->id_periode.' AND '.
						'id_karyawan = '.$list->id_karyawan.' AND '.
						'kategori = 2 AND '.
						'status = 2',
					'jumlah'
				);
				$form_lembur = intval($lembur_range_jk['sum'] + $lembur_diluar_jk['sum']);
				$lembur = 0;
				if( $form_lembur > 0){
					$lembur = ($list->lembur + intval($lembur_diluar_jk['sum'])) - $form_lembur;
					$lembur = $lembur >= 0 ? $form_lembur : $list->lembur;
					$lembur = intval(($lembur/60) * $list->uang_lembur);
				}

				//Uang Makan & Transport
				$count_ijin_cuti = $this->m_main->countData(
					'db_ijincuti_list',
						'id_periode = '.$list->id_periode.' AND '.
						'id_karyawan = '.$list->id_karyawan.' AND '.
						'status = 2'
				);
				$uang_makan = $list->uang_makan * ($list->shift - intval($count_ijin_cuti['count']));
				$uang_transport = $list->uang_transport * ($list->shift - intval($count_ijin_cuti['count']));

				//Insentif Kehadiran
				$kehadiran = $this->m_main->countData(
					'db_scanlog_kehadiran',
						'id_periode = '.$list->id_periode.' AND '.
						'id_karyawan = '.$list->id_karyawan.' AND '.
						'(jum_terlambat > 0 OR jum_lupa_absen > 0)'
				);
				$insentif = $count_ijin_cuti['count'] > 0 || $kehadiran['count'] > 0 ? 0 : $list->insentif;

				//Tambahan Shift
				$bonus_shift = $this->m_main->getData(
					'db_scanlog_kehadiran',
						'id_periode = '.$list->id_periode.' AND '.
						'id_karyawan = '.$list->id_karyawan.' AND '.
						'bonus_shift > 0'
				);
				$tambahan_shift = $bonus_shift ? intval(($bonus_shift['shift_total'] - $list->jumlah_shift) * $list->uang_shift) : 0;

				//Keterlambatan & Pulang Awal
				$keterlambatan = intval(($list->terlambat) * ($list->uang_shift/$list->jam_perhari/60));
				$pulangawal = intval(($list->pulangawal) * ($list->uang_shift/$list->jam_perhari/60));

				//Transfer Beda Bank
				$default_bank = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','default_bank');
				$biaya_transfer = $this->m_main->getRow('db_konfigurasi','kode_konfigurasi','biaya_transfer');
				$tf_bedabank = $list->nama_bank != strtoupper($default_bank['isi_konfigurasi']) ? intval($biaya_transfer['isi_konfigurasi']) : 0;

				//BPJS Corporate
				$bpjs_corporate = $list->bpjs_corporate;

				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Periode'] = $list->ket_periode;
				$row['Karyawan'] = $list->karyawan;
				$row['NIK'] = $list->nomor_induk;
				$row['Email'] = $list->email;
				$row['Bagian'] = $list->bagian;
				$row['Jabatan'] = $list->jabatan;
				$row['Cabang'] = $list->nama_cabang;
				$row['Grade'] = '-';
				$row['Aksi'] = $list->id_karyawan;
				$row['no_rek'] = $list->no_rek;
				$row['nama_bank'] = $list->nama_bank;
				$row['nama_rek'] = $list->nama_rek;
				$row['bpjs_persen_kesehatan'] = $list->bpjs_persen_kesehatan;
				$row['bpjs_persen_tk'] = $list->bpjs_persen_tk;

				//PENERIMAAN
				$row['gaji_tetap'] = $list->gaji_tetap;
				$row['uang_makan'] = $uang_makan;
				$row['uang_transport'] = $uang_transport;
				$row['uang_lembur'] = $lembur;
				$row['insentif'] = $insentif;
				$row['tunjangan_jabatan'] = $list->tunjangan_jabatan;
				$row['tunjangan_str'] = $list->tunjangan_str;
				$row['tunjangan_pph21'] = $list->tunjangan_pph21;
				$row['dinas_luar'] = 0;
				$row['masuk_hari_libur'] = $list->uang_hlibur * $list->libur;
				$row['tambahan_shift'] = $tambahan_shift;
				$row['bonus_thr'] = 0;
				$row['bpjs_corporate'] = $bpjs_corporate;
				$row['lainnya_terima'] = 0;
				$penerimaan = 
					$row['gaji_tetap'] + 
					$row['uang_makan'] + 
					$row['uang_transport'] + 
					$row['uang_lembur'] +
					$row['insentif'] +
					$row['tunjangan_jabatan'] +
					$row['tunjangan_str'] +
					$row['tunjangan_pph21'] +
					$row['dinas_luar'] +
					$row['masuk_hari_libur'] +
					$row['tambahan_shift'] +
					$row['bonus_thr'] +
					$row['bpjs_corporate'] +
					$row['lainnya_terima'];
				$row['total_penerimaan'] = $penerimaan;

				//POTONGAN
				$row['bpjs_corporate_ded'] = $bpjs_corporate;
				$row['keterlambatan'] = $keterlambatan;
				$row['pulangawal'] = $pulangawal;
				$row['bpjs_kesehatan'] = $list->bpjs_kesehatan;
				$row['bpjs_tk'] = $list->bpjs_tk;
				$row['cicilan'] = 0;
				$row['biaya_transfer'] = $tf_bedabank;
				$row['pajak_pph21'] = $list->tunjangan_pph21;
				$row['lainnya_potong'] = 0;
				$potongan = 
					$row['bpjs_corporate_ded'] +
					$row['keterlambatan'] +
					$row['pulangawal'] +
					$row['bpjs_kesehatan'] +
					$row['bpjs_tk'] +
					$row['cicilan'] +
					$row['biaya_transfer'] +
					$row['pajak_pph21'] +
					$row['lainnya_potong'];
				$row['total_potongan'] = $potongan;

				$row['Total'] = intval($penerimaan - $potongan);
				$data[] = $row; 
			}
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekapijincuti(){
		$data = [];
		if($_POST['periode']){
			$ijincuti = $this->m_auth->GetLlistIjinCuti_Rekap($_POST['id_ijincuti'],$_POST['id_karyawan'],$_POST['periode'],$_POST['status']);
			$no = 0;
			foreach ($ijincuti as $list) {
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Periode'] = $list->ket_periode;
				$row['Awal'] = date_format(date_create($list->tgl_awal.' '.$list->jam_awal),"d-m-Y H:i");
				$row['Akhir'] = date_format(date_create($list->tgl_akhir.' '.$list->jam_akhir),"d-m-Y H:i");
				$row['Hari'] = $list->total_hari;
				$row['Jam'] = $list->total_menit;
				$row['IjinCuti'] = $list->nama_ijincuti;
				$row['Potong'] = floatval($list->potong_cuti);
				$row['Atasan'] = $list->atasan;
				$row['Karyawan'] = $list->karyawan;
				$row['Status'] = $list->status;
				$row['Aksi'] = $list->id_ijincuti_list;
				$data[] = $row; 
			}
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekaplembur(){
		$data = [];
		if($_POST['periode']){
			$lembur = $this->m_auth->GetLlistLembur_Rekap($_POST['periode'],$_POST['status'],$_POST['id_karyawan']);
			$no = 0;
			foreach ($lembur as $list) {
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Periode'] = $list->ket_periode;
				$row['Atasan'] = $list->atasan;
				$row['Karyawan'] = $list->karyawan;
				$row['Bagian'] = $list->bagian;
				$row['Jabatan'] = $list->jabatan;
				$row['Total'] = $list->total_lembur.' menit';
				$row['Status'] = $list->status;
				$row['Aksi'] = $list->id_periode;
				$row['id_karyawan'] = $list->id_karyawan;
				$row['id_atasan'] = $list->id_karyawan;
				$data[] = $row; 
			}
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekapketerlambatan(){
		$data = [];
		if($_POST['periode']){
			$terlambat = $this->m_auth->GetLlistTerlambat_Rekap($_POST['periode'],$_POST['status'],$_POST['id_karyawan']);
			$no = 0;
			foreach ($terlambat as $list) {
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Periode'] = $list->ket_periode;
				$row['Karyawan'] = $list->karyawan;
				$row['Bagian'] = $list->bagian;
				$row['Total'] = $list->terlambat.' menit';
				$row['Terlambat'] = $list->jum_terlambat.' hari';
				$row['Status'] = $list->jum_terlambat < 8 ? 1 : ($list->urut5x_terlambat == 1 ? 3 : 2);
				$data[] = $row; 
			}
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}

	public function read_rekaplupaabsen(){
		$data = [];
		if($_POST['periode']){
			$lupaabsen = $this->m_auth->GetLlistLupaAbsen_Rekap($_POST['periode'],$_POST['id_karyawan']);
			$no = 0;
			foreach ($lupaabsen as $list) {
				$no++;
				$row = [];
				$row['No'] = $no;
				$row['Periode'] = $list->ket_periode;
				$row['Karyawan'] = $list->karyawan;
				$row['Bagian'] = $list->bagian;
				$row['Lupa'] = $list->jum_lupa_absen.' hari';
				$data[] = $row; 
			}
		}
		$output = [ "data" => $data ];
		echo json_encode($output);
	}
}