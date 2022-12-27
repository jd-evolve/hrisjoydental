<?php

class M_auth extends CI_Model {

    public function GetAllAccount(){
        $query = $this->db->select('a.*, a.nama as nama_account, bpjs_tk, b.nama_posisi, c.nama_cabang, d.nama_jadwal_kerja')
            ->from('db_account a')
            ->join('db_posisi b','a.id_posisi = b.id_posisi')
            ->join('db_cabang c','a.id_cabang = c.id_cabang')
            ->join('db_jadwal_kerja d','a.id_jadwal_kerja = d.id_jadwal_kerja')
            ->order_by('a.tgl_edit','desc')
            ->get()->result();
        return $query;
    }

    public function GetLevelMenu(){
        $query = $this->db->select('*')
            ->from('db_level_menu')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }

    public function cekMenu($id_posisi,$id_menu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('c.id_level_menu',$id_menu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',1)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function GetLevelSubmenu(){
        $query = $this->db->select('*')
            ->from('db_level_submenu')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }
    
    public function cekSubmenu($id_posisi,$id_submenu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.id_level_submenu',$id_submenu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',1)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function cekAksi($id_posisi,$id_submenu,$id_aksi){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.id_level_submenu',$id_submenu)
            ->where('a.id_posisi',$id_posisi)
            ->where('a.id_level_aksi',$id_aksi)
            ->where('a.status',1)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return true;
        }else{
            return false;
        }
    }

    public function GetAllLevel(){
        $query = $this->db->select('*')
            ->from('db_posisi')
            ->order_by('tgl_edit','desc')
            ->get()->result();
        return $query;
    }

    public function cekLevel($id_posisi, $id_level_submenu, $id_level_aksi){
        $query = $this->db->select('id_level_akses')
            ->from('db_level_akses')
            ->where('id_posisi',$id_posisi)
            ->where('id_level_submenu',$id_level_submenu)
            ->where('id_level_aksi',$id_level_aksi)
            ->limit(1)
            ->get()->row_array();
            
        if($query != null){
            return $query;
        }else{
            return false;
        }
    }
    
    public function GetLevelSubmenuList($id_level_menu){
        $query = $this->db->select('*')
            ->from('db_level_submenu')
            ->where('id_level_menu',$id_level_menu)
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }
    
    public function GetLevelAksi(){
        $query = $this->db->select('*')
            ->from('db_level_aksi')
            ->where('status','1')
            ->order_by('urutan','asc')
            ->get()->result();
        return $query;
    }
    

    public function CekHakAkses($id_level_submenu,$id_level_aksi,$id_level){
        $query = $this->db->select('*')
            ->from('db_level_akses')
            ->where('id_posisi',$id_level)
            ->where('id_level_submenu',$id_level_submenu)
            ->where('id_level_aksi',$id_level_aksi)
            ->limit(1)
            ->get()->row_array();
        if($query != null){
            return $query;
        }else{
            return false;
        }
    }

