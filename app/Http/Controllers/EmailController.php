<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportEmail;

class EmailController extends Controller
{
    public function index(){
        $emailAddress = 'support@example.com'; // Email penerima
        $subject = 'Dukungan Pelanggan'; // Subjek email
        return view('email.email', compact('emailAddress', 'subject'));
    }

    public function sendEmail(Request $request)
    {
        $emailAddress = 'support@example.com'; // Email penerima
        $subject = 'Dukungan Pelanggan'; // Subjek email
        
        // Kirim email menggunakan kelas SupportEmail
        Mail::to($emailAddress)->send(new SupportEmail($subject));

        return redirect()->back()->with('status', 'Email terkirim!');
    }
}


namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportEmail extends Mailable
{
    use SerializesModels;

    public $subject;

    // Constructor untuk menerima parameter subject
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    // Fungsi build() untuk mendefinisikan isi email
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('email.email');  // Ganti dengan view email Anda
    }
}
