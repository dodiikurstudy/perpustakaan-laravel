<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function create(Borrowing $borrowing)
    {
        // CEK PEMILIK
        if($borrowing->user_id != auth()->id()){

            abort(403);

        }


        return view(
            'user.payment',
            compact('borrowing')
        );
    }


    public function store(Request $request, Borrowing $borrowing)
{

    // CEK PEMILIK
    if($borrowing->user_id != auth()->id()){

        abort(403);

    }


    // CEK DENDA
    if($borrowing->denda <= 0){

        return back()
            ->with('error','Tidak ada denda');

    }


    // VALIDASI BUKTI
    $request->validate([

        'bukti' => [
            'required',
            'image',
            'max:2048'
        ]

    ]);


    // SIMPAN FILE
    $bukti = $request->file('bukti')
        ->store(
            'bukti-pembayaran',
            'public'
        );


    // SIMPAN PEMBAYARAN
    Payment::create([

        'user_id' => auth()->id(),

        'borrowing_id' => $borrowing->id,

        'jumlah' => $borrowing->denda,

        'bukti' => $bukti,

        'status' => 'menunggu',

    ]);


    return redirect()
        ->route('fines')
        ->with(
            'success',
            'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi admin.'
        );

}

}