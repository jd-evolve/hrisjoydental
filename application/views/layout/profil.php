<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form id="ubah_profil" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $member['nama_member']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>E-Mail</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $member['email']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>No. HP</label>
                                <input type="text" class="form-control" id="nohp" name="nohp" placeholder="No. Hp" value="<?= $member['telp']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>Posisi</label>
                                <input type="text" class="form-control" placeholder="Posisi" value="<?= $posisi['nama_posisi']; ?>" style="background: #fff !important; color:black;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" value="<?= $member['alamat']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3 mb-3">
                        <input type="submit" id="edit_profile" class="btn btn-secondary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="mx-auto d-block">
                    <?php
                        if($member['foto_diri'] == NULL || $member['foto_diri'] == ''){ $photo = 'profile.jpg'; }
                        else{ $photo = $member['foto_diri']; }
                    ?>
                    <img class="rounded-circle mx-auto d-block" src="<?= base_url() ?>assets/img/photo/<?= $photo; ?>" id="imgx" alt="Photo profile" width="180" height="180">
                </div>
                <hr>
                <div class="card-text">
                    <form id="form_photo" novalidate="novalidate" enctype="multipart/form-data" accept-charset="utf-8">
                        <div class="input-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="profile_image">Pilih foto...</label>
                                <input type="file" accept=".jpg, .jpeg, .png" class="custom-file-input" id="profile_image" name="profile_image" 
                                    onchange="imgx.src=window.URL.createObjectURL(this.files[0])"style="display:none" required>
                            </div>
                            <div class="input-group-append" style="margin-left:-75px">
                                <button class="btn btn-secondary" id="ganti_foto" style="padding:0 8px 0 8px; height:calc(2.25rem + 2px)">Ubah Foto</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>