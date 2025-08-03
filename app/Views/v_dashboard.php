<select name="perbandingan" id="filter-perbandingan" class="form-control mb-4">
    <option class="text-center" value="">Pilih Perbandingan Tahun</option>
    <?php foreach ($daftarPerbandingan as $perbandingan): ?>
        <option class="text-center" value="<?= $perbandingan ?>" <?= ($perbandingan == $perbandinganDipilih ? 'selected' : '') ?>>
            <?= $perbandingan ?>
        </option>
    <?php endforeach; ?>
</select>

<div class="row" id="histogram-container">
    <?php if (!empty($histogramData)): ?>
        <div class="col-12">
            <div class="card shadow-sm p-3">
                <h6 class="text-center">Perbandingan Jumlah Perlengkapan Jalan (<?= $perbandinganDipilih ?>)</h6>
                <div id="summary-info" class="text-center mb-3 p-2 bg-light rounded">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Total <?= explode('-', $perbandinganDipilih)[0] ?>:</strong> 
                            <span class="badge badge-primary"><?= $totalKeseluruhanSebelum ?> unit</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Total <?= explode('-', $perbandinganDipilih)[1] ?>:</strong> 
                            <span class="badge badge-success"><?= $totalKeseluruhanSesudah ?> unit</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Perubahan:</strong> 
                            <span class="badge <?= $perubahanTotal >= 0 ? 'badge-success' : 'badge-danger' ?>">
                                <?= $perubahanTotal >= 0 ? '+' : '' ?><?= $perubahanTotal ?> unit (<?= $perubahanTotal >= 0 ? '+' : '' ?><?= $persentasePerubahan ?>%)
                            </span>
                        </div>
                    </div>
                </div>
                <canvas id="histogramChart" width="800" height="400"></canvas>
            </div>
        </div>
    <?php elseif (!empty($daftarPerbandingan)): ?>
        <div class="col-12">
            <div class="card shadow-sm p-3">
                <h6 class="text-center">Tidak ada data untuk perbandingan yang dipilih</h6>
                <p class="text-center text-muted">Silakan pilih perbandingan tahun lain dari dropdown di atas</p>
            </div>
        </div>
    <?php else: ?>
        <div class="col-12">
            <div class="card shadow-sm p-3">
                <h6 class="text-center">Belum ada data perlengkapan jalan</h6>
                <p class="text-center text-muted">Data akan muncul setelah ada minimal 2 tahun berbeda dalam database</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let histogramChart = null;

    function createHistogram(data) {
        const ctx = document.getElementById('histogramChart').getContext('2d');
     
        if (histogramChart) {
            histogramChart.destroy();
        }

        
        const groupedData = {};
        const tahunSebelum = data.length > 0 ? data[0].tahun_sebelum : '';
        const tahunSesudah = data.length > 0 ? data[0].tahun_sesudah : '';

        
        data.forEach(item => {
            if (!groupedData[item.jenis]) {
                groupedData[item.jenis] = {};
            }
            groupedData[item.jenis][item.kondisi] = {
                sebelum: item.total_sebelum,
                sesudah: item.total_sesudah
            };
        });

      
        const labels = [];
        const datasets = [
            {
                label: `Baik ${tahunSebelum}`,
                data: [],
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 1
            },
            {
                label: `Baik ${tahunSesudah}`,
                data: [],
                backgroundColor: '#1cc88a',
                borderColor: '#1cc88a',
                borderWidth: 1,
                opacity: 0.7
            },
            {
                label: `Rusak ${tahunSebelum}`,
                data: [],
                backgroundColor: '#e74a3b',
                borderColor: '#e74a3b',
                borderWidth: 1
            },
            {
                label: `Rusak ${tahunSesudah}`,
                data: [],
                backgroundColor: '#e74a3b',
                borderColor: '#e74a3b',
                borderWidth: 1,
                opacity: 0.7
            },
            {
                label: `Rencana ${tahunSebelum}`,
                data: [],
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1
            },
            {
                label: `Rencana ${tahunSesudah}`,
                data: [],
                backgroundColor: '#4e73df',
                borderColor: '#4e73df',
                borderWidth: 1,
                opacity: 0.7
            }
        ];

      
        Object.keys(groupedData).forEach(jenis => {
            labels.push(jenis);
            
            // Baik
            datasets[0].data.push(groupedData[jenis]['Baik']?.sebelum || 0);
            datasets[1].data.push(groupedData[jenis]['Baik']?.sesudah || 0);
            
            // Rusak
            datasets[2].data.push(groupedData[jenis]['Rusak']?.sebelum || 0);
            datasets[3].data.push(groupedData[jenis]['Rusak']?.sesudah || 0);
            
            // Rencana
            datasets[4].data.push(groupedData[jenis]['Rencana']?.sebelum || 0);
            datasets[5].data.push(groupedData[jenis]['Rencana']?.sesudah || 0);
        });

        histogramChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Perbandingan Perlengkapan Jalan ${tahunSebelum} vs ${tahunSesudah} (per Kondisi)`
                    },
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.parsed.y;
                                return `${label}: ${value} unit`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah (unit)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + ' unit';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jenis Perlengkapan'
                        }
                    }
                }
            }
        });
    }

    
    // Inisialisasi chart saat document ready
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (!empty($histogramData)): ?>
            const initialData = <?= json_encode($histogramData) ?>;
            console.log('Initial data loaded:', initialData);
            setTimeout(function() {
                createHistogram(initialData);
            }, 100);
        <?php endif; ?>
    });

    document.getElementById('filter-perbandingan').addEventListener('change', function () {
        const perbandingan = this.value;
        const baseUrl = "<?= base_url() ?>";
        
        if (perbandingan) {
            fetch(`${baseUrl}Home/dataTahun?perbandingan=${perbandingan}`)
                .then(res => res.json())
                .then(response => {
                    if (response.data && response.data.length > 0) {
                        const container = document.getElementById('histogram-container');
                        container.innerHTML = `
                            <div class="col-12">
                                <div class="card shadow-sm p-3">
                                    <h6 class="text-center">Perbandingan Jumlah Perlengkapan Jalan (${perbandingan})</h6>
                                    <div id="summary-info" class="text-center mb-3 p-2 bg-light rounded">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Total ${perbandingan.split('-')[0]}:</strong> 
                                                <span class="badge badge-primary">${response.summary.totalSebelum} unit</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Total ${perbandingan.split('-')[1]}:</strong> 
                                                <span class="badge badge-success">${response.summary.totalSesudah} unit</span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Perubahan:</strong> 
                                                <span class="badge ${response.summary.perubahan >= 0 ? 'badge-success' : 'badge-danger'}">
                                                    ${response.summary.perubahan >= 0 ? '+' : ''}${response.summary.perubahan} unit (${response.summary.perubahan >= 0 ? '+' : ''}${response.summary.persentase}%)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <canvas id="histogramChart" width="800" height="400"></canvas>
                                </div>
                            </div>
                        `;
                        
                        setTimeout(() => {
                            createHistogram(response.data);
                        }, 100);
                    } else {
                        const container = document.getElementById('histogram-container');
                        container.innerHTML = `
                            <div class="col-12">
                                <div class="card shadow-sm p-3">
                                    <h6 class="text-center">Tidak ada data untuk perbandingan ${perbandingan}</h6>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const container = document.getElementById('histogram-container');
                    container.innerHTML = `
                        <div class="col-12">
                            <div class="card shadow-sm p-3">
                                <h6 class="text-center">Terjadi kesalahan saat memuat data</h6>
                            </div>
                        </div>
                    `;
                });
        } else {
            const container = document.getElementById('histogram-container');
            container.innerHTML = `
                <div class="col-12">
                    <div class="card shadow-sm p-3">
                        <h6 class="text-center">Silakan pilih perbandingan tahun untuk melihat histogram</h6>
                    </div>
                </div>
            `;
        }
    });
</script>