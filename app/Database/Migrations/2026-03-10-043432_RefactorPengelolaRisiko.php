<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RefactorPengelolaRisiko extends Migration
{
    public function up()
    {
        $this->db->query('
            CREATE TABLE penugasan_pengelola (
                id               SERIAL PRIMARY KEY,
                pengelola_id     INT NOT NULL,
                satuan_kerja_id  INT NOT NULL,
                tahun            INT NOT NULL,
                is_ketua_tim     BOOLEAN NOT NULL DEFAULT FALSE,
                created_at       TIMESTAMP NULL,
                updated_at       TIMESTAMP NULL,
                UNIQUE (satuan_kerja_id, pengelola_id, tahun),
                CONSTRAINT fk_penugasan_pengelola
                    FOREIGN KEY (pengelola_id) REFERENCES pengelola_risiko(id) ON DELETE CASCADE,
                CONSTRAINT fk_penugasan_satuan_kerja
                    FOREIGN KEY (satuan_kerja_id) REFERENCES satuan_kerja(id_satuan_kerja) ON DELETE CASCADE
            )
        ');

        $this->db->query('
            INSERT INTO penugasan_pengelola (pengelola_id, satuan_kerja_id, tahun, is_ketua_tim, created_at)
            SELECT
                id,
                id_satuan_kerja,
                EXTRACT(YEAR FROM NOW())::INT,
                is_pengelola,
                NOW()
            FROM pengelola_risiko
            WHERE id_satuan_kerja IS NOT NULL
        ');

        $this->db->query('ALTER TABLE pengelola_risiko DROP COLUMN IF EXISTS id_satuan_kerja');
        $this->db->query('ALTER TABLE pengelola_risiko DROP COLUMN IF EXISTS is_pengelola');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE pengelola_risiko ADD COLUMN IF NOT EXISTS id_satuan_kerja INT NULL');
        $this->db->query('ALTER TABLE pengelola_risiko ADD COLUMN IF NOT EXISTS is_pengelola BOOLEAN NOT NULL DEFAULT TRUE');

        $this->db->query('
            UPDATE pengelola_risiko pr
            SET
                id_satuan_kerja = pp.satuan_kerja_id,
                is_pengelola    = pp.is_ketua_tim
            FROM penugasan_pengelola pp
            WHERE pp.pengelola_id = pr.id
        ');

        $this->db->query('DROP TABLE IF EXISTS penugasan_pengelola');
    }
}
