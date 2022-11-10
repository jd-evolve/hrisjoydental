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
                    'cuti-tahunan',
                    'cuti-menikah',
                    'cuti-melahirkan',
                    'ijin-pribadi',
                    'ijin-duka',
                    'ijin-dinas',
                );

                $masterdata = array(
                    'member',
                    'level-member',
                    'kota-klinik',
                    'kegiatan-pengumuman',
                );

                $pengaturan = array(
                    'konfigurasi',
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

                <li class="nav-item <?= !$cekmenu['menu_ijincuti'] ? 'gone' : '' ?><?= in_array($uri_path, $ijincuti) ? 'active submenu' : '' ?>">
                    <a data-toggle="collapse" href="#ijin_cuti">
                        <i class="fas fa-file-signature"></i>
                        <p>Ijin/Cuti</p>
                        <span class="caret"></span>
                    </a>
                    <div id="ijin_cuti" <?= in_array($uri_path, $ijincuti) ? 'class="collapse show"' : 'class="collapse"' ?>>
                        <ul class="nav nav-collapse">
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
                            <li class="<?= !$cekmenu['ijin-dinas'] ? 'gone' : '' ?> <?= $uri_path == "ijin-dinas"? 'active' : '' ?>">
                                <a href="<?= base_url('ijin-dinas') ?>">
                                    <span class="sub-item">Ijin Dinas Keluar</span>
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
                            <li class="<?= !$cekmenu['member'] ? 'gone' : '' ?> <?= $uri_path == "member"? 'active' : '' ?>">
                                <a href="<?= base_url('member') ?>">
                                    <span class="sub-item">Member</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['level-member'] ? 'gone' : '' ?> <?= $uri_path == "level-member"? 'active' : '' ?>">
                                <a href="<?= base_url('level-member') ?>">
                                    <span class="sub-item">Level Member</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['kota-klinik'] ? 'gone' : '' ?> <?= $uri_path == "kota-klinik"? 'active' : '' ?>">
                                <a href="<?= base_url('kota-klinik') ?>">
                                    <span class="sub-item">Kota klinik</span>
                                </a>
                            </li>
                            <li class="<?= !$cekmenu['kegiatan-pengumuman'] ? 'gone' : '' ?> <?= $uri_path == "kegiatan-pengumuman"? 'active' : '' ?>">
                                <a href="<?= base_url('kegiatan-pengumuman') ?>">
                                    <span class="sub-item">Kegiatan Pengumuman</span>
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