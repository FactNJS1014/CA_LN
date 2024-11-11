<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkToInput extends Mailable
{
    use Queueable, SerializesModels;
    public $linkToInput;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($linkToInput)
    {
        $this->linkToInput = $linkToInput;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link_input = $this->linkToInput['link'];
        return $this->from('Production_CA@aoth.in.th')
        ->subject('Line Call-CA')
        ->markdown('Mails.mailLink',['linkin' => $link_input]);
    }
}
