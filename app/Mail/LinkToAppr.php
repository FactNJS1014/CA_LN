<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkToAppr extends Mailable
{
    use Queueable, SerializesModels;
    public $linkToAppr;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($linkToAppr)
    {
        $this->linkToAppr = $linkToAppr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link_input = $this->linkToAppr['link'];
        return $this->from('Production_CA_Appr@aoth.in.th')
        ->subject('Approve Data Line Call ')
        ->markdown('Mails.mailAppr',['linkin' => $link_input]);
    }
}
