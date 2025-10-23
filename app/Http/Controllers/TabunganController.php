<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\TransaksiTabungan; // Assuming TransaksiTabungan model exists
use App\Http\Resources\TransaksiTabunganResource;

class TabunganController extends Controller
{
    /**
     * Centralized method to fetch transaction history with optional limit.
     *
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function fetchTransactionHistory(?int $limit = null)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            // This should ideally be handled by middleware, but as a fallback
            abort(Response::json(['status' => 'error', 'message' => 'Unauthenticated.'], 401));
        }

        $authenticatedUser = Auth::user();

        // Assuming the authenticated user has a relationship to TransaksiTabungan
        // or we can find transactions based on user's ID via BukuTabungan.
        // This part might need adjustment based on your specific model relationships.
        // For simplicity, let's assume TransaksiTabungan has a direct or indirect link to the user.
        // If 'BukuTabungan' links to 'User' and 'TransaksiTabungan' links to 'BukuTabungan',
        // you'd do something like:
        // $bukuTabunganIds = $authenticatedUser->bukuTabungan()->pluck('id_buku_tabungan');
        // $query = TransaksiTabungan::whereIn('id_buku_tabungan', $bukuTabunganIds);

        // For now, let's assume a direct link or a simplified approach for demonstration.
        // This will need to be refined based on actual model relationships.
        $query = TransaksiTabungan::query(); // Start with a base query

        // Apply limit if provided
        if ($limit !== null) {
            $query->take($limit);
        }

        return $query->orderBy('tanggal_transaksi', 'desc');
    }

    /**
     * Get paginated transaction history for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function history(Request $request)
    {
        $transactions = $this->fetchTransactionHistory()->paginate(15); // Paginate with 15 items per page

        return TransaksiTabunganResource::collection($transactions);
    }

    /**
     * Get the latest 3 transaction history records for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function latestHistory(Request $request)
    {
        $transactions = $this->fetchTransactionHistory(3)->get(); // Get latest 3 transactions

        return TransaksiTabunganResource::collection($transactions);
    }
}
