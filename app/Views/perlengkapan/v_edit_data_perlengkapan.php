<h1>Input Data Perlengkapan Jalan</h1>
<hr>
</hr>

<div class="row">

    <div class="col-sm-8">
        <div id="map" style="width: 100%; height: 100vh;"></div>
    </div>

    <div class="col-sm-3">
        <div class="row">
            <?php
            if (session()->getFlashdata('pesan')) {
                echo '<div class="alert alert-success">';
                echo session()->getFlashdata('pesan');
                echo '</div>';
            }
            ?>
            <?php $errors = validation_errors() ?>
            <?php echo form_open_multipart('DataPerlengkapan/updateData/' . $perlengkapan['id_perlengkapan_jln']) ?>

            <div class="form-group">
                <label>Jenis Perlengkapan Jalan:</label>
                <select name="jenis_perlengkapan" id="jenis_perlengkapan" class="form-control">
                    <option value="APILL" <?= ($perlengkapan['jenis_perlengkapan'] == 'APILL') ? 'selected' : ''; ?>>APILL
                    </option>
                    <option value="PJU" <?= ($perlengkapan['jenis_perlengkapan'] == 'PJU') ? 'selected' : ''; ?>>PJU
                    </option>
                    <option value="Marka Jalan" <?= ($perlengkapan['jenis_perlengkapan'] == 'Marka Jalan') ? 'selected' : ''; ?>>Marka Jalan</option>
                    <option value="Rambu Jalan" <?= ($perlengkapan['jenis_perlengkapan'] == 'Rambu Jalan') ? 'selected' : ''; ?>>Rambu Jalan</option>
                    <option value="Pengaman Jalan" <?= ($perlengkapan['jenis_perlengkapan'] == 'Pengaman Jalan') ? 'selected' : ''; ?>>Pengaman Jalan</option>
                    <option value="Pengendali Pemakai Jalan" <?= ($perlengkapan['jenis_perlengkapan'] == 'Pengendali Pemakai Jalan') ? 'selected' : ''; ?>>Pengendali Pemakai Jalan</option>
                </select>
                <p class="text-danger">
                    <?php echo isset($errors['jenis_perlengkapan']) ? validation_show_error('jenis_perlengkapan') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan Jalan:</label>
                
                <select name="nama_perlengkapan" id="nama_perlengkapan" class="form-control"
                    data-selected="<?= $perlengkapan['pengadaan_id'] ?>">
                    <option value="">Pilih Nama Perlengkapan</option>
                </select>

                <p class="text-danger">
                    <?php echo isset($errors['nama_perlengkapan']) ? validation_show_error('nama_perlengkapan') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Lokasi Ruas Jalan:</label>
                <input class="form-control" name="lokasi_jalan" value="<?php echo $perlengkapan['lokasi_jalan'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['lokasi_jalan']) ? validation_show_error('lokasi_jalan') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Latitude:</label>
                <input class="form-control" name="latitude" id="Latitude"
                    value="<?php echo $perlengkapan['latitude'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['latitude']) ? validation_show_error('latitude') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Longitude:</label>
                <input class="form-control" name="longitude" id="Longitude"
                    value="<?php echo $perlengkapan['longitude'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['longitude']) ? validation_show_error('longitude') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Terakhir diupdate:</label>
                <input type="date" class="form-control" name="terakhir_diupdate"
                    value="<?php echo $perlengkapan['terakhir_diupdate'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['terakhir_diupdate']) ? validation_show_error('terakhir_diupdate') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Diupdate Oleh:</label>
                <input class="form-control" name="diupdate_oleh" value="<?php echo $perlengkapan['diupdate_oleh'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['diupdate_oleh']) ? validation_show_error('diupdate_oleh') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Keterangan:</label>
                <input class="form-control" name="keterangan" value="<?php echo $perlengkapan['keterangan'] ?>">
                <p class="text-danger">
                    <?php echo isset($errors['keterangan']) ? validation_show_error('keterangan') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Foto Perlengkapan</label>
                <input type="file" class="form-control" name="foto_perlengkapan" accept="image/">
                <p class="text-danger">
                    <?php echo isset($errors['foto_perlengkapan']) ? validation_show_error('foto_perlengkapan') : ''; ?>
                </p>
            </div>

            <label for="kondisi">Kondisi Perlengkapan:</label>
            <!-- Dropdown field -->
            <select name="kondisi" id="kondisi" class="form-control">
                <?php if (in_array(session('role'), ['admin', 'rekayasa'])): ?>
                    <option value="Baik" <?= set_select('kondisi', 'Baik') ?>>Baik</option>
                    <option value="Rusak" <?= set_select('kondisi', 'Rusak') ?>>Rusak</option>
                <?php endif; ?>

                <?php if (in_array(session('role'), ['admin', 'management'])): ?>
                    <option value="Rencana" <?= set_select('kondisi', 'Rencana') ?>>Rencana</option>
                <?php endif; ?>
            </select>


            <br></br>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-success">Reset</button>

            <?php echo form_close() ?>

        </div>

    </div>

