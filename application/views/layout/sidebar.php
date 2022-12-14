<div class="sidebar">
    <div class="sidebar-background"></div>
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="<?= base_url() ?>assets/img/photo/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collaps" aria-expanded="true">
                        <span>
                            <?= strlen($account['nama']) > 18 ?  substr($account['nama'],0,18).'..' : $account['nama'] ?>
                            <span class="user-level"><?= strlen($account['email']) > 20 ?  substr($account['email'],0,20).'..' : $account['email'] ?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collaps">
                        <ul class="nav">
                            <li>
                                <a href="<?= base_url('profil') ?>">
                                    <span class="link-collapse">Profil Saya</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('logout') ?>">
                                    <span class="link-collapse">Keluar</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php
                $ijincuti = array(
                    'acc-atasan',
                    'acc-personalia',
                    'cuti-tahunan',
                    'cuti-menikah',
                    'cuti-melahirkan',
                    'ijin-pribadi',
                    'ijin-duka',
                    'ijin-sakit',
                );

                $pengaturan = array(
                    'konfigurasi',
                );

                $masterdata = array(
                    'account',
                    'jabatan',
                    'cabang-klinik',
                    'kegiatan-pengumuman',
                );

                $absensi = array(
                    'acc-lembur',
                    'form-lembur',
                    'data-scanlog',
                    'jam-kerja',
                    'jadwal-kerja',
                );

                $rekapdata = array(
                    'rekap-gaji',
                    'rekap-ijincuti',
                    'rekap-lembur',
                    'rekap-keterlambatan',
                    'rekap-lupaabsen',
                );

                $dinasluar = array(
                    'dinasluar-pengajuan',
                    'dinasluar-insentif',
                );

                $uri_path = $this->uri->segment(1);
            ?> 

            <ul class="nav">
                <li  <?= $this->uri->segment(1) == 'dashboard' ? 'class="nav-item active"' : 'class="nav-item" ' ?>>
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                    
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Menu</h4>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_absensi'] ? 'gone' : '' ?><?= in_array($uri_path, $absensi) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#absensi">
                        <i class="fas fa-user-clock"></i>
                        <p>Absensi</p>
                        <span class="caret"></span>
                    </a>
                    <div id="absensi" <?= in_array($uri_path, $absensi) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['acc-lembur'] ? 'gone' : '' ?> <?= $uri_path == "acc-lembur"? 'active' : '' ?>">
                                <a href="<?= base_url('acc-lembur') ?>">
                                    <span class="sub-item">ACC Lembur</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['form-lembur'] ? 'gone' : '' ?> <?= $uri_path == "form-lembur"? 'active' : '' ?>">
                                <a href="<?= base_url('form-lembur') ?>">
                                    <span class="sub-item">Form Lembur</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['data-scanlog'] ? 'gone' : '' ?> <?= $uri_path == "data-scanlog"? 'active' : '' ?>">
                                <a href="<?= base_url('data-scanlog') ?>">
                                    <span class="sub-item">Data Scanlog</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['jam-kerja'] ? 'gone' : '' ?> <?= $uri_path == "jam-kerja"? 'active' : '' ?>">
                                <a href="<?= base_url('jam-kerja') ?>">
                                    <span class="sub-item">Jam Kerja</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['jadwal-kerja'] ? 'gone' : '' ?> <?= $uri_path == "jadwal-kerja"? 'active' : '' ?>">
                                <a href="<?= base_url('jadwal-kerja') ?>">
                                    <span class="sub-item">Jadwal Kerja</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_ijincuti'] ? 'gone' : '' ?><?= in_array($uri_path, $ijincuti) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#ijin_cuti">
                        <i class="fas fa-file-signature"></i>
                        <p>Ijin/Cuti</p>
                        <span class="caret"></span>
                    </a>
                    <div id="ijin_cuti" <?= in_array($uri_path, $ijincuti) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['acc-atasan'] ? 'gone' : '' ?> <?= $uri_path == "acc-atasan"? 'active' : '' ?>">
                                <a href="<?= base_url('acc-atasan') ?>">
                                    <span class="sub-item">ACC Atasan</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['acc-personalia'] ? 'gone' : '' ?> <?= $uri_path == "acc-personalia"? 'active' : '' ?>">
                                <a href="<?= base_url('acc-personalia') ?>">
                                    <span class="sub-item">ACC Personalia</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['cuti-tahunan'] ? 'gone' : '' ?> <?= $uri_path == "cuti-tahunan"? 'active' : '' ?>">
                                <a href="<?= base_url('cuti-tahunan') ?>">
                                    <span class="sub-item">Cuti Tahunan</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['cuti-menikah'] ? 'gone' : '' ?> <?= $uri_path == "cuti-menikah"? 'active' : '' ?>">
                                <a href="<?= base_url('cuti-menikah') ?>">
                                    <span class="sub-item">Cuti Menikah</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['cuti-melahirkan'] ? 'gone' : '' ?> <?= $uri_path == "cuti-melahirkan"? 'active' : '' ?>">
                                <a href="<?= base_url('cuti-melahirkan') ?>">
                                    <span class="sub-item">Cuti Melahirkan</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['ijin-pribadi'] ? 'gone' : '' ?> <?= $uri_path == "ijin-pribadi"? 'active' : '' ?>">
                                <a href="<?= base_url('ijin-pribadi') ?>">
                                    <span class="sub-item">Ijin Pribadi</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['ijin-duka'] ? 'gone' : '' ?> <?= $uri_path == "ijin-duka"? 'active' : '' ?>">
                                <a href="<?= base_url('ijin-duka') ?>">
                                    <span class="sub-item">Ijin Duka</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['ijin-sakit'] ? 'gone' : '' ?> <?= $uri_path == "ijin-sakit"? 'active' : '' ?>">
                                <a href="<?= base_url('ijin-sakit') ?>">
                                    <span class="sub-item">Ijin Sakit</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_dinasluar'] ? 'gone' : '' ?><?= in_array($uri_path, $dinasluar) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#dinas_luar">
                        <i class="fas fa-car-side"></i>
                        <p>Dinas Diluar</p>
                        <span class="caret"></span>
                    </a>
                    <div id="dinas_luar" <?= in_array($uri_path, $dinasluar) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['dinasluar-pengajuan'] ? 'gone' : '' ?> <?= $uri_path == "dinasluar-pengajuan"? 'active' : '' ?>">
                                <a href="<?= base_url('dinasluar-pengajuan') ?>">
                                    <span class="sub-item">Pengajuan Dinas</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['dinasluar-insentif'] ? 'gone' : '' ?> <?= $uri_path == "dinasluar-insentif"? 'active' : '' ?>">
                                <a href="<?= base_url('dinasluar-insentif') ?>">
                                    <span class="sub-item">Insentif Dinas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_rekapdata'] ? 'gone' : '' ?><?= in_array($uri_path, $rekapdata) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#rekap_data">
                        <i class="fas fa-chart-bar"></i>
                        <p>Rekap Data</p>
                        <span class="caret"></span>
                    </a>
                    <div id="rekap_data" <?= in_array($uri_path, $rekapdata) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['rekap-gaji'] ? 'gone' : '' ?> <?= $uri_path == "rekap-gaji"? 'active' : '' ?>">
                                <a href="<?= base_url('rekap-gaji') ?>">
                                    <span class="sub-item">Rekap Gaji</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['rekap-ijincuti'] ? 'gone' : '' ?> <?= $uri_path == "rekap-ijincuti"? 'active' : '' ?>">
                                <a href="<?= base_url('rekap-ijincuti') ?>">
                                    <span class="sub-item">Rekap Ijin/Cuti</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['rekap-lembur'] ? 'gone' : '' ?> <?= $uri_path == "rekap-lembur"? 'active' : '' ?>">
                                <a href="<?= base_url('rekap-lembur') ?>">
                                    <span class="sub-item">Rekap Lembur</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['rekap-keterlambatan'] ? 'gone' : '' ?> <?= $uri_path == "rekap-keterlambatan"? 'active' : '' ?>">
                                <a href="<?= base_url('rekap-keterlambatan') ?>">
                                    <span class="sub-item">Rekap Keterlambatan</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['rekap-lupaabsen'] ? 'gone' : '' ?> <?= $uri_path == "rekap-lupaabsen"? 'active' : '' ?>">
                                <a href="<?= base_url('rekap-lupaabsen') ?>">
                                    <span class="sub-item">Rekap Lupa Absen</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_masterdata'] ? 'gone' : '' ?><?= in_array($uri_path, $masterdata) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#master_data">
                        <i class="fas fa-layer-group"></i>
                        <p>Master Data</p>
                        <span class="caret"></span>
                    </a>
                    <div id="master_data" <?= in_array($uri_path, $masterdata) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['account'] ? 'gone' : '' ?> <?= $uri_path == "account"? 'active' : '' ?>">
                                <a href="<?= base_url('account') ?>">
                                    <span class="sub-item">Account</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['jabatan'] ? 'gone' : '' ?> <?= $uri_path == "jabatan"? 'active' : '' ?>">
                                <a href="<?= base_url('jabatan') ?>">
                                    <span class="sub-item">Jabatan</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['cabang-klinik'] ? 'gone' : '' ?> <?= $uri_path == "cabang-klinik"? 'active' : '' ?>">
                                <a href="<?= base_url('cabang-klinik') ?>">
                                    <span class="sub-item">Cabang</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['kegiatan-pengumuman'] ? 'gone' : '' ?> <?= $uri_path == "kegiatan-pengumuman"? 'active' : '' ?>">
                                <a href="<?= base_url('kegiatan-pengumuman') ?>">
                                    <span class="sub-item">Kegiatan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?= !$cekmenu['menu_pengaturan'] ? 'gone' : '' ?><?= in_array($uri_path, $pengaturan) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#pengaturan">
                        <i class="fas fa-cog"></i>
                        <p>Pengaturan</p>
                        <span class="caret"></span>
                    </a>
                    <div id="pengaturan" <?= in_array($uri_path, $pengaturan) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
                            <li class="<?= !$cekmenu['konfigurasi'] ? 'gone' : '' ?> <?= $uri_path == "konfigurasi"? 'active' : '' ?>">
                                <a href="<?= base_url('konfigurasi') ?>">
                                    <span class="sub-item">Konfigurasi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
            </ul>
        </div>
    </div>
</div>