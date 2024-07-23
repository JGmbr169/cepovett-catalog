<?php

// src/Service/TwitterService.php
namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Psr\Log\LoggerInterface;

class TwitterService
{
    private $twitter;
    private $logger;

    public function __construct(LoggerInterface $logger, string $apiKey, string $apiSecretKey, string $accessToken, string $accessTokenSecret)
    {
        $this->logger = $logger;
        $this->twitter = new TwitterOAuth($apiKey, $apiSecretKey, $accessToken, $accessTokenSecret);
    }

    public function publishTweet(string $productName, string $message)
    {   
        if (!$productName)
            return false;

        $result = $this->twitter->post("statuses/update", ["status" => $message]);

        if ($this->twitter->getLastHttpCode() == 200) {
            $this->logger->info('Publier sur TWITTER le produit "' . $productName .'"');
            return 'Publier sur TWITTER le produit "' . $productName .'"';
        } else {
            $this->logger->info('Error posting tweet "' . $productName .'"');
            return 'Error posting tweet: ' . $productName;
        }
    }
}