</div>



<script>
    $(document).ready(function () {
        const jenisTerpilih = $('#jenis_perlengkapan').val(); // Ambil jenis yang tersimpan
        const namaTerpilih = $('#nama_perlengkapan').data('selected'); // Ambil id nama_perlengkapan yang tersimpan (pakai data-selected)

        // Fungsi untuk load nama perlengkapan berdasarkan jenis
        function loadNamaPerlengkapan(jenis, selected = null) {
            $('#nama_perlengkapan').html('<option value="">Memuat data...</option>');

            $.ajax({
                url: '<?= base_url('DataPengadaan/getPengadaanByPerlengkapanAjax') ?>',
                type: 'GET',
                data: { jenis: jenis },
                dataType: 'json',
                success: function (response) {
                    let options = '<option value="">Pilih Nama Perlengkapan</option>';
                    $.each(response, function (index, value) {
                        const isSelected = selected && selected == value.id ? 'selected' : '';
                        options += `<option value="${value.id}" ${isSelected}>${value.nama_perlengkapan}</option>`;
                    });
                    $('#nama_perlengkapan').html(options);
                },
                error: function () {
                    $('#nama_perlengkapan').html('<option value="">Gagal mengambil data</option>');
                }
            });
        }

        // Trigger saat pertama kali load (jika sedang edit data)
        if (jenisTerpilih) {
            loadNamaPerlengkapan(jenisTerpilih, namaTerpilih);
        }

        // Event saat ganti jenis
        $('#jenis_perlengkapan').change(function () {
            let jenis = $(this).val();
            loadNamaPerlengkapan(jenis);
        });
    });




    const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    });

    const openTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
    });

    const map = L.map('map', {
        center: [<?php echo $perlengkapan['latitude'] ?>, <?php echo $perlengkapan['longitude'] ?>],
        zoom: 13,
        layers: [osm, openTopoMap]
    });

    const baseLayers = {
        'Default': osm,
        'Topografi': openTopoMap
    };

    const layerControl = L.control.layers(baseLayers).addTo(map);

    var latInput = document.querySelector("[name=latitude]");
    var lngInput = document.querySelector("[name=longitude]");
    var posisi = document.querySelector("[name=posisi]");

    var curLocation = [<?php echo $perlengkapan['latitude'] ?>, <?php echo $perlengkapan['longitude'] ?>];
    map.attributionControl.setPrefix(false);

    var marker = new L.marker(curLocation, {
        draggable: true,
    });

    marker.on('dragend', function (e) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
            curLocation,
        }).bindPopup(position).update();
        $("#Latitude").val(position.lat);
        $("#Longitude").val(position.lng);
    });

    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        if (!marker) {
            marker = L.marker(e.latlng).addTo(map);
        } else {
            marker.setLatLng(e.latlng);
        }
        latInput.value = lat;
        lngInput.value = lng;
        posisi.value = lat + ',' + lng;
    });

    map.addLayer(marker);

</script>