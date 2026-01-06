// assets/react/components/skeleton/ReportSkeleton.tsx
import Card from "../ui/Card";

export default function ReportSkeleton() {
  return (
    <section className="min-h-screen bg-content px-4 py-10 w-full space-y-8">

      {/* Header */}
      <div className="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between mb-8 space-y-4 sm:space-y-0">
        <div className="h-6 w-64 bg-neutral-200 rounded animate-pulse"></div>
        <div className="h-10 w-32 bg-neutral-200 rounded animate-pulse"></div>
      </div>

      {/* Résumé */}
      <Card className="max-w-6xl mx-auto space-y-2 mb-8">
        <div className="h-5 w-18 bg-neutral-200 rounded animate-pulse"></div>
        <div className="h-4 w-full bg-neutral-200 rounded animate-pulse"></div>
        <div className="h-4 w-5/6 bg-neutral-200 rounded animate-pulse"></div>
      </Card>

      {/* Scores */}
      <Card className="max-w-6xl mx-auto mb-8">
        <div className="h-6 w-48 bg-neutral-200 rounded mx-auto mb-6 animate-pulse"></div>
        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
          {[1,2,3,4].map(i => (
            <div key={i} className="p-4 bg-neutral-200 rounded-lg animate-pulse h-32"></div>
          ))}
        </div>
      </Card>

      {/* Recommandations */}
      <Card className="max-w-6xl mx-auto space-y-4 mb-8">
        <div className="h-6 w-64 bg-neutral-200 rounded animate-pulse"></div>
        <ul className="space-y-2">
          {[1,2,3,4].map(i => (
            <li key={i} className="h-4 w-full bg-neutral-200 rounded animate-pulse"></li>
          ))}
        </ul>
      </Card>

      {/* CTA */}
      <div className="flex justify-center mb-10">
        <div className="h-10 w-32 bg-neutral-200 rounded animate-pulse"></div>
      </div>
    </section>
  );
}
