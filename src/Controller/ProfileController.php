<?php

namespace App\Controller;

use App\Entity\Audit;
use App\Repository\AuditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile', name: 'app_profile')]
class ProfileController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(EntityManagerInterface $em, AuditRepository $auditRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        // Récupérer les audits liés à cet utilisateur, par date décroissante
        $audits = $auditRepository->findBy(
            ['user' => $this->getUser()],       // filtre par utilisateur
            ['createdAt' => 'DESC'], // tri par date décroissante
            20                        // limiter aux 20 derniers
        );

        return $this->render('pages/profile/index.html.twig', [
            'audits' => $audits,
        ]);
    }
}
