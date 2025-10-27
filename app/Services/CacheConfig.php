<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * Cache Configuration Helper
 * Centralized cache management untuk konsistensi
 */
class CacheConfig
{
    // Cache TTL (Time To Live) dalam detik
    const TTL_SHORT = 300;      // 5 menit - untuk data yang sering berubah
    const TTL_MEDIUM = 1800;    // 30 menit - untuk data semi-statis
    const TTL_LONG = 3600;      // 1 jam - untuk data statis
    const TTL_VERY_LONG = 86400; // 24 jam - untuk master data

    // Cache Tags untuk easy flush
    const TAG_SISWA = 'siswa';
    const TAG_GURU = 'guru';
    const TAG_KELAS = 'kelas';
    const TAG_SEKOLAH = 'sekolah';
    const TAG_MASTER = 'master_data';

    /**
     * Generate cache key untuk siswa list
     */
    public static function siswaListKey(int $page, int $limit, string $search = '', string $sekolahId = '', string $kelasId = ''): string
    {
        $searchHash = $search ? md5($search) : 'all';
        return "siswa_list_p{$page}_l{$limit}_s{$searchHash}_sk{$sekolahId}_k{$kelasId}";
    }

    /**
     * Generate cache key untuk siswa detail
     */
    public static function siswaDetailKey(int $idSiswa): string
    {
        return "siswa_detail_{$idSiswa}";
    }

    /**
     * Clear all siswa cache
     */
    public static function clearSiswaCache(): void
    {
        // Flush by pattern (untuk Redis/Memcached)
        if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
            Cache::tags([self::TAG_SISWA])->flush();
        } else {
            // Fallback: Clear specific keys (untuk file cache)
            Cache::flush(); // Nuclear option, tapi aman untuk development
        }
    }

    /**
     * Clear all master data cache (Sekolah, Kelas, etc)
     */
    public static function clearMasterCache(): void
    {
        Cache::tags([self::TAG_MASTER, self::TAG_SEKOLAH, self::TAG_KELAS])->flush();
    }

    /**
     * Remember with automatic tagging
     */
    public static function remember(string $key, int $ttl, callable $callback, array $tags = [])
    {
        if (empty($tags)) {
            return Cache::remember($key, $ttl, $callback);
        }

        return Cache::tags($tags)->remember($key, $ttl, $callback);
    }

    /**
     * Forget specific cache key
     */
    public static function forget(string $key): bool
    {
        return Cache::forget($key);
    }
}