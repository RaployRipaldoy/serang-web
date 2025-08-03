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
            <?php echo form_open_multipart('DataPerlengkapan/insertData') ?>

            <div class="form-group">
                <label>Jenis Perlengkapan Jalan:</label>
                <select name="jenis_perlengkapan" id="jenis_perlengkapan" class="form-control">
                    <option value="">Pilih Jenis Perlengkapan</option>
                    <option value="APILL" <?= set_select('kondisi', 'Rusak') ?>>APILL</option>
                    <option value="PJU" <?= set_select('kondisi', 'Rusak') ?>>PJU</option>
                    <option value="Marka Jalan" <?= set_select('kondisi', 'Rusak') ?>>Marka Jalan</option>
                    <option value="Rambu Jalan" <?= set_select('kondisi', 'Rusak') ?>>Rambu Jalan</option>
                    <option value="Pengaman Jalan" <?= set_select('kondisi', 'Rusak') ?>>Pengaman Jalan</option>
                    <option value="Pengendali Pemakai Jalan" <?= set_select('kondisi', 'Baik') ?>>Pengendali Pemakai
                        Jalan</option>


                </select>
                <p class="text-danger">
                    <?php echo isset($errors['jenis_perlengkapan']) ? validation_show_error('jenis_perlengkapan') : ''; ?>
                </p>
            </div>

                <div class="form-group">
                    <label>Nama Perlengkapan Jalan:</label>
                    <select class="form-control" id="nama_perlengkapan" name="nama_perlengkapan" style="width: 100%;">
                        <option value="">Pilih Nama Perlengkapan</option>
                    </select>
                    <p class="text-danger">
                        <?php echo isset($errors['nama_perlengkapan']) ? validation_show_error('nama_perlengkapan') : ''; ?>
                    </p>
                </div>


            <div class="form-group">
                <label>Lokasi Ruas Jalan:</label>
                <input class="form-control" name="lokasi_jalan">
                <p class="text-danger">
                    <?php echo isset($errors['lokasi_jalan']) ? validation_show_error('lokasi_jalan') : ''; ?></p>
            </div>

            <div class="form-group">
                <label>Latitude:</label>
                <input class="form-control" name="latitude" id="Latitude">
                <p class="text-danger">
                    <?php echo isset($errors['latitude']) ? validation_show_error('latitude') : ''; ?></p>
            </div>


            <div class="form-group">
                <label>Longitude:</label>
                <input class="form-control" name="longitude" id="Longitude">
                <p class="text-danger">
                    <?php echo isset($errors['longitude']) ? validation_show_error('longitude') : ''; ?></p>
            </div>

            <div class="form-group">
                <label>Terakhir diupdate:</label>
                <input type="date" class="form-control" name="terakhir_diupdate">
                <p class="text-danger">
                    <?php echo isset($errors['terakhir_diupdate']) ? validation_show_error('terakhir_diupdate') : ''; ?>
                </p>
            </div>

            <div class="form-group">
                <label>Diupdate Oleh:</label>
                <input class="form-control" name="diupdate_oleh">
                <p class="text-danger">
                    <?php echo isset($errors['diupdate_oleh']) ? validation_show_error('diupdate_oleh') : ''; ?></p>
            </div>

            <div class="form-group">
                <label>Keterangan:</label>
                <input class="form-control" name="keterangan">
                <p class="text-danger">
                    <?php echo isset($errors['keterangan']) ? validation_show_error('keterangan') : ''; ?></p>
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



<!-- Select2 JS -->
<script>
    
    $(document).ready(function() {
    $('#jenis_perlengkapan').change(function() {
        let jenis = $(this).val();

        // kosongkan select sebelumnya
        $('#nama_perlengkapan').html('<option value="">Memuat data...</option>');

        $.ajax({
            url: '<?= base_url('DataPengadaan/getPengadaanByPerlengkapanAjax') ?>',
            type: 'GET',
            data: { jenis: jenis },
            dataType: 'json',
            success: function(response) {
                let options = '<option value="">Pilih Nama Perlengkapan</option>';
                $.each(response, function(index, value) {
                    options += `<option value="${value.id}">${value.nama_perlengkapan}</option>`;
                });
                $('#nama_perlengkapan').html(options);
            },
            error: function() {
                $('#nama_perlengkapan').html('<option value="">Gagal mengambil data</option>');
            }
        });
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
        center: [-6.0928869, 106.2070087],
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

    var curLocation = [-6.0928869, 106.2070087];
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