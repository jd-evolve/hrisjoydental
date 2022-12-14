<?php

class M_auth extends CI_Model {

    public function GetAllAccount(){
        $query = $this->db->select('a.*, a.nama as nama_account, bpjs_tk, b.nama_jabatan, c.nama_cabang, d.nama_jadwal_kerja')
            ->from('db_account a')
            ->join('db_jabatan b','a.id_jabatan = b.id_jabatan')
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

    public function cekMenu($id_jabatan,$id_menu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('c.id_level_menu',$id_menu)
            ->where('a.id_jabatan',$id_jabatan)
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
    
    public function cekSubmenu($id_jabatan,$id_submenu){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.id_level_submenu',$id_submenu)
            ->where('a.id_jabatan',$id_jabatan)
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

    public function cekAksi($id_jabatan,$id_submenu,$id_aksi){
        $query = $this->db->select('*')
            ->from('db_level_akses a')
            ->join('db_level_submenu b','a.id_level_submenu = b.id_level_submenu')
            ->join('db_level_menu c','b.id_level_menu = c.id_level_menu')
            ->join('db_level_aksi d','a.id_level_aksi = d.id_level_aksi')
            ->where('b.id_level_submenu',$id_submenu)
            ->where('a.id_jabatan',$id_jabatan)
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
        $query = $this->db->query("
            SELECT a.*, b.limit_penginapan, b.limit_uang_makan, b.insentif_perjalanan
            FROM db_jabatan a
            JOIN db_dinas_insentif b ON a.id_jabatan = b.id_jabatan
            ORDER BY a.tgl_edit desc
        ")->result();
        return $query;
    }

    public function cekLevel($id_jabatan, $id_level_submenu, $id_level_aksi){
        $query = $this->db->select('id_level_akses')
            ->from('db_level_akses')
            ->where('id_jabatan',$id_jabatan)
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
            ->where('id_jabatan',$id_level)
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
            SELECT a.nama, a.email, b.nama_jabatan, c.nama_cabang, c.kode_cabang, if(a.foto != NULL, a.foto, 'profile.jpg') as foto 
            FROM db_account a 
            JOIN db_jabatan b ON a.id_jabatan = b.id_jabatan 
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

    public function GetLlistIjinCuti_Rekap($id_ijincuti,$id_karyawan,$id_periode,$status){
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
        if($status == 1){
            $status = ' AND (a.status = 0 OR a.status = 1)';
        }else{
            $status = ' AND a.status = '.$status;
        }
        $query = $this->db->query("
            SELECT a.*, b.keterangan as ket_periode, c.nama_ijincuti, f.nama as atasan, d.nama as karyawan, d.bagian
            FROM db_ijincuti_list a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_ijincuti c ON a.id_ijincuti = c.id_ijincuti
            JOIN db_account d ON a.id_karyawan = d.id_account
            JOIN db_jabatan e ON d.id_jabatan = e.id_jabatan
            JOIN db_account f ON e.id_atasan = f.id_account
            WHERE a.id_periode = ".$id_periode."
            ".$ijincuti."
            ".$karyawan."
            ".$status."
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
            SELECT b.nama_ijincuti, c.nama as karyawan, c.bagian, a.id_ijincuti_list, a.potong_cuti, a.status, a.tgl_input, d.status_periode
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_periode d ON a.id_periode = d.id_periode
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
            AND id_account != 1
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
            SELECT b.keterangan as ket_periode, c.nama as karyawan, c.bagian, b.status_periode as status, b.id_periode, a.id_karyawan, d.nama_jabatan as jabatan, 
                SUM(IF(a.status != 3, a.jumlah, 0)) as total_lembur
            FROM db_lembur a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_jabatan d ON c.id_jabatan = d.id_jabatan
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
            SELECT b.keterangan as ket_periode, c.nama as karyawan, e.nama as atasan, c.bagian, a.status, b.id_periode, a.id_karyawan, d.id_atasan, d.nama_jabatan as jabatan, 
                SUM(IF(a.status != 3, a.jumlah, 0)) as total_lembur
            FROM db_lembur a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_jabatan d ON c.id_jabatan = d.id_jabatan
            JOIN db_account e ON d.id_atasan = e.id_account
            WHERE a.id_periode = ".$id_periode."
            AND b.status_periode != 0
            ".$karyawan."
            ".$status."
            GROUP BY a.id_karyawan
        ")->result();
        return $query;
    }

    public function updateRekScanlog($id_periode, $id_karyawan, $data){
        return $this->db
        ->where('id_periode', $id_periode)
        ->where('id_karyawan', $id_karyawan)
        ->update('db_scanlog_kehadiran', $data);
    }

    public function GetLlistTerlambat_Rekap($id_periode, $status, $id_karyawan){
        if($id_karyawan){
            $karyawan = ' AND a.id_karyawan = '.$id_karyawan;
        }else{
            $karyawan = '';
        }

        switch($status) {
            case 0:
                $kategori = "";
                break;
            case 1:
                $kategori = "AND a.jum_terlambat < 8";
                break;
            case 2:
                $kategori = "AND a.jum_terlambat > 7 AND a.urut5x_terlambat = 0";
                break;
            case 3:
                $kategori = "AND a.urut5x_terlambat = 1";
                break;
        }

        $query = $this->db->query("
            SELECT a.*, b.keterangan as ket_periode, c.nama as karyawan, c.bagian
            FROM db_scanlog_kehadiran a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_jabatan d ON c.id_jabatan = d.id_jabatan
            WHERE a.id_periode = ".$id_periode."
            AND a.terlambat != 0
            ".$karyawan."
            ".$kategori."
            ORDER BY a.id_karyawan asc
        ")->result();
        return $query;
    }

    public function GetLlistLupaAbsen_Rekap($id_periode, $id_karyawan){
        if($id_karyawan){
            $karyawan = ' AND a.id_karyawan = '.$id_karyawan;
        }else{
            $karyawan = '';
        }

        $query = $this->db->query("
            SELECT a.*, b.keterangan as ket_periode, c.nama as karyawan, c.bagian
            FROM db_scanlog_kehadiran a
            JOIN db_periode b ON a.id_periode = b.id_periode
            JOIN db_account c ON a.id_karyawan = c.id_account
            JOIN db_jabatan d ON c.id_jabatan = d.id_jabatan
            WHERE a.id_periode = ".$id_periode."
            AND a.jum_lupa_absen != 0
            ".$karyawan."
            ORDER BY a.id_karyawan asc
        ")->result();
        return $query;
    }

    public function cekScanIjinCutiShift($id_periode, $id_karyawan, $date_range){
        $query = $this->db->query("
            SELECT b.nama_ijincuti
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            WHERE a.status = 2
            AND a.ket_ijincuti = 0
            AND a.id_periode = ".$id_periode."
            AND a.id_karyawan = ".$id_karyawan."
            AND a.tgl_awal >= '".$date_range."' 
            AND a.tgl_akhir <= '".$date_range."'
        ")->row_array();
        return $query;
    }

    public function cekScanIjinCutiJam($id_periode, $id_karyawan, $date_range){
        $query = $this->db->query("
            SELECT a.total_menit, a.ket_ijincuti, b.nama_ijincuti
            FROM db_ijincuti_list a
            JOIN db_ijincuti b ON a.id_ijincuti = b.id_ijincuti
            WHERE a.status = 2
            AND a.ket_ijincuti > 0
            AND a.id_periode = ".$id_periode."
            AND a.id_karyawan = ".$id_karyawan."
            AND a.tgl_awal = '".$date_range."'
        ")->row_array();
        return $query;
    }

    public function GetLlistGaji_Rekap($id_periode, $id_karyawan){
        if($id_karyawan){
            $karyawan = ' AND x.id_karyawan = '.$id_karyawan;
        }else{
            $karyawan = '';
        }

        $query = $this->db->query("
            SELECT 
                z.id_periode, z.gaji_tetap, z.insentif, z.uang_makan, z.uang_transport,
                z.uang_hlibur, z.uang_lembur, z.uang_shift, z.tunjangan_jabatan,
                z.tunjangan_str, z.tunjangan_pph21, z.bpjs_kesehatan, z.bpjs_tk, 
                z.bpjs_corporate, z.bpjs_persen_kesehatan, z.bpjs_persen_tk, 
                z.nama_bank, z.nama_rek, z.no_rek,
                IF(a.lembur is NULL, 0, a.lembur) as lembur,
                IF(a.terlambat is NULL, 0, a.terlambat) as terlambat,
                IF(a.pulangawal is NULL, 0, a.pulangawal) as pulangawal,
                IF(a.shift is NULL, 0, a.shift) as shift,
                IF(a.libur is NULL, 0, a.libur) as libur,
                x.nama as karyawan, x.id_account as id_karyawan, x.bagian, 
                x.nomor_induk, x.email, x.jam_perhari, x.nomor_induk, x.email,
                d.id_cabang, d.nama_cabang, b.keterangan as ket_periode, 
                b.jumlah_shift, c.nama_jabatan as jabatan
            FROM db_penggajian z
            LEFT JOIN db_account x ON z.id_karyawan = x.id_account
            LEFT JOIN (
                SELECT id_scanlog, id_periode, id_karyawan,
                    SUM(lembur) as lembur, SUM(terlambat) as terlambat, SUM(pulangawal) as pulangawal,
                    SUM(shift) as shift, SUM(IF(libur=1, shift, 0)) as libur
                FROM db_scanlog
                GROUP BY id_periode, id_karyawan
            ) a ON z.id_karyawan = a.id_karyawan
            LEFT JOIN db_periode b ON z.id_periode = b.id_periode
            LEFT JOIN db_jabatan c ON x.id_jabatan = c.id_jabatan
            LEFT JOIN db_cabang d ON x.id_cabang = d.id_cabang
            WHERE z.status = 1
            AND z.id_periode = ".$id_periode."
            ".$karyawan."
            ORDER BY x.id_account asc
        ")->result();
        return $query;
    }

    public function getDinasLuar(){
        $this->db->simple_query('SET SESSION group_concat_max_len=15000');
        $this->db->simple_query('SET @x:=0');
        $query = $this->db->query('
            SELECT a.*, group_concat(concat((@x:=@x+1), ". ",c.nama), "   ") as member, @x:=0
            FROM db_dinas_diluar a
            JOIN db_dinas_member b ON a.id_dinas_diluar = b.id_dinas_diluar
            JOIN db_account c ON b.id_account = c.id_account
            GROUP BY b.id_dinas_diluar
            ORDER BY a.tgl_edit desc
        ')->result();
        return $query;
    }
}
