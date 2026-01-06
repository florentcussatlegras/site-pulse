<?php

// src/Controller/Api/AuditController.php

namespace App\Controller\Api;

use App\Entity\Audit;
use App\Repository\AuditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Service\AuditRunner;

#[Route('/api/audits')]
class AuditController extends AbstractController
{
    #[Route('', name: 'api_audit_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $audit = new Audit();
        $audit->setUrl($data['url'] ?? '');
        $audit->setPerformance($data['performance'] ?? 0);
        $audit->setSeo($data['seo'] ?? 0);
        $audit->setAccessibility($data['accessibility'] ?? 0);
        $audit->setBestPractices($data['bestPractices'] ?? 0);
        $audit->setRecommendations($data['recommendations'] ?? []);

        $em->persist($audit);
        $em->flush();

        return $this->json([
            'audit' => $audit
        ]);
    }

    #[Route('/run', name: 'api_audit_run', methods: ['POST'])]
    public function run(
        Request $request,
        EntityManagerInterface $em,
        AuditRunner $auditRunner
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        // dd($request->getContent());
        $url = $data['url'] ?? null;

        if (!$url) {
            return $this->json(['error' => 'URL manquante'], 400);
        }

        $result = $auditRunner->run($url);

        $audit = new Audit();
        $audit->setUrl($url);
        if ($this->getUser()) {
            $audit->setUser($this->getUser());
        }
        $audit->setPerformance($result['performance']);
        $audit->setSeo($result['seo']);
        $audit->setAccessibility($result['accessibility']);
        $audit->setBestPractices($result['bestPractices']);
        $audit->setRecommendations($result['recommendations']);

        $em->persist($audit);
        $em->flush();

        return $this->json([
            'id' => $audit->getId(),
            'performance' => $audit->getPerformance(),
            'seo' => $audit->getSeo(),
            'accessibility' => $audit->getAccessibility(),
            'bestPractices' => $audit->getBestPractices(),
        ]);

    }

    #[Route('/show/{id}', name: 'api_audit_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id, AuditRepository $auditRepository): JsonResponse
    {
        $audit = $auditRepository->find($id);

        if (!$audit) {
            return $this->json(['error' => 'Audit non trouvé'], 404);
        }

        return $this->json([
            'id' => $audit->getId(),
            'url' => $audit->getUrl(),
            'performance' => $audit->getPerformance(),
            'seo' => $audit->getSeo(),
            'accessibility' => $audit->getAccessibility(),
            'bestPractices' => $audit->getBestPractices(),
            'recommendations' => $audit->getRecommendations(), // array de strings
        ]);
    }
}
