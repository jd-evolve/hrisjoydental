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

                
            </ul>
        </div>
    </div>
</div>