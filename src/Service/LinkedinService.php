<?php

namespace App\Service;

use Happyr\LinkedIn\LinkedIn;
use Happyr\LinkedIn\Exception;
use Psr\Log\LoggerInterface;

class LinkedinService
{
    private $linkedIn;
    private $logger;

    public function __construct(LoggerInterface $logger, string $clientId, string $clientSecret, string $redirectUri)
    {
        $this->linkedIn = new LinkedIn($clientId, $clientSecret);
    }

    public function getAuthenticationUrl(): string
    {
        return $this->linkedIn->getLoginUrl(['scope' => 'r_liteprofile r_emailaddress w_member_social']);
    }

    public function getAccessToken(string $authorizationCode): string
    {
        return $this->linkedIn->getAccessToken($authorizationCode);
    }

    public function postUpdate(string $productName, string $accessToken, string $message): array
    {
        if (!$productName)
            return false;

        $this->linkedIn->setAccessToken($accessToken);
        try {
            return $this->linkedIn->post('ugcPosts', [
                'author' => 'urn:li:person:your_person_urn',
                'lifecycleState' => 'PUBLISHED',
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $message . ' ' . $productName
                        ],
                        'shareMediaCategory' => 'NONE'
                    ]
                ],
                'visibility' => [
                    'com.linkedin.ugc.MemberNetworkVisibility' => 'PUBLIC'
                ]
            ]);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
