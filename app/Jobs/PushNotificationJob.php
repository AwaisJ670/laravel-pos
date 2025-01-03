<?php

namespace App\Jobs;

use Google\Client;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\InteractsWithQueue;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use Google\Service\FirebaseCloudMessaging;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $notification;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param string $deviceId
     * @param string $title
     * @param string $message
     */

    public function __construct($users, $notification, $data)
    {
        $this->users = $users;
        $this->notification = $notification;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            Log::info('Push notification job started');
            $android = [
                "priority" => "high",
            ];

            $client = new Client();
            $storagePath  = Storage::path('fcm_credentials.json');

            if (file_exists($storagePath)) {
                $client->setAuthConfig($storagePath);
            } else {
                return $this->errorResponse(['error' => 'File Error: fcm_credentials.json not found'], 500);
            }

            $client->setApplicationName('Saver Enterprises');
            $client->addScope(FirebaseCloudMessaging::CLOUD_PLATFORM);
            $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

            $notificationArray = [];
            foreach ($this->users as $user) {
                $fields = [
                    "message" => [
                        "token" => $user['fcm_token'],
                        "notification" => $this->notification,
                        "data" => $this->data,
                        "android" => $android,
                    ]
                ];

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->post('https://fcm.googleapis.com/v1/projects/saver-enterprises/messages:send', $fields);

                $jsonResponse = $response->json();

                if ($response->successful()) {
                    Log::info($this->data['notification_type'] . ' | Push notification sent successfully to user_id: ' . $user['id']);
                    $notificationArray[] = [
                        'user_id' => $user['id'],
                        'send_datetime' => getCurrentServerDateTime(),
                        'title' => $this->notification['title'],
                        'message' => $this->notification['body'],
                        'is_sent' => 1,
                        'fcm_success_message' => $jsonResponse['name'],
                    ];
                } else {
                    Log::error($this->data['notification_type'] . ' | Notification not sent to user_id: ' .$user['id'] . ' | FCM Error ' . $jsonResponse['error']['message']);
                    $notificationArray[] = [
                        'user_id' => $user['id'],
                        'send_datetime' => getCurrentServerDateTime(),
                        'title' => $this->notification['title'],
                        'message' => $this->notification['body'],
                        'is_sent' => 0,
                        'fcm_failure_message' => $jsonResponse['error']['message'],
                    ];
                }
            }

            Notification::insert($notificationArray);

            Log::info('Data saved into Notification Table Successfully');
            Log::info('Push notification job handled successfully');

        } catch (\Exception $e){
            Log::error('Push notification job failed: ' . $e->getMessage());
        }
    }
}
