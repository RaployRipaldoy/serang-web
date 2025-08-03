<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Log Aktivitas</h1>
    </div>
    <hr>

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Role User</th>
                                    <th>Email</th>
                                    <th>Aktivitas</th>
                                    <th>URL</th>
                                    <th>IP Address</th>
                                    <th>Waktu Akses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($log_activity as $item): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($item['username'] ?? 'Guest') ?></td>
                                        <td><?= esc($item['role'] ?? '-') ?></td>
                                        <td><?= esc($item['email'] ?? '-') ?></td>
                                        <td><?= esc($item['activity']) ?></td>
                                        <td><?= esc($item['url']) ?></td>
                                        <td><?= esc($item['ip_address']) ?></td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($item['created_at'])) ?></td>
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
