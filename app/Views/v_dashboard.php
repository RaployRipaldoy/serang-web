<select name="tahun" id="filter-tahun" class="form-control mb-4">
    <option class="text-center" value="">Semua Tahun</option>
    <?php foreach ($daftarTahun as $tahun): ?>
        <option class="text-center" value="<?= $tahun ?>" <?= ($tahun == $tahunDipilih ? 'selected' : '') ?>>
            <?= $tahun ?>
        </option>
    <?php endforeach; ?>
</select>


<div class="row" id="chart-container">
    <?php foreach ($charts as $jenis => $details): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm p-3">
                <h6 class="text-center"><?= esc($jenis) ?></h6>
                <canvas id="chart_<?= md5($jenis) ?>" width="400" height="400"></canvas>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/crypto-js@4.1.1/crypto-js.min.js"></script>

<script>
    const chartObjects = {};

    function getWarnaByKondisi(kondisi) {
        const warna = {
            'Rencana': '#4e73df',
            'Rusak': '#e74a3b',
            'Baik': '#1cc88a'
        };
        return warna[kondisi] || '#36b9cc';
    }

    <?php foreach ($charts as $jenis => $details): ?>
        const ctx<?= md5($jenis) ?> = document.getElementById("chart_<?= md5($jenis) ?>").getContext("2d");
        chartObjects["<?= md5($jenis) ?>"] = new Chart(ctx<?= md5($jenis) ?>, {
            type: 'pie',
            data: {
                labels: <?= json_encode(array_column($details, 'kondisi')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($details, 'total')) ?>,
                    backgroundColor: <?= json_encode(array_map(function ($item) {
                        $warna = [
                            'Rencana' => '#4e73df',
                            'Rusak' => '#e74a3b',
                            'Baik' => '#1cc88a'
                        ];
                        return $warna[$item['kondisi']] ?? '#36b9cc';
                    }, $details)) ?>
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    <?php endforeach; ?>

    document.getElementById('filter-tahun').addEventListener('change', function () {
        const tahun = this.value;
        const baseUrl = "<?= base_url() ?>";
        fetch(`${baseUrl}Home/dataTahun?tahun=${tahun}`)
            .then(res => res.json())
            .then(data => {

                for (const key in chartObjects) {
                    chartObjects[key].destroy();
                }

                const container = document.getElementById('chart-container');
                container.innerHTML = '';

                for (const jenis in data) {
                    const chartId = `chart_${md5(jenis)}`;
                    container.innerHTML += `
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm p-3">
                                <h6 class="text-center">${jenis}</h6>
                                <canvas id="${chartId}" width="400" height="400"></canvas>
                            </div>
                        </div>
                    `;
                }

                setTimeout(() => {
                    for (const jenis in data) {
                        const ctx = document.getElementById(`chart_${md5(jenis)}`).getContext("2d");
                        const labels = data[jenis].map(d => d.kondisi);
                        const totals = data[jenis].map(d => d.total);
                        const colors = data[jenis].map(d => getWarnaByKondisi(d.kondisi));

                        chartObjects[md5(jenis)] = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: totals,
                                    backgroundColor: colors
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { position: 'bottom' }
                                }
                            }
                        });
                    }
                }, 100);
            });
    });

    function md5(string) {
        return CryptoJS.MD5(string).toString();
    }
</script>