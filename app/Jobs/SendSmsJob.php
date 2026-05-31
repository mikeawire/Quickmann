<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Str;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data =$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //send sms

    $this->sendSms(intval($this->data['phone']),$this->data['body']);
    }


 public function sendSms($recipient, $message)
{
    $url = 'https://sms.vanso.com/rest/sms/submit/long'; // Replace with your API endpoint
    $username = 'NG.103.0124';
    $password = 'KTp86MTJ';

    $postData = [
        "sms" => [
            "dest" => $recipient,
            "referenceId" => Str::random(10),
            "src" => "ISWTest",
            "text" => $message,
            "unicode" => false
        ],
        "account" => [
            "password" => $password,
            "systemId" => $username
        ]
    ];

    $response = Http::withBasicAuth($username, $password)
        ->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])
        ->post($url, $postData);

    // Get the response body or other details
    $responseBody = $response->body();
    $status = $response->status();

    // Handle the response or return it as needed
}
    
  
}