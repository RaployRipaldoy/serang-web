<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-plus"></i> Tambah Jenis Perlengkapan
        </h5>
    </div>
    <div class="card-body">
        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6><i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:</h6>
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('DataJenisPerlengkapan/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama_perlengkapan" class="form-label">
                            Nama Perlengkapan <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= session()->getFlashdata('errors')['nama_perlengkapan'] ?? false ? 'is-invalid' : '' ?>" 
                               id="nama_perlengkapan" 
                               name="nama_perlengkapan" 
                               value="<?= old('nama_perlengkapan') ?>"
                               placeholder="Contoh: Lampu Jalan LED"
                               maxlength="100"
                               required>
                        <div class="form-text">Maksimal 100 karakter</div>
                        <?php if (session()->getFlashdata('errors')['nama_perlengkapan'] ?? false): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['nama_perlengkapan'] ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_perlengkapan" class="form-label">
                            Jenis Perlengkapan <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control <?= session()->getFlashdata('errors')['jenis_perlengkapan'] ?? false ? 'is-invalid' : '' ?>" 
                               id="jenis_perlengkapan" 
                               name="jenis_perlengkapan" 
                               value="<?= old('jenis_perlengkapan') ?>"
                               placeholder="Contoh: Penerangan Jalan"
                               maxlength="100"
                               required>
                        <div class="form-text">Maksimal 100 karakter</div>
                        <?php if (session()->getFlashdata('errors')['jenis_perlengkapan'] ?? false): ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['jenis_perlengkapan'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle text-info"></i> Informasi
                            </h6>
                            <small class="text-muted">
                                <ul class="mb-0">
                                    <li>Nama perlengkapan harus diisi</li>
                                    <li>Jenis perlengkapan harus diisi</li>
                                    <li>Maksimal 100 karakter untuk setiap field</li>
                                    <li>Data akan tercatat dengan timestamp otomatis</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('DataJenisPerlengkapan') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <div>
                    <button type="reset" class="btn btn-outline-warning me-2">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus pada field pertama
    document.getElementById('nama_perlengkapan').focus();
    
    // Character counter untuk fields
    const fields = ['nama_perlengkapan', 'jenis_perlengkapan'];
    fields.forEach(function(fieldName) {
        const field = document.getElementById(fieldName);
        const maxLength = field.getAttribute('maxlength');
        
        // Create counter element
        const counter = document.createElement('div');
        counter.className = 'text-muted small mt-1';
        counter.id = fieldName + '_counter';
        field.parentNode.appendChild(counter);
        
        // Update counter function
        function updateCounter() {
            const remaining = maxLength - field.value.length;
            counter.textContent = `${field.value.length}/${maxLength} karakter`;
            counter.className = remaining < 10 ? 'text-warning small mt-1' : 'text-muted small mt-1';
        }
        
        // Initial counter
        updateCounter();
        
        // Event listeners
        field.addEventListener('input', updateCounter);
        field.addEventListener('keyup', updateCounter);
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const namaPerlengkapan = document.getElementById('nama_perlengkapan').value.trim();
        const jenisPerlengkapan = document.getElementById('jenis_perlengkapan').value.trim();
        
        if (!namaPerlengkapan || !jenisPerlengkapan) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return false;
        }
    });
});
</script>
