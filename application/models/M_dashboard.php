<?php

class M_dashboard extends CI_Model {

    public function GetAccountOnline(){
        $query = $this->db->select('a.nama, a.email, if(a.foto != NULL, a.foto,"profile.jpg") as foto')
            ->from('account a')
            ->where('a.status',1)
            ->where('a.tgl_masuk > a.tgl_keluar')
            ->where('DATE(a.tgl_masuk)',date("Y-m-d"))
            ->order_by('a.tgl_masuk desc')
            ->get()->result();
        return $query;
    }
}