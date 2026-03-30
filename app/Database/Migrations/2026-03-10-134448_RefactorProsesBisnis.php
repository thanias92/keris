<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorProsesBisnis extends Migration
{
    public function up()
    {
        // =====================================================
        // 1. ROMBAK proses_bisnis — hapus id_konteks,
        //    isi dengan data master fix
        // =====================================================
        $this->db->query('TRUNCATE TABLE proses_bisnis CASCADE');

        $this->db->query('
            ALTER TABLE proses_bisnis
                DROP COLUMN IF EXISTS id_konteks
        ');

        $this->db->query("
            INSERT INTO proses_bisnis (kode_proses, jenis_proses, uraian_proses) VALUES
            ('S01', 'Teknis', 'Persiapan (Identifikasi Kebutuhan)'),
            ('S02', 'Teknis', 'Persiapan (Perancangan)'),
            ('S03', 'Teknis', 'Persiapan (Pembangunan)'),
            ('S04', 'Teknis', 'Pengumpulan Data'),
            ('S05', 'Teknis', 'Pengolahan Data'),
            ('S06', 'Teknis', 'Analisis Statistik'),
            ('S07', 'Teknis', 'Diseminasi Statistik'),
            ('S08', 'Teknis', 'Evaluasi Data'),
            ('K01', 'Non-Teknis', 'Perencanaan'),
            ('K02', 'Non-Teknis', 'Persiapan'),
            ('K03', 'Non-Teknis', 'Pelaksanaan'),
            ('K04', 'Non-Teknis', 'Pelaporan'),
            ('K05', 'Non-Teknis', 'Evaluasi')
        ");

        // =====================================================
        // 2. BUAT junction table
        // =====================================================
        $this->db->query('
            CREATE TABLE konteks_proses_bisnis (
                id_konteks_proses SERIAL PRIMARY KEY,
                id_konteks INT NOT NULL,
                id_proses INT NOT NULL,
                created_at TIMESTAMP DEFAULT NOW(),
                UNIQUE(id_konteks, id_proses),
                CONSTRAINT fk_kpb_konteks
                    FOREIGN KEY (id_konteks)
                    REFERENCES konteks(id_konteks)
                    ON DELETE CASCADE,
                CONSTRAINT fk_kpb_proses
                    FOREIGN KEY (id_proses)
                    REFERENCES proses_bisnis(id_proses)
                    ON DELETE CASCADE
            )
        ');

        // =====================================================
        // 3. UPDATE sasaran_kinerja
        // =====================================================
        $this->db->query('
            ALTER TABLE sasaran_kinerja
                DROP COLUMN IF EXISTS id_proses
        ');

        $this->db->query('
            ALTER TABLE sasaran_kinerja
                ADD COLUMN id_konteks_proses INT,
                ADD CONSTRAINT fk_sk_konteks_proses
                    FOREIGN KEY (id_konteks_proses)
                    REFERENCES konteks_proses_bisnis(id_konteks_proses)
                    ON DELETE CASCADE
        ');

        // =====================================================
        // 4. UPDATE identifikasi_risiko
        // =====================================================
        $this->db->query('
            ALTER TABLE identifikasi_risiko
                DROP COLUMN IF EXISTS id_proses
        ');

        $this->db->query('
            ALTER TABLE identifikasi_risiko
                ADD COLUMN id_konteks_proses INT,
                ADD CONSTRAINT fk_ir_konteks_proses
                    FOREIGN KEY (id_konteks_proses)
                    REFERENCES konteks_proses_bisnis(id_konteks_proses)
                    ON DELETE CASCADE
        ');
    }

    public function down()
    {
        $this->db->query('DROP TABLE IF EXISTS konteks_proses_bisnis CASCADE');

        $this->db->query('ALTER TABLE sasaran_kinerja DROP COLUMN IF EXISTS id_konteks_proses');
        $this->db->query('ALTER TABLE sasaran_kinerja ADD COLUMN IF NOT EXISTS id_proses INT');

        $this->db->query('ALTER TABLE identifikasi_risiko DROP COLUMN IF EXISTS id_konteks_proses');
        $this->db->query('ALTER TABLE identifikasi_risiko ADD COLUMN IF NOT EXISTS id_proses INT');

        $this->db->query('TRUNCATE TABLE proses_bisnis CASCADE');
        $this->db->query('ALTER TABLE proses_bisnis ADD COLUMN IF NOT EXISTS id_konteks INT');
    }
}
