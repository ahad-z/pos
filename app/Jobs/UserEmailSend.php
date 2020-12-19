<?php

namespace App\Jobs;
use App\Mail\ForgetPasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserEmailSend implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $url;
    public $email;
    public function __construct($url, $email)
    {
        $this->url = $url;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            \Mail::to($this->email)->send(new ForgetPasswordMail($this->url));
        }catch(\Exception $e){
            return response([
                'status' => true,
                'message' => $e
            ]);
        }
    }
}
