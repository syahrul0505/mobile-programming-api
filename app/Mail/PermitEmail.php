<?php

namespace App\Mail;

use App\Models\Permit;
use App\Models\StokMasuk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermitEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['permit'] = Permit::latest()->first();
        if ($data['permit']) {
            return $this->view('inventory.stok-masuk.email', $data);
        } else {
            // Handle the case when no permit is found
            return 'No permit found.';
        }
    }
}
