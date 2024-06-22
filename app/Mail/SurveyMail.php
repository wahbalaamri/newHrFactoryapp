<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SurveyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    public function __construct($data)
    {
        //
        $this->data = $data;
    }
    public function build()
    {
        try{
            //attach to the view the data
            
            return $this->subject($this->data['subject'])->view('surveys.sendSurvey')->with($this->data);
        }
        catch (\Exception $e)
        {
            //log error
        }
    }
    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Survey Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
