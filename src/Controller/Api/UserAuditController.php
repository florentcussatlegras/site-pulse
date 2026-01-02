<?php
// src/Controller/Api/UserAuditController.php

namespace App\Controller\Api;

use App\Repository\AuditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/me/audits')]
class UserAuditController extends AbstractController
{
    #[Route('', name: 'api_user_audits', methods: ['GET'])]
    public function index(AuditRepository $auditRepository): JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Non connecté'], 401);
        }

        $audits = $auditRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);

        $data = array_map(fn($audit) => [
            'id' => $audit->getId(),
            'url' => $audit->getUrl(),
            'performance' => $audit->getPerformance(),
            'seo' => $audit->getSeo(),
            'accessibility' => $audit->getAccessibility(),
            'bestPractices' => $audit->getBestPractices(),
            'createdAt' => $audit->getCreatedAt()?->format('Y-m-d H:i'),
        ], $audits);

        return $this->json($data);
    }
}
