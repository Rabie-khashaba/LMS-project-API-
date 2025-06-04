<?php

namespace App\Services;
use Google\Auth\OAuth2;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseV1NotificationService
{
    protected string $projectId;
    protected string $credentialsPath;

    public function __construct()
    {
        $this->credentialsPath = storage_path('app/firebase/service-account.json');
        $this->projectId = json_decode(file_get_contents($this->credentialsPath), true)['project_id'];
    }

    protected function getAccessToken(): string
    {
        $oauth = new OAuth2([
            'audience' => 'https://oauth2.googleapis.com/token',
            'scope' => ['https://www.googleapis.com/auth/firebase.messaging'],
            'issuer' => json_decode(file_get_contents($this->credentialsPath), true)['client_email'],
            'signingAlgorithm' => 'RS256',
            'signingKey' => file_get_contents($this->credentialsPath),
        ]);

        $oauth->setGrantType('urn:ietf:params:oauth:grant-type:jwt-bearer');
        $oauth->fetchAuthToken();

        if (!isset($token['access_token'])) {
            throw new \Exception('Failed to fetch Firebase access token.');
        }

        return $oauth->getLastReceivedToken()['access_token'];
    }

    public function sendNotification(string $deviceToken, string $title, string $body): array
    {
        try {
            $accessToken = $this->getAccessToken();

           // Log::info("Access token: " . $accessToken);

            $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

            $payload = [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ]
                ]
            ];

            $response = Http::withToken($accessToken)->post($url, $payload);

          //  Log::info("FCM Response", $response->json());

            return $response->json();
        } catch (\Exception $e) {
            Log::error("FCM Error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

}
