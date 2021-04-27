<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add User</h3>

              <div class="box-tools pull-right">
               
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php
            $errors = session()->getFlashdata('errors');
            if (!empty($errors)) { ?>
            <div class="alert alert-danger alert-dismissible">
            <h4>Ada Kesalahan !</h4>
            <ul>
                <?php foreach ($errors as $key => $value) { ?>
                    <li><?= esc($value) ?></li>
                <?php } ?>
                </ul>
                </div>
            <?php } ?>
            <?php echo form_open_multipart('user/insert'); ?>

            <div class="form-group">
                  <label>Nama User</label>
                  <input name="nama_user" class="form-control"  placeholder="Nama">
            </div>

            <div class="form-group">
                  <label>E-Mail</label>
                  <input name="email" class="form-control"  placeholder="E-Mail">
            </div>

            <div class="form-group">
                  <label>Password</label>
                  <input name="password" type="password" class="form-control"  placeholder="Password">
            </div>

            <div class="form-group">
                  <label>Level</label>
                  <select name="level" class="form-control">
                  <option value="">--Pilih Level--</option>
                  <option value="1">Admin</option>
                  <option value="2">User</option>
                  </select>
            </div>

            <div class="form-group">
                  <label>Departement</label>
                  <select name="id_dep" class="form-control">
                  <option value="">--Pilih Departement--</option>
                  <?php foreach ($dep as $key => $value) { ?>
                  <option value="<?= $value['id_dep'] ?>"><?= $value['nama_dep'] ?></option>
                  <?php } ?>  

                  </select>
            </div>

            <div class="form-group">
                  <label>Foto</label>
                  <input type="file" name="foto" class="form-control">
            </div>

            <div class="form-group">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?= base_url('user')  ?>" class="btn btn-danger">Kembali</a>
            </div>

            <?php echo form_close() ?>

            </div>
        </div>
          <!-- /.box -->
          <div class="col-md-3">
    </div>
</div>