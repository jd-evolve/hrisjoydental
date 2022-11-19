<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'menu/error_404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'home/login';
$route['logout'] = 'home/logout';
$route['forgot'] = 'home/forgot';
$route['newpassword'] = 'home/newpassword';

$route['dashboard'] = 'menu/dashboard';
$route['profil'] = 'menu/profil';
$route['member'] = 'menu/member';
$route['jabatan'] = 'menu/jabatan';
$route['kota-klinik'] = 'menu/kota_klinik';
$route['kegiatan-pengumuman'] = 'menu/kegiatan_pengumuman';

$route['acc-atasan'] = 'menu/acc_atasan';
$route['acc-personalia'] = 'menu/acc_personalia';
$route['rekap-ijincuti'] = 'menu/rekap_ijincuti';
$route['cuti-tahunan'] = 'menu/cuti_tahunan';
$route['cuti-menikah'] = 'menu/cuti_menikah';
$route['cuti-melahirkan'] = 'menu/cuti_melahirkan';
$route['ijin-pribadi'] = 'menu/ijin_pribadi';
$route['ijin-duka'] = 'menu/ijin_duka';
$route['ijin-dinas'] = 'menu/ijin_dinas';
$route['konfigurasi'] = 'menu/konfigurasi';