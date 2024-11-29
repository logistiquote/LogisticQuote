<?php
use App\Quotation;
use App\Proposal;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Carbon helper
 *
 * @param $time
 * @param $tz
 *
 * @return Carbon\Carbon
 */
function is_offer_made($partner_id = null, $quotation_id = null)
{
    $proposal_available = Proposal::where('partner_id', $partner_id)
    ->where('quotation_id', $quotation_id)->count();
    return $proposal_available;
}

function is_proposal_expired($proposal_id = null)
{
    $proposal = Proposal::where('id', $proposal_id)->first();
    $now = Carbon::now();
    $start_date = Carbon::parse($proposal->created_at);
    $end_date = Carbon::parse($proposal->valid_till);

    $flag = true;
    if($now->between($start_date,$end_date)){
        $flag = false; // Not Expired
    } else {
        $flag = true; // Expired
    }
    return $flag;
}
function carbon_format($timestamp, $format)
{
    $carbon_date = Carbon::parse($timestamp);
    $formatted_date = $carbon_date->format($format);
    return $formatted_date;
}

function send_proposal_mail($user_id, $quotation_id)
{
    $user = User::findOrFail($user_id);
    $to_name = $user->name;
    $to_email = $user->email;
    // $to_email = 'malickateeq@gmail.com';
    $proposals = Proposal::where('user_id', $user_id)
    ->where('status', 'active')
    ->where('quotation_id', $quotation_id)->with('vendor')->get()->toArray();
     
    $quotation = Quotation::findOrFail($quotation_id);

    // dd($proposals);
    
    $data = array(
            "proposals" => $proposals,
        );

    Mail::send('emails.proposal', $data, function($message) use ($to_name, $to_email, $quotation) 
    {
        $message->to($to_email, $to_name)
        ->subject('Proposals received related to Quotation#: '.$quotation['quotation_id']);
        $message->from(
            env("MAIL_FROM_ADDRESS", "cs@logistiquote.com"),   // Mail from email address
            'Quotation#'.$quotation['quotation_id'].' proposals | LogistiQuote'   // Title, Subject
        );
    });
}

function send_accept_proposal_mail($user_id, $partner_id, $quotation_id)
{
    $user = User::findOrFail($user_id)->toArray();
    $partner = User::findOrFail($partner_id)->toArray();
    $to_name = $partner['name'];
    $to_email = $partner['email'];
    // $to_email = 'malickateeq@gmail.com';
    $quotation = Quotation::findOrFail($quotation_id)->toArray();

    
    $data = array(
                "user" => $user,
            // "company_name" => "LogistiQuote", 
            // "email"=> "test@sdf.com", 
            // "additional_email" => "asd@ad.com", 
            // "phone" => "12345678", 
            // "body" => "Blah blah blah!"
        );

    Mail::send('emails.accept_proposal', $data, function($message) use ($to_name, $to_email, $quotation) 
    {
        $message->to($to_email, $to_name)
        ->subject('Proposals accepted of Quotation#: '.$quotation['quotation_id']);
        $message->from(
            env("MAIL_FROM_ADDRESS", "cs@logistiquote.com"),   // Mail from email address
            'Quotation#'.$quotation['quotation_id'].'\'s proposal accepted | LogistiQuote'   // Title, Subject
        );
    });
}

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

function notify_vendor_for_new_quotation($user_id, $quotation_id)
{
    $user = User::findOrFail($user_id)->toArray();

    $partners = User::where('role', 'vendor')->get()->toArray();
    $quotation = Quotation::findOrFail($quotation_id)->toArray();

    foreach($partners as $partner)
    {
        $to_name = $partner['name'];
        $to_email = $partner['email'];
        
        $data = array(
                    "quotation" => $quotation,
                // "company_name" => "LogistiQuote", 
                // "email"=> "test@sdf.com", 
                // "additional_email" => "asd@ad.com", 
                // "phone" => "12345678", 
                // "body" => "Blah blah blah!"
            );
    
        Mail::send('emails.quote_requested', $data, function($message) use ($to_name, $to_email, $quotation) 
        {
            $message->to($to_email, $to_name)
            ->subject( $quotation['quotation_id'].': a user has just posted a quote.');
            $message->from(
                env("MAIL_FROM_ADDRESS", "cs@logistiquote.com"),   // Mail from email address
                'New quote requested by LogistiQuote user | LogistiQuote'   // Title, Subject
            );
        });
    }
}