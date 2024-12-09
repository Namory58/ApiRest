<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\JWSProviderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class TokenServiceController extends AbstractController
{
    private JWTTokenManagerInterface $jwtManager;
    private JWSProviderInterface $jwtProvider;
    private $userRepository;

    public function __construct(JWTTokenManagerInterface $jwtManager, JWSProviderInterface $jwtProvider, UserRepository $user)
    {
        $this->jwtManager = $jwtManager;
        $this->jwtProvider = $jwtProvider;
        $this->userRepository = $user;
    }

    public function cheackToken(Request $request)
    {
        if ($request->headers->has("Authorization")) {
            $data = explode(" ", $request->headers->get("Authorization"));
            if (count($data) === 2) {
                $token = $data[1];
                try {
                    //récuperation des information du token
                    $currentUserToken = $this->jwtProvider->load($token);
                    dd($currentUserToken->getPayload());
                    if (count($currentUserToken->getPayload()) === 4) {
                        if ($currentUserToken->isVerified()) {
                            $currentUser = $this->userRepository->findOneBy(["eamil" => $currentUserToken->getPayload()["email"]]);
                            //dd($currentUser);
                            return ($currentUser) ? $currentUser : false;
                        }
                    }
                } catch (\Throwable $th) {
                    return false;
                }
            }
        }
        return false;
    }

    public function sendJsonErrorToken(): JsonResponse
    {
        return $this->json([
            'error' => true,
            'message' => "Authentification requise. Vous devez être connecté pour effectuer cette action."
        ], 401);
    }
}
