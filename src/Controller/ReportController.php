<?php

namespace App\Controller;

use App\Entity\Audit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends AbstractController
{
    #[Route('/report/{id}', name: 'audit_report')]
    public function report(Audit $audit): Response
    {
        return $this->render('pages/audit/report.html.twig', [
            'audit' => $audit,
        ]);
    }
}