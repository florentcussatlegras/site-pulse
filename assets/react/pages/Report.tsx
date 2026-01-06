// assets\react\pages\Report.tsx

import { useParams, Link } from "react-router-dom";
import Card from "../components/ui/Card";
import Button from "../components/ui/Button";
import ScoreCard from "../components/dashboard/ScoreCard";
import PageTransition from "../components/ui/PageTransition";
import Brand from "../components/ui/Brand";
import { useEffect, useState } from "react";
import ReportSkeleton from "../components/skeleton/ReportSkeleton";

type AuditResults = {
    performance: number;
    seo: number;
    accessibility: number;
    bestPractices: number;
    recommendations: string[];
    url: string;
};

export default function Report() {
    const { id } = useParams();

    const [results, setResults] = useState<AuditResults | null>(null);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        if (!id) return;

        setIsLoading(true);
        fetch(`/api/audits/show/${id}`)
            .then((res) => {
                if (!res.ok) throw new Error("Audit non trouvé");
                return res.json();
            })
            .then((data) => {
                setResults(data);
                setIsLoading(false);
            })
            .catch((err) => {
                setError(err.message);
                setIsLoading(false);
            });
    }, [id]);

    if (isLoading || !results)
        return (
            <PageTransition>
                <ReportSkeleton />
            </PageTransition>
        );
    if (error)
        return (
            <PageTransition>
                <p className="text-center mt-20 text-red-600">{error}</p>
            </PageTransition>
        );
    if (!results) return null;

    return (
        <PageTransition>
            <section className="min-h-screen bg-content px-4 py-10 w-full">

                {/* Header */}
                <div className="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between mb-8">
                    <h1 className="text-2xl font-bold mb-4 sm:mb-0 text-primary">
                        Rapport d’audit
                    </h1>

                    <Link to="/">
                        <Button variant="outline" className="text-button-secondary bg-button-secondary border-color-button-secondary border cursor-pointer">← Nouvel audit</Button>
                    </Link>
                </div>

                {/* Résumé global */}
                <Card className="max-w-6xl mx-auto text-center space-y-2 mb-8 bg-card-color rounded-2xl">
                    <h2 className="text-xl font-semibold text-primary">Résumé</h2>
                    <p className="text-neutral-600">
                        {results.recommendations.length > 0
                            ? "Des optimisations sont recommandées pour améliorer les performances de votre site."
                            : "Votre site est bien optimisé selon nos critères actuels."}
                    </p>
                </Card>

                {/* Scores */}
                <Card className="max-w-6xl mx-auto mb-8">
                    <h2 className="text-lg font-bold mb-6 text-center text-primary">
                        Scores par catégorie
                    </h2>
                    <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                        <ScoreCard
                            label="Performance"
                            score={results.performance}
                        />
                        <ScoreCard label="SEO" score={results.seo} />
                        <ScoreCard
                            label="Accessibilité"
                            score={results.accessibility}
                        />
                        <ScoreCard
                            label="Bonnes pratiques"
                            score={results.bestPractices}
                        />
                    </div>
                </Card>

                {/* Recommandations */}
                <Card className="max-w-6xl mx-auto space-y-4 mb-8">
                    <h2 className="text-lg font-bold text-primary">
                        Recommandations prioritaires
                    </h2>
                    <ul className="space-y-2 text-neutral-700">
                        {results.recommendations.length === 0 && (
                            <li className="text-green-600 font-medium">
                                🎉 Aucune recommandation critique détectée
                            </li>
                        )}

                        {results.recommendations.map((rec, index) => (
                            <li key={index}>• {rec}</li>
                        ))}
                    </ul>
                </Card>

                {/* CTA final */}
                <div className="flex justify-center mb-10">
                    <Link to="/">
                        <Button>Relancer un audit</Button>
                    </Link>
                </div>
            </section>
        </PageTransition>
    );
}
