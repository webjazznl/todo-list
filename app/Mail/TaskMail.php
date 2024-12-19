<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    /**
     * Create a new message instance. Include the task
     */
    public function __construct(Task $task)
    {
        //
        $this->task = $task;
    }



    /**

     * Build the message.

     *

     * @return $this

     */

    public function build()

    {

        return $this->subject('Taak verlopen: ' . $this->task->title)

            ->view('emails.task');
    }
}
