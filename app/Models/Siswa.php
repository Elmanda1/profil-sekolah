<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'tb_siswa';
    protected $primaryKey = 'id_siswa';
    public $timestamps = true;

    protected $fillable = [
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'alamat',
        'no_telp',
        'email',
        'foto',
        'id_sekolah',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'status' => 'aktif',
    ];

    // =====================================================
    // RELATIONSHIPS
    // =====================================================

    /**
     * Siswa belongs to Sekolah
     */
    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id_sekolah');
    }

    /**
     * Siswa has one Akun
     */
    public function akun(): HasOne
    {
        return $this->hasOne(Akun::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Siswa has many KelasSiswa (history kelas)
     */
    public function kelasSiswa(): HasMany
    {
        return $this->hasMany(KelasSiswa::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Siswa belongs to many Kelas through KelasSiswa
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(
            Kelas::class,
            'tb_kelas_siswa',
            'id_siswa',
            'id_kelas',
            'id_siswa',
            'id_kelas'
        )->withPivot('tahun_ajaran', 'semester');
    }

    /**
     * Get kelas terakhir (current class)
     */
    public function kelasAktif(): BelongsTo
    {
        return $this->kelasSiswa()
                    ->latest('tahun_ajaran')
                    ->latest('semester')
                    ->limit(1);
    }

    /**
     * Siswa has many KRS
     */
    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Siswa has many Tabungan
     */
    public function tabungan(): HasMany
    {
        return $this->hasMany(Tabungan::class, 'id_siswa', 'id_siswa');
    }

    /**
     * Siswa has many Prestasi
     */
    public function prestasi(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'id_siswa', 'id_siswa');
    }

    // =====================================================
    // QUERY SCOPES (OPTIMIZED)
    // =====================================================

    /**
     * Scope: Filter by sekolah
     */
    public function scopeBySekolah($query, $idSekolah)
    {
        return $query->where('id_sekolah', $idSekolah);
    }

    /**
     * Scope: Filter by kelas
     */
    public function scopeByKelas($query, $idKelas)
    {
        return $query->whereHas('kelasSiswa', function($q) use ($idKelas) {
            $q->where('id_kelas', $idKelas);
        });
    }

    /**
     * Scope: Filter by status (aktif/non-aktif)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: Filter by jenis kelamin
     */
    public function scopeByJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    /**
     * Scope: Search by nama or NISN (OPTIMIZED with indexes)
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function($q) use ($search) {
            $q->where('nama_siswa', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%");
        });
    }

    /**
     * Scope: Minimal fields untuk list view
     */
    public function scopeMinimal($query)
    {
        return $query->select([
            'id_siswa',
            'nama_siswa',
            'nisn',
            'jenis_kelamin',
            'tanggal_lahir',
            'alamat',
            'id_sekolah'
        ]);
    }

    /**
     * Scope: With essential relationships (optimized)
     */
    public function scopeWithEssentials($query)
    {
        return $query->with([
            'sekolah:id_sekolah,nama_sekolah',
            'akun:id_akun,username,id_siswa'
        ]);
    }

    /**
     * Scope: Order by nama
     */
    public function scopeOrderByNama($query, $direction = 'asc')
    {
        return $query->orderBy('nama_siswa', $direction);
    }

    /**
     * Scope: Get students by tahun ajaran & semester
     */
    public function scopeByTahunAjaran($query, $tahunAjaran, $semester = null)
    {
        return $query->whereHas('kelasSiswa', function($q) use ($tahunAjaran, $semester) {
            $q->where('tahun_ajaran', $tahunAjaran);
            
            if ($semester) {
                $q->where('semester', $semester);
            }
        });
    }

    // =====================================================
    // ACCESSOR & MUTATOR
    // =====================================================

    /**
     * Get full name with NISN
     */
    public function getFullIdentityAttribute(): string
    {
        return "{$this->nama_siswa} ({$this->nisn})";
    }

    /**
     * Get foto URL
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('photos/' . $this->foto))) {
            return asset('photos/' . $this->foto);
        }
        
        // Default avatar berdasarkan jenis kelamin
        if ($this->jenis_kelamin === 'Laki-laki') {
            return asset('images/default-avatar-male.png');
        } elseif ($this->jenis_kelamin === 'Perempuan') {
            return asset('images/default-avatar-female.png');
        }
        
        return asset('images/default-avatar.png');
    }

    /**
     * Get age from tanggal lahir
     */
    public function getUmurAttribute(): ?int
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        
        return $this->tanggal_lahir->age;
    }

    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'non-aktif' => '<span class="badge badge-secondary">Non-aktif</span>',
            'lulus' => '<span class="badge badge-info">Lulus</span>',
            'pindah' => '<span class="badge badge-warning">Pindah</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-secondary">-</span>';
    }

    /**
     * Get jenis kelamin badge
     */
    public function getJenisKelaminBadgeAttribute(): string
    {
        if ($this->jenis_kelamin === 'Laki-laki') {
            return '<span class="badge badge-info">Laki-laki</span>';
        } elseif ($this->jenis_kelamin === 'Perempuan') {
            return '<span class="badge badge-pink">Perempuan</span>';
        }
        
        return '-';
    }

    // =====================================================
    // HELPER METHODS
    // =====================================================

    /**
     * Check if siswa has account
     */
    public function hasAccount(): bool
    {
        return $this->akun()->exists();
    }

    /**
     * Check if siswa is aktif
     */
    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    /**
     * Get current kelas
     */
    public function getCurrentKelas()
    {
        return $this->kelasSiswa()
                    ->with('kelas')
                    ->latest('tahun_ajaran')
                    ->latest('semester')
                    ->first();
    }

    /**
     * Get total tabungan saldo
     */
    public function getTotalSaldo(): float
    {
        return $this->tabungan()
                    ->where('jenis_transaksi', 'setor')
                    ->sum('jumlah') 
               - $this->tabungan()
                    ->where('jenis_transaksi', 'tarik')
                    ->sum('jumlah');
    }

    /**
     * Get total prestasi
     */
    public function getTotalPrestasi(): int
    {
        return $this->prestasi()->count();
    }

    // =====================================================
    // EVENTS
    // =====================================================

    /**
     * Boot method - Register model events
     */
    protected static function boot()
    {
        parent::boot();

        // Before creating
        static::creating(function ($siswa) {
            // Auto-generate NISN if not provided
            if (empty($siswa->nisn)) {
                $siswa->nisn = static::generateNISN();
            }
        });

        // After deleting
        static::deleting(function ($siswa) {
            // Delete related data
            $siswa->kelasSiswa()->delete();
            $siswa->krs()->delete();
            
            // Delete foto if exists
            if ($siswa->foto && file_exists(public_path('photos/' . $siswa->foto))) {
                @unlink(public_path('photos/' . $siswa->foto));
            }
        });
    }

    /**
     * Generate unique NISN
     */
    private static function generateNISN(): string
    {
        do {
            $nisn = date('Y') . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('nisn', $nisn)->exists());

        return $nisn;
    }

    // =====================================================
    // STATIC HELPER METHODS
    // =====================================================

    /**
     * Get siswa count by sekolah
     */
    public static function countBySekolah($idSekolah): int
    {
        return static::where('id_sekolah', $idSekolah)->count();
    }

    /**
     * Get siswa count by kelas
     */
    public static function countByKelas($idKelas): int
    {
        return static::whereHas('kelasSiswa', function($q) use ($idKelas) {
            $q->where('id_kelas', $idKelas);
        })->count();
    }

    /**
     * Get siswa gender statistics
     */
    public static function getGenderStats(): array
    {
        return [
            'laki_laki' => static::where('jenis_kelamin', 'Laki-laki')->count(),
            'perempuan' => static::where('jenis_kelamin', 'Perempuan')->count(),
            'total' => static::count()
        ];
    }

    /**
     * Get siswa status statistics
     */
    public static function getStatusStats(): array
    {
        return static::selectRaw('status, COUNT(*) as total')
                     ->groupBy('status')
                     ->pluck('total', 'status')
                     ->toArray();
    }
}