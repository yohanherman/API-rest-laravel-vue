<?php

namespace App\Http\Controllers\V1;

use App\Models\booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class pdfController extends Controller
{
    public function downloadPdf(int $id)
    {
        // genereting a ticket using dompdf
        $datas = DB::table('bookings')
            ->join('places', 'places.id', '=', 'bookings.place_id')
            ->join('users', 'users.id', '=', 'bookings.user_id')
            ->select('places.*', 'bookings.created_at', 'users.name')
            ->where('place_id', $id)
            ->get();
        // dd($datas);
        $pdf = Pdf::loadView('pdf.ticketPdf', ['datas' => $datas]);
        return $pdf->download('ticket.pdf');
    }
}
