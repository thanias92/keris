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
            <div class="kpi-body"><span>Rencana Penanganan (RTP)</span><b id="kTotalRtp">—</b></div>
            <div class="kpi-bar" id="kBarRtp" style="--p:0%;--c:#8b5cf6"></div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon icon-green"><i class="ti ti-chart-pie"></i></div>
            <div class="kpi-body"><span>Realisasi RTP</span><b id="kRealisasi">—</b></div>
            <div class="kpi-bar" id="kBarRealisasi" style="--p:0%;--c:#22c55e"></div>
        </div>
    </div>

    <div class="grid-heatmap">
        <div class="card">
            <div class="card-head">
                <span>Peta Risiko</span>
                <small>Kemungkinan × Dampak</small>
            </div>
            <div class="card-body heatmap-wrap">
                <div class="hm-inner">
                    <div class="hm-ylabels" id="hmYLabels">
                        <div class="hm-ylabel">Hampir Pasti</div>
                        <div class="hm-ylabel">Sering</div>
                        <div class="hm-ylabel">Kadang</div>
                        <div class="hm-ylabel">Jarang</div>
                        <div class="hm-ylabel">Hampir Tdk</div>
                    </div>
                    <div class="hm-table-wrap">
                        <table class="heatmap" id="heatmapTable"></table>
                        <div class="hm-xlabels">
                            <div class="hm-xlabel">Tdk Signifikan</div>
                            <div class="hm-xlabel">Minor</div>
                            <div class="hm-xlabel">Moderat</div>
                            <div class="hm-xlabel">Signifikan</div>
                            <div class="hm-xlabel">Sgt Signifikan</div>
                        </div>
                    </div>
                </div>
                <div class="hm-legend">
                    <span class="h-biru">Sangat Rendah</span>
                    <span class="h-hijau">Rendah</span>
                    <span class="h-kuning">Sedang</span>
                    <span class="h-oranye">Tinggi</span>
                    <span class="h-merah">Sangat Tinggi</span>
                </div>
                <div class="hm-axis-labels">
                    <span class="axis-x">← Dampak →</span>
                    <span class="axis-y">↑ Kemungkinan</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span>Level Risiko</span>
                <small>Distribusi tingkat risiko</small>
            </div>
            <div class="card-body pie-wrap">
                <div class="chart-container" style="height:240px">
                    <canvas id="chartPie" role="img" aria-label="Distribusi level risiko"></canvas>
                </div>
                <div class="pie-legend" id="pieLegend"></div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="card card-kategori">
            <div class="card-head">
                <span>Risiko per Kategori</span>
                <small>Semua kategori</small>
            </div>
            <div class="card-body">
                <div class="chart-container" style="height:300px">
                    <canvas id="chartKategori" role="img" aria-label="Risiko per kategori"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">
                <span>Status RTP</span>
                <small>Realisasi penanganan risiko</small>
            </div>
            <div class="card-body">
                <div class="status-rtp-grid" id="statusRtpGrid">
                    <div class="status-card s-belum">
                        <div class="s-icon"><i class="ti ti-clock-pause"></i></div>
                        <div class="s-body">
                            <span>Belum Dilaksanakan</span>
                            <b id="sBelum">—</b>
                        </div>
                    </div>
                    <div class="status-card s-proses">
                        <div class="s-icon"><i class="ti ti-loader"></i></div>
                        <div class="s-body">
                            <span>Dalam Proses</span>
                            <b id="sProses">—</b>
                        </div>
                    </div>
                    <div class="status-card s-selesai">
                        <div class="s-icon"><i class="ti ti-circle-check"></i></div>
                        <div class="s-body">
                            <span>Selesai</span>
                            <b id="sSelesai">—</b>
                        </div>
                    </div>
                    <div class="status-card s-terlambat">
                        <div class="s-icon"><i class="ti ti-alert-circle"></i></div>
                        <div class="s-body">
                            <span>Terlambat</span>
                            <b id="sTerlambat">—</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">
            <span>Progress Pengisian per Tim Kerja</span>
            <small>Jumlah Ruang Lingkup (Konteks) yang telah mencapai tiap tahap</small>
        </div>
        <div class="card-body">
            <table class="progress-table">
                <thead>
                    <tr>
                        <th>Tim Kerja</th>
                        <th>
                            <div class="th-form">Form 1</div>
                            <div class="th-sub">Penetapan Konteks</div>
                        </th>
                        <th>
                            <div class="th-form">Form 2</div>
                            <div class="th-sub">Identifikasi · Analisis · Evaluasi</div>
                        </th>
                        <th>
                            <div class="th-form">Form 3</div>
                            <div class="th-sub">Rencana Penanganan (RTP)</div>
                        </th>
                        <th>
                            <div class="th-form">Form 4</div>
                            <div class="th-sub">Pemantauan Risiko</div>
                        </th>
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

    // Tanggal header
    document.getElementById('dashDate').textContent = new Date().toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });

    let chartPie, chartKategori;

    function initCharts() {
        chartPie = new Chart(document.getElementById('chartPie'), {
            type: 'pie',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [],
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
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
                    label: 'Jumlah Risiko',
                    data: [],
                    backgroundColor: '#3b82f6',
                    borderRadius: 5,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y} risiko`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 10
                            },
                            maxRotation: 35,
                            minRotation: 35,
                            callback: function(val, idx) {
                                const label = this.getLabelForValue(val);
                                return label.length > 14 ? label.substring(0, 12) + '…' : label;
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
    }

    function setBar(id, pct) {
        const el = document.getElementById(id);
        if (el) el.style.setProperty('--p', Math.min(pct, 100) + '%');
    }

    // Warna heatmap dari kolom `warna` di matriks_risiko
    const WARNA_CSS = {
        biru: '#bfdbfe',
        hijau: '#bbf7d0',
        kuning: '#fde68a',
        oranye: '#fed7aa',
        merah: '#fca5a5',
    };
    const WARNA_TEXT = {
        biru: '#1e40af',
        hijau: '#166534',
        kuning: '#92400e',
        oranye: '#9a3412',
        merah: '#991b1b',
    };

    function renderHeatmap(grid) {
        const t = document.getElementById('heatmapTable');
        let html = '';
        // Baris: kemungkinan 5→1 (atas = tinggi)
        for (let k = 5; k >= 1; k--) {
            html += '<tr>';
            // Kolom: dampak 1→5
            for (let d = 1; d <= 5; d++) {
                const cell = (grid[k] && grid[k][d]) ? grid[k][d] : {};
                const count = cell.total || 0;
                const warna = (cell.warna || '').toLowerCase();
                const bg = WARNA_CSS[warna] || '#f1f5f9';
                const color = WARNA_TEXT[warna] || '#334155';
                const nilai = cell.nilai_risiko || '';
                html += `<td style="background:${bg};color:${color}" title="Nilai: ${nilai}">`;
                if (count > 0) html += `<span class="hm-dot">${count}</span>`;
                html += `</td>`;
            }
            html += '</tr>';
        }
        t.innerHTML = html;
    }

    function renderPieLegend(labels, values, colors) {
        const total = values.reduce((a, b) => a + b, 0);
        const el = document.getElementById('pieLegend');
        if (!labels.length) {
            el.innerHTML = '<span class="empty-state">Tidak ada data</span>';
            return;
        }
        el.innerHTML = labels.map((lbl, i) => {
            const pct = total > 0 ? Math.round(values[i] / total * 100) : 0;
            return `<div class="pie-legend-item">
                <i style="background:${colors[i]}"></i>
                <span>${lbl}</span>
                <b>${values[i]}</b>
                <em>${pct}%</em>
            </div>`;
        }).join('');
    }

    function renderProgress(rows) {
        const tbody = document.getElementById('progressBody');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="empty-state">Tidak ada data</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(p => {
            const f1 = +p.f1 || 0;
            // Form 2 = konteks yang sudah punya setidaknya salah satu dari IR/PR/EV
            const f2 = +p.f2_ir || 0; // pakai IR sebagai indikator utama Form 2
            const f3 = +p.f3 || 0;
            const f4 = +p.f4 || 0;

            // Kelengkapan: proporsi konteks yang sudah mencapai Form 4 dari total konteks
            const pct = f1 > 0 ? Math.round((f4 / f1) * 100) : 0;
            const color = pct >= 100 ? '#22c55e' : pct >= 75 ? '#3b82f6' : pct >= 40 ? '#f59e0b' : '#ef4444';

            return `<tr>
                <td class="sk-name">${p.nama_tim}</td>
                <td><span class="count-badge blue">${f1}</span></td>
                <td><span class="count-badge purple">${f2}</span></td>
                <td><span class="count-badge teal">${f3}</span></td>
                <td><span class="count-badge orange">${f4}</span></td>
                <td>
                    <div class="prog-bar-wrap">
                        <div class="prog-bar">
                            <div class="prog-fill" style="width:${pct}%;background:${color}"></div>
                        </div>
                        <span>${pct}%</span>
                    </div>
                </td>
            </tr>`;
        }).join('');
    }

    function updateFilterBadge() {
        const t = document.getElementById('fTahun').value;
        const tm = document.getElementById('fTim').selectedOptions[0];
        const k = document.getElementById('fKategori').selectedOptions[0];
        const parts = [];
        if (t) parts.push(t);
        if (tm && tm.value) parts.push(tm.text);
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
            if (tim) params.set('tim', tim);
            if (kategori) params.set('kategori', kategori);

            try {
                const res = await fetch(DATA_URL + '?' + params.toString());
                const data = await res.json();
                const kpi = data.kpi;

                // KPI cards
                document.getElementById('kTotalRisiko').textContent = kpi.totalRisiko;
                document.getElementById('kTotalRtp').textContent = kpi.totalRtp;
                document.getElementById('kRealisasi').textContent = kpi.realisasi + '%';
                setBar('kBarRisiko', 100);
                setBar('kBarRtp', kpi.totalRisiko > 0 ? Math.round(kpi.totalRtp / kpi.totalRisiko * 100) : 0);
                setBar('kBarRealisasi', kpi.realisasi);

                // Heatmap
                renderHeatmap(data.heatmap);

                // Pie chart level risiko
                chartPie.data.labels = data.pieLabels;
                chartPie.data.datasets[0].data = data.pieValues;
                chartPie.data.datasets[0].backgroundColor = data.pieColors;
                chartPie.update();
                renderPieLegend(data.pieLabels, data.pieValues, data.pieColors);

                // Bar chart kategori
                chartKategori.data.labels = data.kategoriLabels;
                chartKategori.data.datasets[0].data = data.kategoriValues;
                chartKategori.update();

                // Status RTP
                const s = data.statusRtp || {};
                document.getElementById('sBelum').textContent = parseInt(s.belum) || 0;
                document.getElementById('sProses').textContent = parseInt(s.proses) || 0;
                document.getElementById('sSelesai').textContent = parseInt(s.selesai) || 0;
                document.getElementById('sTerlambat').textContent = parseInt(s.terlambat) || 0;

                // Progress
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