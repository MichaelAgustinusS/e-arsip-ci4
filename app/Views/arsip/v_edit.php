<div class="row">
<div class="col-md-3">
</div>
<div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Arsip</h3>

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
            <?php echo form_open_multipart('arsip/update/' . $arsip['id_arsip']);
            ?>

            <div class="form-group">
                  <label>No Arsip</label>
                  <input name="no_arsip" class="form-control" value="<?= $arsip['no_arsip']; ?>"  readonly>
            </div>

            <div class="form-group">
                  <label>Kategori</label>
                  <select name="id_kategori" class="form-control">
                  <option value="<?= $arsip['id_kategori'] ?>"><?= $arsip['nama_kategori'] ?></option>
                  <?php foreach ($kategori as $key => $value) { ?>
                  <option value="<?= $value['id_kategori'] ?>"><?= $value['nama_kategori'] ?></option>
                  <?php } ?>  

                  </select>
            </div>

            <div class="form-group">
                  <label>Nama Arsip</label>
                  <input name="nama_arsip" value="<?= $arsip['nama_arsip'] ?>" class="form-control"  placeholder="Nama Arsip">
            </div>

            <div class="form-group">
                  <label>Deskripsi</label>
                  <textarea name="deskripsi" class="form-control" rows="4"><?= $arsip['deskripsi'] ?></textarea>
            </div>

            <div class="form-group">
                  <label>Ganti File Arsip</label>
                  <input type="file" name="file_arsip" class="form-control">
                  <label class="text-danger">*Format File Harus .pdf</label>
            </div>

            <div class="form-group">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <a href="<?= base_url('arsip')  ?>" class="btn btn-danger">Kembali</a>
            </div>

            <?php echo form_close() ?>

            </div>
        </div>
          <!-- /.box -->
          <div class="col-md-3">
    </div>
</div>