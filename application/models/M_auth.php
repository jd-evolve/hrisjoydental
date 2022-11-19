<?php

class M_auth extends CI_Model {

    public function GetAllMember(){
        $query = $this->db->select('a.nama as nama_member, a.gender, a.kode, a.nomor_induk, a.email, a.tempat_lahir, a.tgl_lahir, a.bagian, c.nama_kota, a.level,
            a.id_kota, a.id_posisi, a.nama_bank, a.no_rek, a.nama_rek, a.sisa_cuti, a.alamat, a.telp, a.status, a.id_account, a.tgl_mulai_kerja, b.nama_posisi')
            ->from('db_account a')
            ->join('db_posisi b','a.id_posisi = b.id_posisi')
            ->join('db_kota c','a.id_kota = c.id_kota')
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

    public function GetAccountOnline(){
        $query = $this->db->query("
            SELECT a.nama, a.email, b.nama_posisi, c.nama_kota, c.inisial_kota, if(a.foto != NULL, a.foto, 'profile.jpg') as foto 
            FROM db_account a 
            JOIN db_posisi b ON a.id_posisi = b.id_posisi 
            JOIN db_kota c ON a.id_kota = c.id_kota 
            WHERE a.status = 1 
            AND a.tgl_masuk > a.tgl_keluar 
            AND DATE(a.tgl_masuk) = '".date("Y-m-d")."' 
            ORDER BY a.tgl_masuk desc
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
}