    public function getCountScanKryn(){
        $query = $this->db->query("
            SELECT COUNT(x.id_karyawan) as total
            FROM (
                SELECT id_karyawan
                FROM db_scanlog
                GROUP BY id_karyawan
            ) x
        ")->row_array();
        return $query;
    }

    public function GetAccountOnline(){
        $query = $this->db->query("
            SELECT a.nama, a.email, b.nama_posisi, c.nama_cabang, c.kode_cabang, if(a.foto != NULL, a.foto, 'profile.jpg') as foto 
            FROM db_account a 
            JOIN db_posisi b ON a.id_posisi = b.id_posisi 
            JOIN db_cabang c ON a.id_cabang = c.id_cabang 
            WHERE a.status = 1 
            AND a.tgl_masuk > a.tgl_keluar 
            AND DATE(a.tgl_masuk) = '".date("Y-m-d")."' 
            ORDER BY a.tgl_masuk desc
        ")->result();
        return $query;
    }

    public function GetAllJamKerja(){
        $query = $this->db->query("
            SELECT *
            FROM db_jam_kerja
            WHERE status = 1
            GROUP BY tgl_input
        ")->result();
        return $query;
    }

    public function GetAllKegiatan(){
        $query = $this->db->query("
            SELECT *
            FROM db_kegiatan
            WHERE status = 1
            GROUP BY tgl_kegiatan
        ")->result();
        return $query;
    }
    
    public function GetListKegiatan($full_date){
        $query = $this->db->query("
            SELECT *
            FROM db_kegiatan
            WHERE status = 1
            AND tgl_kegiatan = '".$full_date."'
            ORDER BY tgl_input asc
        ")->result();
        return $query;
    }

    public function GetLlistIjinCuti_Rekap($id_ijincuti,$id_karyawan){
        if($id_ijincuti){
            $ijincuti = ' AND a.id_ijincuti = '.$id_ijincuti;
        }else{
            $ijincuti = '';
        }
        if($id_karyawan){
            $karyawan = ' AND a.id_karyawan = '.$id_karyawan;
        }else{
            $karyawan = '';
        }
        $query = $this->db->query("
            SELECT b.nama_ijincuti, c.nama as karyawan, c.bagian, a.id_ijincuti_list, a.potong_cuti, 
            a.tgl_awal, a.tgl_akhir, a.jam_awal, a.jam_akhir, a.total_hari, a.total_jam, a.status, a.tgl_input
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            JOIN db_account c ON a.id_karyawan = c.id_account
            WHERE a.status = 2
            ".$ijincuti."
            ".$karyawan."
            ORDER BY a.tgl_edit desc
        ")->result();
        return $query;
    }

    public function GetLlistIjinCuti_ACCPersonalia($id_account, $status){
        $stts = '';
        if($status == '3'){
            $stts = 'WHERE a.status = 3 AND a.id_personalia = '.$id_account;
        }else{
            $stts = 'WHERE a.status = '.$status;
        }
        $query = $this->db->query("
            SELECT b.nama_ijincuti, c.nama as karyawan, c.bagian, a.id_ijincuti_list, a.potong_cuti, a.status, a.tgl_input
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            JOIN db_account c ON a.id_karyawan = c.id_account
            ".$stts."
            ORDER BY a.tgl_edit desc
        ")->result();
        return $query;
    }
    
    public function GetLlistIjinCuti_ACCAtasan($id_account, $status){
        $stts = '';
        if($status == 'z'){
            $stts = 'AND (a.status = 1 OR a.status = 2)';
        }else{
            $stts = 'AND a.status = '.$status;
        }
        $query = $this->db->query("
            SELECT b.nama_ijincuti, c.nama as karyawan, c.bagian, a.id_ijincuti_list, a.status, a.tgl_input
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            JOIN db_account c ON a.id_karyawan = c.id_account
            WHERE a.id_atasan = '".$id_account."'
            ".$stts."
            ORDER BY a.tgl_edit desc
        ")->result();
        return $query;
    }

    public function GetLlistIjinCuti($id_account, $id_ijincuti, $status){
        $stts = '';
        if($status != 'x'){
            if($status == 'y'){
                $stts = 'AND (status = 0 OR status = 1)';
            }else{
                $stts = 'AND status = '.$status;
            }
        }
        $query = $this->db->query("
            SELECT *
            FROM db_ijincuti_list
            WHERE id_karyawan = '".$id_account."'
            AND id_ijincuti = '".$id_ijincuti."'
            ".$stts."
            ORDER BY tgl_edit desc
        ")->result();
        return $query;
    }

    public function GetAtasan(){
        $query = $this->db->query("
            SELECT id_account as id_atasan, nama as nama_atasan
            FROM db_account
            WHERE status = 1
            AND level > 1
            ORDER BY nama asc
        ")->result();
        return $query;
    }
    
    public function GetAktifKaryawan(){
        $query = $this->db->query("
            SELECT *
            FROM db_account
            WHERE status = 1
            ORDER BY nama asc
        ")->result();
        return $query;
    }
    
    public function onPeriode(){
        $query = $this->db->query("
            SELECT *
            FROM db_periode
            WHERE status_periode = 0
            ORDER BY tgl_input desc
            LIMIT 1
        ")->row_array();
        return $query;
    }

    public function GetLemburPeriode($id_periode){
        $query = $this->db->query("
            SELECT a.*, b.status_periode, b.keterangan as ket_periode
            FROM db_lembur a
            JOIN db_periode b ON a.id_periode = b.id_periode
            WHERE a.id_periode = '".$id_periode."'
            ORDER BY tgl_lembur desc
        ")->result();
        return $query;
    }

    public function GetLlistLembur_ACC($id_account, $status, $periode){
        $stts = '';
        if($status == 'z'){
            $stts = 'AND (a.status = 2 OR a.status = 3)';
        }else{
            $stts = 'AND a.status = '.$status;
        }

        $prde = '';
        if($periode == 'x'){
            $prde = '';
        }else{
            $prde = 'AND a.id_periode = '.$periode;
        }

        $query = $this->db->query("
            SELECT b.keterangan as ket_periode, c.nama as karyawan, c.bagian, b.status_periode as status, b.id_periode, a.id_karyawan, d.nama_posisi as jabatan, 
                SUM(IF(a.status != 3, a.jumlah, 0)) as total_lembur
            FROM db_lembur a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_posisi d ON c.id_posisi = d.id_posisi
            WHERE b.status_periode != 0
            AND a.id_atasan = '".$id_account."'
            ".$stts." ".$prde."
            GROUP BY a.id_karyawan
        ")->result();
        return $query;
    }

    public function GetLlistLembur_Rekap($id_periode, $status, $id_karyawan){
        if($id_karyawan){
            $karyawan = ' AND a.id_karyawan = '.$id_karyawan;
        }else{
            $karyawan = '';
        }

        if($status == 1){
            $status = ' AND a.status = 1';
        }else{
            $status = ' AND a.status != 1';
        }
        $query = $this->db->query("
            SELECT b.keterangan as ket_periode, c.nama as karyawan, e.nama as atasan, c.bagian, a.status, b.id_periode, a.id_karyawan, d.id_atasan, d.nama_posisi as jabatan, 
                SUM(IF(a.status != 3, a.jumlah, 0)) as total_lembur
            FROM db_lembur a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_posisi d ON c.id_posisi = d.id_posisi
            JOIN db_account e ON d.id_atasan = e.id_account
            WHERE a.id_periode = ".$id_periode."
            AND b.status_periode != 0
            ".$karyawan."
            ".$status."
            GROUP BY a.id_karyawan
        ")->result();
        return $query;
    }

    public function updateKeterlambatan($id_periode, $id_karyawan, $data){
        return $this->db
        ->where('id_periode', $id_periode)
        ->where('id_karyawan', $id_karyawan)
        ->update('db_keterlambatan', $data);
    }
}
