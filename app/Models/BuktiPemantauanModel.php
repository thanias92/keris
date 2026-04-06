<?php

namespace App\Models;

use CodeIgniter\Model;

class BuktiPemantauanModel extends Model
{
    protected $table         = 'bukti_pemantauan';
    protected $primaryKey    = 'id_bukti';
    protected $returnType    = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_pemantauan',
        'nama_file',
        'path_file',
        'created_at',
    ];

    // updated_at tidak ada di tabel ini, jadi useTimestamps = false
    protected $useTimestamps = false;

    protected $validationRules = [
        'id_pemantauan' => [
            'label' => 'Pemantauan',
            'rules' => 'required|integer',
        ],
        'nama_file' => [
            'label' => 'Nama File',
            'rules' => 'required|max_length[255]',
        ],
        'path_file' => [
            'label' => 'Path File',
            'rules' => 'required|max_length[500]',
        ],
    ];

    protected $validationMessages = [
        'id_pemantauan' => [
            'required' => 'ID Pemantauan wajib diisi.',
            'integer'  => 'ID Pemantauan harus berupa angka.',
        ],
        'nama_file' => [
            'required'   => 'Nama file wajib diisi.',
            'max_length' => 'Nama file maksimal 255 karakter.',
        ],
        'path_file' => [
            'required'   => 'Path file wajib diisi.',
            'max_length' => 'Path file maksimal 500 karakter.',
        ],
    ];

    /* ======================================================
       KONSTANTA
    ====================================================== */
    public const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png', 'webp'];
    public const MAX_FILE_SIZE_MB   = 5;
    public const UPLOAD_PATH        = 'uploads/bukti_pemantauan/'; // relatif terhadap WRITEPATH

    /* ======================================================
       QUERY HELPERS
    ====================================================== */

    /**
     * Ambil semua bukti milik satu pemantauan,
     * diurutkan dari yang paling lama diupload.
     */
    public function getByPemantauan(int $idPemantauan): array
    {
        return $this->where('id_pemantauan', $idPemantauan)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    /**
     * Hitung jumlah bukti milik satu pemantauan.
     */
    public function countByPemantauan(int $idPemantauan): int
    {
        return $this->where('id_pemantauan', $idPemantauan)->countAllResults();
    }

    /**
     * Insert satu record bukti sekaligus memindahkan file ke disk.
     * Mengembalikan id_bukti atau 0 jika gagal.
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file   Objek file dari $request->getFiles()
     * @param int                                  $idPemantauan
     */
    public function simpanFile(\CodeIgniter\HTTP\Files\UploadedFile $file, int $idPemantauan): int
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return 0;
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, self::ALLOWED_EXTENSIONS)) {
            return 0;
        }

        if ($file->getSize() > self::MAX_FILE_SIZE_MB * 1024 * 1024) {
            return 0;
        }

        $uploadDir = WRITEPATH . self::UPLOAD_PATH;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $newName = $file->getRandomName();
        $file->move($uploadDir, $newName);

        $this->insert([
            'id_pemantauan' => $idPemantauan,
            'nama_file'     => $file->getClientName(),
            'path_file'     => self::UPLOAD_PATH . $newName,
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        return (int) $this->getInsertID();
    }

    /**
     * Hapus satu bukti: file fisik + record DB.
     * Mengembalikan true jika berhasil.
     */
    public function hapusDenganFile(int $idBukti): bool
    {
        $bukti = $this->find($idBukti);
        if (!$bukti) {
            return false;
        }

        $filePath = WRITEPATH . $bukti['path_file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return (bool) $this->delete($idBukti);
    }

    /**
     * Hapus semua bukti milik satu pemantauan
     * beserta file fisiknya.
     */
    public function hapusSemuaByPemantauan(int $idPemantauan): void
    {
        $list = $this->getByPemantauan($idPemantauan);

        foreach ($list as $bukti) {
            $filePath = WRITEPATH . $bukti['path_file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->where('id_pemantauan', $idPemantauan)->delete();
    }

    /**
     * Validasi file sebelum upload tanpa menyimpan.
     * Mengembalikan array ['valid' => bool, 'message' => string].
     */
    public function validateFile(\CodeIgniter\HTTP\Files\UploadedFile $file): array
    {
        if (!$file->isValid()) {
            return ['valid' => false, 'message' => 'File tidak valid: ' . $file->getErrorString()];
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, self::ALLOWED_EXTENSIONS)) {
            return [
                'valid'   => false,
                'message' => 'Tipe file tidak diizinkan. Hanya: ' . implode(', ', self::ALLOWED_EXTENSIONS),
            ];
        }

        if ($file->getSize() > self::MAX_FILE_SIZE_MB * 1024 * 1024) {
            return [
                'valid'   => false,
                'message' => 'Ukuran file melebihi batas ' . self::MAX_FILE_SIZE_MB . ' MB.',
            ];
        }

        return ['valid' => true, 'message' => ''];
    }
}
