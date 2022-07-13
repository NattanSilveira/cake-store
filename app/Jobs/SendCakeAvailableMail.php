<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Cake;
use App\Models\WaitingList;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCakeAvailableMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $cake;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cake)
    {
        $this->cake = $cake;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cake = Cake::find($this->cake->id);

        if ($cake->qtd_disponivel > 0) {

            WaitingList::where('cake_id', $cake->id)->where('send_email', 1)->chunk(300, function ($email) use ($cake) {
               foreach ($email as $mail) {
                   Mail::send(new SendMail($cake, $mail));
               }
            });

        }

    }
}
