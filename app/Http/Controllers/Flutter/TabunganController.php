<?php

namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\BukuTabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    public function history(Request $request)
    {
        $user = $request->user();
        $count = $request->input('count');

        $query = TransaksiTabungan::with(['jenisTransaksi', 'bukuTabungan.jenisTabungan'])
            ->join('tb_buku_tabungan', 'tb_transaksi_tabungan.id_buku_tabungan', '=', 'tb_buku_tabungan.id_buku_tabungan')
            ->where('tb_buku_tabungan.id_siswa', $user->id_siswa)
            ->select([
                'tb_transaksi_tabungan.*',
                'tb_buku_tabungan.id_siswa',
                'tb_buku_tabungan.id_jenis_tabungan',
                'tb_buku_tabungan.saldo as saldo_terakhir'
            ])
            ->orderBy('tb_transaksi_tabungan.tanggal_transaksi', 'desc')
            ->orderBy('tb_transaksi_tabungan.id_transaksi', 'desc');

        if ($count) {
            $query->take($count);
        }

        $transactions = $query->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->id_transaksi,
                    'id_buku_tabungan' => $transaction->id_buku_tabungan,
                    'id_siswa' => $transaction->id_siswa,
                    'id_jenis_tabungan' => $transaction->id_jenis_tabungan,
                    'jenis_transaksi' => $transaction->jenis_transaksi,
                    'type' => $transaction->jenis_transaksi, // For Flutter compatibility
                    'jumlah' => (float) $transaction->jumlah,
                    'keterangan' => $transaction->keterangan,
                    'saldo_sebelum' => (float) $transaction->saldo_sebelum,
                    'saldo_sesudah' => (float) $transaction->saldo_sesudah,
                    'tanggal' => $transaction->tanggal_transaksi,
                    'tanggal_transaksi' => $transaction->tanggal_transaksi,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                    'saldo' => (float) $transaction->saldo_terakhir,
                    'jenis_tabungan' => $transaction->bukuTabungan->jenisTabungan->nama_jenis_tabungan ?? 'Tabungan',
                ];
            });

        return response()->json($transactions);
    }

    public function getSaldo(Request $request)
    {
        $user = $request->user();
        
        $totalSaldo = DB::table('tb_buku_tabungan')
            ->where('id_siswa', $user->id_siswa)
            ->sum('saldo');

        return response()->json([
            'saldo' => (float) ($totalSaldo ?? 0)
        ]);
    }

    public function getIncomeExpenses(Request $request)
    {
        $user = $request->user();
        
        $totals = TransaksiTabungan::select(
                DB::raw('SUM(CASE WHEN tb_transaksi_tabungan.jenis_transaksi = "setor" THEN tb_transaksi_tabungan.jumlah ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN tb_transaksi_tabungan.jenis_transaksi = "tarik" THEN tb_transaksi_tabungan.jumlah ELSE 0 END) as total_expenses')
            )
            ->join('tb_buku_tabungan', 'tb_transaksi_tabungan.id_buku_tabungan', '=', 'tb_buku_tabungan.id_buku_tabungan')
            ->where('tb_buku_tabungan.id_siswa', $user->id_siswa)
            ->first();

        return response()->json([
            'total_income' => (float) ($totals->total_income ?? 0),
            'total_expenses' => (float) abs($totals->total_expenses ?? 0)
        ]);
    }
    
    // The user prompt includes a latestHistory method, which is not in the original controller.
    // I will add it here based on the existing history method.
    public function latestHistory(Request $request)
    {
        $user = $request->user();
        $count = $request->input('count', 5);

        $query = TransaksiTabungan::with(['jenisTransaksi', 'bukuTabungan.jenisTabungan'])
            ->join('tb_buku_tabungan', 'tb_transaksi_tabungan.id_buku_tabungan', '=', 'tb_buku_tabungan.id_buku_tabungan')
            ->where('tb_buku_tabungan.id_siswa', $user->id_siswa)
            ->select([
                'tb_transaksi_tabungan.*',
                'tb_buku_tabungan.id_siswa',
                'tb_buku_tabungan.id_jenis_tabungan',
                'tb_buku_tabungan.saldo as saldo_terakhir'
            ])
            ->orderBy('tb_transaksi_tabungan.tanggal_transaksi', 'desc')
            ->orderBy('tb_transaksi_tabungan.id_transaksi', 'desc');

        $transactions = $query->take($count)->get()
            ->map(function($transaction) {
                return [
                    'id' => $transaction->id_transaksi,
                    'id_buku_tabungan' => $transaction->id_buku_tabungan,
                    'id_siswa' => $transaction->id_siswa,
                    'id_jenis_tabungan' => $transaction->id_jenis_tabungan,
                    'jenis_transaksi' => $transaction->jenis_transaksi,
                    'type' => $transaction->jenis_transaksi, // For Flutter compatibility
                    'jumlah' => (float) $transaction->jumlah,
                    'keterangan' => $transaction->keterangan,
                    'saldo_sebelum' => (float) $transaction->saldo_sebelum,
                    'saldo_sesudah' => (float) $transaction->saldo_sesudah,
                    'tanggal' => $transaction->tanggal_transaksi,
                    'tanggal_transaksi' => $transaction->tanggal_transaksi,
                    'created_at' => $transaction->created_at,
                    'updated_at' => $transaction->updated_at,
                    'saldo' => (float) $transaction->saldo_terakhir,
                    'jenis_tabungan' => $transaction->bukuTabungan->jenisTabungan->nama_jenis_tabungan ?? 'Tabungan',
                ];
            });

        return response()->json($transactions);
    }
}
