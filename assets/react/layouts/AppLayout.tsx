// assets\react\layouts\Applayout.tsx

import { Outlet, Link } from "react-router-dom";
import Card from "../components/ui/Card";
import { useEffect, useRef, useState } from "react";
import Button from "../components/ui/Button";
import Badge from "../components/ui/Badge";
import Dashboard from "../pages/Dashboard";
import DashboardSkeleton from "../components/skeleton/DashboardSkeleton";
import Brand from "../components/ui/Brand";

type AuditResults = {
    performance: number;
    seo: number;
    accessibility: number;
    bestPractices: number;
};

function auditSummary(results: AuditResults) {
    if (results.performance < 70)
        return "Votre site peut nettement gagner en performance.";
    if (results.seo < 75)
        return "Votre SEO est perfectible avec quelques optimisations.";
    return "Votre site est globalement bien optimisé 👍";
}

export default function AppLayout() {
    const steps = [
        "Analyse de la performance…",
        "Vérification SEO…",
        "Audit accessibilité…",
        "Bonnes pratiques…",
    ];

    const [stepIndex, setStepIndex] = useState(0);
    const [url, setUrl] = useState("");
    const [isLoading, setIsLoading] = useState(false);
    const [results, setResults] = useState<AuditResults | null>(null);
    const [auditId, setAuditId] = useState<number | null>(null);

    const resultRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (isLoading || results) {
            resultRef.current?.scrollIntoView({ behavior: "smooth" });
        }
    }, [isLoading, results]);

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();

        setIsLoading(true);
        setResults(null);
        setStepIndex(0);

        // Animation des étapes côté client
        const intervalSteps = setInterval(() => {
            setStepIndex((i) => {
                if (i < steps.length - 1) return i + 1;
                return i;
            });
        }, 500);

        try {
            // Création de l’audit côté serveur
            const response = await fetch("/api/audits/run", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ url }),
            });
            const audit = await response.json();
            setIsLoading(false);
            setAuditId(audit.id);
            setResults(audit);
        } catch (err) {
            console.error(err);
            setIsLoading(false);
            clearInterval(intervalSteps);
        }
    };

    return (
        <>
            {/* Formulaire URL */}
            <Card className="w-full max-w-xl">
                <form
                    onSubmit={handleSubmit}
                    className="flex flex-col sm:flex-row gap-2"
                >
                    <input
                        type="url"
                        value={url}
                        onChange={(e) => setUrl(e.target.value)}
                        placeholder="https://exemple.com"
                        required
                        className="flex-1 rounded-xl border border-neutral-200 p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    />
                    <Button type="submit" disabled={isLoading}>
                        {isLoading ? "Audit en cours…" : "Lancer l’audit"}
                    </Button>
                </form>
            </Card>

            {/* Message de progression */}
            {isLoading && (
                <p className="text-sm text-neutral-600 animate-pulse mt-2">
                    {steps[Math.min(stepIndex, steps.length - 1)]}
                </p>
            )}

            {/* Point d’ancrage pour le scroll */}
            <div ref={resultRef} />

            {/* Skeleton pendant chargement */}
            {isLoading && <DashboardSkeleton />}

            {/* Résultats */}
            {results && <Dashboard results={results} />}

            {results && (
                <Card className="max-w-xl text-center space-y-2">
                    <p className="text-lg font-semibold">
                        {auditSummary(results)}
                    </p>
                    <Link to={`/report/${auditId}`}>
                        <Button className="transition transform hover:scale-105">
                            Voir le rapport détaillé
                        </Button>
                    </Link>
                </Card>
            )}
        </>
    );
}
