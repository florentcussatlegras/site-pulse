<?php

namespace App\Service;

class AuditRunner
{
    public function run(string $url): array
    {
        $html = @file_get_contents($url);

        if ($html === false) {
            return $this->failedAudit("Impossible d’analyser cette URL.");
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);

        $recommendations = [];

        // 🔍 SEO
        $hasTitle = $xpath->query('//title')->length > 0;
        if (!$hasTitle) {
            $recommendations[] = "Ajouter une balise <title> pour améliorer le SEO.";
        }

        $hasMetaDescription = $xpath->query('//meta[@name="description"]')->length > 0;
        if (!$hasMetaDescription) {
            $recommendations[] = "Ajouter une meta description pertinente.";
        }

        // ♿ Accessibilité
        $images = $xpath->query('//img');
        $imagesWithoutAlt = 0;
        foreach ($images as $img) {
            if (!$img->hasAttribute('alt')) {
                $imagesWithoutAlt++;
            }
        }

        if ($imagesWithoutAlt > 0) {
            $recommendations[] = "Ajouter des attributs alt aux images.";
        }

        // ⚡ Performance (approximatif mais crédible)
        $htmlSizeKb = strlen($html) / 1024;
        if ($htmlSizeKb > 500) {
            $recommendations[] = "Réduire la taille HTML de la page.";
        }

        // 🎯 Scores (simples mais cohérents)
        $seo = 100;
        if (!$hasTitle) $seo -= 30;
        if (!$hasMetaDescription) $seo -= 20;

        $accessibility = max(100 - ($imagesWithoutAlt * 10), 40);
        $performance = $htmlSizeKb < 300 ? 90 : 60;
        $bestPractices = 85;

        return [
            'performance' => $performance,
            'seo' => $seo,
            'accessibility' => $accessibility,
            'bestPractices' => $bestPractices,
            'recommendations' => $recommendations,
        ];
    }

    private function failedAudit(string $message): array
    {
        return [
            'performance' => 0,
            'seo' => 0,
            'accessibility' => 0,
            'bestPractices' => 0,
            'recommendations' => [$message],
        ];
    }
}
