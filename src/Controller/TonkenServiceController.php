<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\JWSProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TonkenServiceController extends AbstractController
{
    private $jwtProvider;
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager ,JWSProviderInterface $jwtProvider) 
    {
        $this->$jwtManager = $jwtManager;
        $this->jwtProvider =$jwtProvider;
    }

    public function cheackToken() {

    }
}

