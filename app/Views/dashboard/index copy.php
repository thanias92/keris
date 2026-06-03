<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<div class="dash-wrap">

    <div class="dash-header">
        <div>
            <h4>Dashboard Manajemen Risiko</h4>
            <p>Ringkasan dan analisis data risiko organisasi</p>
        </div>
        <div class="dash-date" id="dashDate"></div>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <label>Tahun</label>
            <select id="fTahun">
                <option value="">Semua Tahun</option>
                <?php foreach ($tahunList as $t): ?>
                    <option value="<?= esc($t['tahun']) ?>"><?= esc($t['tahun']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label>Tim Kerja</label>
            <select id="fTim">
                <option value="">Semua Tim Kerja</option>
                <?php foreach ($timKerjaList as $sk): ?>
                    <option value="<?= esc($sk['id_tim']) ?>"><?= esc($sk['nama_tim']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter-group">
            <label>Kategori Risiko</label>
            <select id="fKategori">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= esc($k['id_kategori_risiko']) ?>"><?= esc($k['nama_kategori']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn-reset" id="btnReset">Reset</button>
        <div class="filter-indicator" id="filterIndicator" style="display:none">
            <span id="filterBadge"></span>
        </div>
    </div>

    <div class="kpi-grid" id="kpiGrid">
        <div class="kpi-card">
            <div class="kpi-icon icon-blue"><i class="ti ti-shield-check"></i></div>
            <div class="kpi-body"><span>Total Risiko</span><b id="kTotalRisiko">—</b></div>
            <div class="kpi-bar" id="kBarRisiko" style="--p:0%;--c:#3b82f6"></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-purple"><i class="ti ti-list-check"></i></div>
            <div class="kpi-body"><span>Rencana Penanganan</span><b id="kTotalRtp">—</b></div>
            <div class="kpi-bar" id="kBarRtp" style="--p:0%;--c:#8b5cf6"></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-green"><i class="ti ti-chart-pie"></i></div>
            <div class="kpi-body"><span>Realisasi RTP</span><b id="kRealisasi">—</b></div>
            <div class="kpi-bar" id="kBarRealisasi" style="--p:0%;--c:#22c55e"></div>
        </div>
        <div class="kpi-card danger">
            <div class="kpi-icon icon-red"><i class="ti ti-alert-triangle"></i></div>
            <div class="kpi-body"><span>Risiko Tinggi</span><b id="kRisikoTinggi">—</b></div>
            <div class="kpi-bar" id="kBarTinggi" style="--p:0%;--c:#ef4444"></div>
        </div>
        <div class="kpi-card success">
            <div class="kpi-icon icon-teal"><i class="ti ti-circle-check"></i></div>
            <div class="kpi-body"><span>Risiko Rendah</span><b id="kRisikoRendah">—</b></div>
            <div class="kpi-bar" id="kBarRendah" style="--p:0%;--c:#14b8a6"></div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card">
            <div class="card-head">
                <span>Peta Risiko</span>
                <small>Kemungkinan × Dampak</small>
            </div>
            <div class="card-body heatmap-wrap">
                <div class="hm-inner">
                    <div class="hm-ylabels" id="hmYLabels">
                        <?php for ($y = 5; $y >= 1; $y--): ?>
                            <div class="hm-ylabel">D<?= $y ?></div>
                        <?php endfor; ?>
                    </div>
                    <div>
                        <table class="heatmap" id="heatmapTable"></table>
                        <div class="hm-xlabels">
                            <?php for ($x = 1; $x <= 5; $x++): ?>
                                <div class="hm-xlabel">K<?= $x ?></div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <div class="hm-legend">
                    <span class="h-low">Sangat Rendah</span>
                    <span class="h-med">Sedang</span>
                    <span class="h-high">Tinggi</span>
                    <span class="h-ext">Ekstrem</span>
                </div>
                <div class="hm-axis-labels">
                    <span class="axis-x">← Kemungkinan →</span>
                    <span class="axis-y">↑ Dampak</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span>Tren Identifikasi Risiko</span>
                <small>Per tahun</small>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height:260px">
                    <canvas id="chartTrend" role="img" aria-label="Tren risiko per tahun"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-3">
        <div class="card">
            <div class="card-head">
                <span>Risiko per Kategori</span>
                <small>Top 6</small>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height:220px">
                    <canvas id="chartKategori" role="img" aria-label="Risiko per kategori"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span>Status RTP</span>
                <small>Realisasi penanganan</small>
            </div>
            <div class="card-body donut-wrap">
                <div class="chart-container" style="height:220px">
                    <canvas id="chartStatus" role="img" aria-label="Status RTP"></canvas>
                </div>
                <div class="donut-legend" id="donutLegend">
                    <span><i style="background:#22c55e"></i>Selesai <b id="dSelesai">0</b></span>
                    <span><i style="background:#f59e0b"></i>Proses <b id="dProses">0</b></span>
                    <span><i style="background:#e2e8f0"></i>Belum <b id="dBelum">0</b></span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span>Risiko Terbaru</span>
                <small>5 identifikasi terakhir</small>
            </div>
            <div class="card-body">
                <ul class="risk-list" id="riskList"></ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span>Progress Pengisian per Satuan Kerja</span>
            <small>Konteks, Penilaian, dan RTP</small>
        </div>
        <div class="card-body">
            <table class="progress-table">
                <thead>
                    <tr>
                        <th>Satuan Kerja</th>
                        <th>Konteks</th>
                        <th>Penilaian Risiko</th>
                        <th>Rencana Penanganan</th>
                        <th>Kelengkapan</th>
                    </tr>
                </thead>
                <tbody id="progressBody"></tbody>
            </table>
        </div>
    </div>

</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const DATA_URL = '<?= base_url('dashboard/data') ?>';

    const now = new Date();
    document.getElementById('dashDate').textContent = now.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });

    let chartTrend, chartKategori, chartStatus;

    function initCharts() {
        chartTrend = new Chart(document.getElementById('chartTrend'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Risiko',
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3b82f6',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        },
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        chartKategori = new Chart(document.getElementById('chartKategori'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah',
                    data: [],
                    backgroundColor: ['#3b82f6', '#8b5cf6', '#14b8a6', '#f59e0b', '#ef4444', '#ec4899'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0,0,0,0.04)'
                        },
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        chartStatus = new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Proses', 'Belum'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['#22c55e', '#f59e0b', '#e2e8f0'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    function setBar(id, pct) {
        const el = document.getElementById(id);
        if (el) el.style.setProperty('--p', Math.min(pct, 100) + '%');
    }

    function renderHeatmap(grid) {
        const t = document.getElementById('heatmapTable');
        let html = '';
        for (let y = 5; y >= 1; y--) {
            html += '<tr>';
            for (let x = 1; x <= 5; x++) {
                const v = grid[y] ? (grid[y][x] || 0) : 0;
                const score = x * y;
                const cls = score >= 15 ? 'h-ext' : score >= 9 ? 'h-high' : score >= 4 ? 'h-med' : 'h-low';
                html += `<td class="${cls}">${v > 0 ? `<span class="hm-dot">${v}</span>` : ''}</td>`;
            }
            html += '</tr>';
        }
        t.innerHTML = html;
    }

    function renderRiskList(items) {
        const ul = document.getElementById('riskList');
        if (!items.length) {
            ul.innerHTML = '<li class="empty-state">Tidak ada data</li>';
            return;
        }
        ul.innerHTML = items.map(r => {
            const badge = (r.nama_kategori || 'R').substring(0, 2).toUpperCase();
            const text = r.pernyataan_risiko ? r.pernyataan_risiko.substring(0, 55) + '…' : '-';
            const tgl = r.created_at ? new Date(r.created_at).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            }) : '-';
            return `<li><div class="risk-badge">${badge}</div><div class="risk-info"><p>${text}</p><small>${r.nama_kategori || '-'} · ${tgl}</small></div></li>`;
        }).join('');
    }

    function renderProgress(rows) {
        const tbody = document.getElementById('progressBody');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="5" class="empty-state">Tidak ada data</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(p => {
            const pct = ((+p.f1 > 0 ? 33 : 0) + (+p.f2 > 0 ? 33 : 0) + (+p.f3 > 0 ? 34 : 0));
            const color = pct >= 100 ? '#22c55e' : pct >= 66 ? '#3b82f6' : pct >= 33 ? '#f59e0b' : '#ef4444';
            return `<tr>
            <td class="sk-name">${p.nama_tim}</td>
            <td><span class="count-badge blue">${p.f1}</span></td>
            <td><span class="count-badge purple">${p.f2}</span></td>
            <td><span class="count-badge teal">${p.f3}</span></td>
            <td><div class="prog-bar-wrap"><div class="prog-bar"><div class="prog-fill" style="width:${pct}%;background:${color}"></div></div><span>${pct}%</span></div></td>
        </tr>`;
        }).join('');
    }

    function updateFilterBadge() {
        const t = document.getElementById('fTahun').value;
        const s = document.getElementById('fSatuan').selectedOptions[0];
        const k = document.getElementById('fKategori').selectedOptions[0];
        const parts = [];
        if (t) parts.push(t);
        if (s && s.value) parts.push(s.text);
        if (k && k.value) parts.push(k.text);
        const ind = document.getElementById('filterIndicator');
        const badge = document.getElementById('filterBadge');
        if (parts.length) {
            badge.textContent = parts.join(' · ');
            ind.style.display = 'flex';
        } else {
            ind.style.display = 'none';
        }
    }

    let fetchTimer;

    function fetchData() {
        clearTimeout(fetchTimer);
        fetchTimer = setTimeout(async () => {
            const tahun = document.getElementById('fTahun').value;
            const tim = document.getElementById('fTim').value;
            const kategori = document.getElementById('fKategori').value;
            const overlay = document.getElementById('loadingOverlay');

            updateFilterBadge();
            overlay.classList.add('active');

            const params = new URLSearchParams();
            if (tahun) params.set('tahun', tahun);
            if (tim) params.set('tim_kerja', tim);
            if (kategori) params.set('kategori', kategori);

            try {
                const res = await fetch(DATA_URL + '?' + params.toString());
                const data = await res.json();
                const kpi = data.kpi;

                document.getElementById('kTotalRisiko').textContent = kpi.totalRisiko;
                document.getElementById('kTotalRtp').textContent = kpi.totalRtp;
                document.getElementById('kRealisasi').textContent = kpi.realisasi + '%';
                document.getElementById('kRisikoTinggi').textContent = kpi.risikoTinggi;
                document.getElementById('kRisikoRendah').textContent = kpi.risikoRendah;

                setBar('kBarRisiko', 100);
                setBar('kBarRtp', kpi.totalRisiko > 0 ? Math.round(kpi.totalRtp / kpi.totalRisiko * 100) : 0);
                setBar('kBarRealisasi', kpi.realisasi);
                setBar('kBarTinggi', kpi.totalRisiko > 0 ? Math.round(kpi.risikoTinggi / kpi.totalRisiko * 100) : 0);
                setBar('kBarRendah', kpi.totalRisiko > 0 ? Math.round(kpi.risikoRendah / kpi.totalRisiko * 100) : 0);

                renderHeatmap(data.heatmap);

                chartTrend.data.labels = data.trendLabels;
                chartTrend.data.datasets[0].data = data.trendValues;
                chartTrend.update();

                chartKategori.data.labels = data.kategoriLabels;
                chartKategori.data.datasets[0].data = data.kategoriValues;
                chartKategori.update();

                const s = data.statusRtp;
                const selesai = parseInt(s.selesai) || 0;
                const proses = parseInt(s.proses) || 0;
                const belum = parseInt(s.belum) || 0;
                chartStatus.data.datasets[0].data = [selesai, proses, belum];
                chartStatus.update();
                document.getElementById('dSelesai').textContent = selesai;
                document.getElementById('dProses').textContent = proses;
                document.getElementById('dBelum').textContent = belum;

                renderRiskList(data.risikoTerbaru);
                renderProgress(data.progress);
            } catch (e) {
                console.error('Fetch error:', e);
            } finally {
                overlay.classList.remove('active');
            }
        }, 300);
    }

    document.getElementById('fTahun').addEventListener('change', fetchData);
    document.getElementById('fTim').addEventListener('change', fetchData);
    document.getElementById('fKategori').addEventListener('change', fetchData);
    document.getElementById('btnReset').addEventListener('click', () => {
        document.getElementById('fTahun').value = '';
        document.getElementById('fTim').value = '';
        document.getElementById('fKategori').value = '';
        fetchData();
    });

    initCharts();
    fetchData();
</script>
<?= $this->endSection() ?>