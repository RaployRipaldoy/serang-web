<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Perlengkapan Jalan</h1>
        <div>
        <a href="<?= base_url('DataPerlengkapan/exportPdf') ?>" target="_blank"
        class="btn btn-success btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
        <a href="<?= base_url('DataPerlengkapan/inputPerlengkapan') ?>"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
        </div>
    </div>
    <hr>
    </hr>

    <div class="row">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perlengkapan</th>
                                <th>Jenis Perlengkapan</th>
                                <th>Lokasi Jalan</th>
                                <th>Keterangan</th>
                                <th>Terakhir Diupdate</th>
                                <th>Diupdate Oleh</th>
                                <th>Kondisi</th>
                                <th>Foto Perlengkapan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($perlengkapan as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item['nama_perlengkapan']) ?></td>
                                    <td><?= esc($item['jenis_perlengkapan']) ?></td>
                                    <td><?= esc($item['lokasi_jalan']) ?></td>
                                    <td><?= esc($item['keterangan']) ?></td>
                                    <td><?= esc($item['terakhir_diupdate']) ?></td>
                                    <td><?= esc($item['diupdate_oleh']) ?></td>
                                    <td><?= esc($item['kondisi']) ?></td>
                                    <td><img src="<?= base_url('uploads/' . $item['foto_perlengkapan']) ?>" width="100">
                                    </td>
                                    <td>
                                        <a href="<?= site_url('DataPerlengkapan/editData/' . $item['id_perlengkapan_jln']) ?>"
                                            class="btn btn-primary">Edit</a>
                                        |
                                        <a href="<?= site_url('DataPerlengkapan/removeData/' . $item['id_perlengkapan_jln']) ?>"
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


<script>
    let table = new DataTable('#dataTable');
</script>