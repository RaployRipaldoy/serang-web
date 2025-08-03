<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pelaporan</h1>
    </div>
    <hr>

    <div class="row">
        <div class="col-12"> 
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>No Handphone</th>
                                    <th>Keterangan</th>
                                    <th>Foto Pelaporan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($pelaporan as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($item['email']) ?></td>
                                        <td><?= esc($item['no_hp']) ?></td>
                                        <td><?= esc($item['keterangan']) ?></td>
                                        <td>
                                            <img src="<?= base_url('uploads/' . $item['foto_bukti']) ?>" width="100">
                                        </td>
                                        <td>
                                            <a href="<?= site_url('DataPelaporan/detailData/' . $item['id']) ?>"
                                                class="btn btn-primary">Detail</a>
                                            |
                                            <a href="<?= site_url('DataPelaporan/removeData/' . $item['id']) ?>"
                                                onclick="return confirm('Yakin ingin menghapus?')"
                                                class="btn btn-danger">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<script>
    let table = new DataTable('#dataTable');
</script>
