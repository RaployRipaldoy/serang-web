<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengadaan</h1>
        <a href="<?= base_url('DataPengadaan/inputPengadaan') ?>"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
    </div>
    <hr>
    </hr>

    <div class="row">
        <div class="col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perlengkapan</th>
                                <th>Jenis Perlengkapan</th>
                                <th>Jumlah Ketersediaan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pengadaan as $item): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($item['nama_perlengkapan']) ?></td>
                                    <td><?= esc($item['jenis_perlengkapan']) ?></td>
                                    <td><?= esc($item['jumlah_ketersediaan']) ?></td>
                                    <td><?= esc($item['keterangan']) ?></td>
                                    <td>
                                        <a href="<?= site_url('DataPengadaan/editData/' . $item['id']) ?>"
                                            class="btn btn-primary">Edit</a>
                                        |
                                        <a href="<?= site_url('DataPengadaan/removeData/' . $item['id']) ?>"
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