<?php
// src/Controller/TestDbController.php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestDbController extends AbstractController
{
    #[Route('/api/db-test', name: 'app_db_test')]
    public function dbTest(Connection $connection): JsonResponse
    {
        try {
            // Tentative de connexion et récupération d'une simple requête
            $result = $connection->fetchOne('SELECT 1');
            return new JsonResponse(['status' => 'success', 'result' => $result]);
        } catch (\Exception $e) {
            return new JsonResponse(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}

