<?php
namespace App\Traits;
use Illuminate\Support\Facades\Http ;
use Firebase\JWT\JWT;

trait SendNotificationTrait
{

    public function sendNotification($user,$title,$body=null)
    {


        $now = time();
        $payload = [
            "iss" => config('notification.client_email'),
            "sub" => config('notification.client_email'),
            "aud" => config('notification.token_uri'),
            "iat" => $now,
            "exp" => $now + 3600,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging"
        ];

        $jwt = JWT::encode($payload, config('notification.private_key'), 'RS256');

        // Exchange JWT for an OAuth2 token
        
        $result = Http::post(config('token_uri'), [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ],
        ]);

        $authToken = json_decode($result->getBody(), true)['access_token'];

        $message = [
            "message" => [
                "token" => $user->token,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                ],
                "data" => [
                    "custom_key" => 'custom_value',
                ],
                "android" => [
                    "priority" => "HIGH",
                    "notification" => [
                        "channel_id" => "default_channel_id",
                        "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                    ]
                ]
            ]
        ];

        $response = Http::post('https://fcm.googleapis.com/v1/projects/' . config('notification.project_id') . '/messages:send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $authToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $message,
        ]);
    }
}
?>