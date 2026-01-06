// assets/react/pages/Dashboard.tsx

import Card from '../components/ui/Card';
import ScoreCard from '../components/dashboard/ScoreCard';
import DashboardSkeleton from '../components/skeleton/DashboardSkeleton';

type Props = {
  results: {
    performance: number;
    seo: number;
    accessibility: number;
    bestPractices: number;
  };
};

export default function Dashboard({ results }: Props) {
  if (!results) return <DashboardSkeleton />;

  return (
    <Card className="w-full max-w-6xl">
      <h2 className="text-xl font-bold mb-6 text-primary">Aperçu du dashboard</h2>

      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <ScoreCard label="Performance" score={results.performance} />
        <ScoreCard label="SEO" score={results.seo} />
        <ScoreCard label="Accessibilité" score={results.accessibility} />
        <ScoreCard label="Bonnes pratiques" score={results.bestPractices} />
      </div>
    </Card>
  );
}

