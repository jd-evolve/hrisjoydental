<?php

class M_auth extends CI_Model {

    public function GetAllMember(){
        $query = $this->db->select('a.nama as nama_member, a.gender, a.kode, a.nomor_induk, a.email, a.tempat_lahir, a.tgl_lahir, 
            a.id_kota, a.id_posisi, a.nama_bank, a.no_rek, a.nama_rek, a.sisa_cuti, a.alamat, a.telp, a.status, a.id_account, a.tgl_mulai_kerja, b.nama_posisi')
            ->from('db_account a')
            ->join('db_posisi b','a.id_posisi = b.id_posisi')
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
}
