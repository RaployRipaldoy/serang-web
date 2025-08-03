<!DOCTYPE html>
<html>
<head>
    <title>Data Pemeliharaan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        img {
            width: 80px;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center;">Laporan Data Pemeliharaan Jalan</h1>
    <h2 style="text-align:center;">Kabupaten Serang</h2>

    <table style="text-align:center;">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemeliharaan</th>
                <th>Jenis</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Terakhir Diupdate</th>
                <th>Diupdate Oleh</th>
                <th>Kondisi</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pemeliharaan as $item): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($item['nama_pemeliharaan']) ?></td>
                <td><?= esc($item['jenis_pemeliharaan']) ?></td>
                <td><?= esc($item['lokasi_jalan']) ?></td>
                <td><?= esc($item['keterangan']) ?></td>
                <td><?= esc($item['terakhir_diupdate']) ?></td>
                <td><?= esc($item['diupdate_oleh']) ?></td>
                <td><?= esc($item['kondisi']) ?></td>
                <td>
                    <?php if (!empty($item['foto_pemeliharaan'])): ?>
                        <img src="<?= base_url('uploads/' . $item['foto_pemeliharaan']) ?>" width="100">
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
