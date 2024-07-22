<?php

namespace App\Service;

use Facebook\Facebook;
use Psr\Log\LoggerInterface;

class FacebookService
{
    private $facebook;
    private $logger;
    private $accessToken;

    public function __construct(LoggerInterface $logger, string $appId, string $appSecret, string $accessToken)
    {
        $this->logger = $logger;
        $this->facebook = new Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v13.0',
            'default_access_token' => $accessToken,
        ]);
    }

    public function postToFacebook(string $productName, string $message, string $link)
    {
        if (!$productName)
            return false;

        try {
            $response = $this->facebook->post('/me/feed', [ 'message' => $message, 'link' => $link ]);
            $this->logger->info('Publier sur FACEBOOK le produit "' . $productName .'"');
            return 'Publier sur TWITTER le produit "' . $productName .'"';
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->logger->error('Graph returned an error: ' . $e->getMessage());
            return 'Graph returned an error: ' . $e->getMessage();
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->logger->error('Facebook SDK returned an error: ' . $e->getMessage());
            return 'Facebook SDK returned an error: ' . $e->getMessage();

        }
    }
}
