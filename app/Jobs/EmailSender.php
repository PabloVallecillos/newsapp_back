<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->onQueue('emails');
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details = $this->details;
        try {
            $send = new $details['class'](...$details['arguments']);
            if (isset($details['addressees'])) {
                Mail::to($details['addressees'])->send($send);
            } else {
                Mail::send($send);
            }
            if (Mail::failures()) {
                $this->fail();
            }
        } catch (Exception $e) {
            $this->fail($e);
        }
    }
}
