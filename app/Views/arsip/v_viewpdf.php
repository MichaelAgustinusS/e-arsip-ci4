<div class="row">
<div class="col-sm-12">
    <table class="table table-bordered">
    <tr>
        <th width="100px">No Arsip</th>
        <td width="30px">:</td>
        <td><?= $arsip['no_arsip'] ?></td>
        <th width="120px">Tanggal Upload</th>
        <td width="30px">:</td>
        <td><?= $arsip['tgl_upload'] ?></td>
    </tr>
    <tr>
        <th>Nama Arsip</th>
        <td>:</td>
        <td><?= $arsip['nama_arsip'] ?></td>
        <th width="120px">Tanggal Update</th>
        <td width="30px">:</td>
        <td><?= $arsip['tgl_update'] ?></td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>:</td>
        <td><?= $arsip['deskripsi'] ?></td>
        <th width="120px">Ukuran File</th>
        <td width="30px">:</td>
        <td><?= $arsip['ukuran_file'] ?> Byte</td>
    </tr>
    <tr>
        <th width="120px">User</th>
        <td width="30px">:</td>
        <td><?= $arsip['nama_user'] ?></td>
        <th>Departement</th>
        <td>:</td>
        <td><?= $arsip['nama_dep'] ?></td>
    </tr>
    </table>
    </div>
    <div class="col-sm-12">
        <iframe src="<?= base_url('file_arsip/'.$arsip['file_arsip']) ?>" style="border:none;" height="600px" width="100%"></iframe>
    </div>
</div>