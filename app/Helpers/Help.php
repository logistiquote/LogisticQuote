<?php

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

function send_notify_user_mail($user_id, $partner_id, $quotation_id)
{
    $user = User::findOrFail($user_id)->toArray();
    $partner = User::findOrFail($partner_id)->toArray();
    $to_name = $user['name'];
    $to_email = $user['email'];
    // $to_email = 'malickateeq@gmail.com';
    $quotation = Quotation::findOrFail($quotation_id)->toArray();


    $data = array(
                "partner" => $partner,
            // "company_name" => "LogistiQuote",
            // "email"=> "test@sdf.com",
            // "additional_email" => "asd@ad.com",
            // "phone" => "12345678",
            // "body" => "Blah blah blah!"
        );

    Mail::send('emails.notify_user', $data, function($message) use ($to_name, $to_email, $quotation)
    {
        $message->to($to_email, $to_name)
        ->subject('Quotation#: '.$quotation['quotation_id'].' completion.');
        $message->from(
            env("MAIL_FROM_ADDRESS", "cs@logistiquote.com"),   // Mail from email address
            'Quotation#'.$quotation['quotation_id'].'\'s completed | LogistiQuote'   // Title, Subject
        );
    });
}
