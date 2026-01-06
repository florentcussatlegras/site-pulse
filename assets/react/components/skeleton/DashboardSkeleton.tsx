// asset\react\components/skeleton\DashboardSkeleton.tsx

import Card from "../ui/Card";

function ScoreCardSkeleton() {
    return (
        <div className="rounded-2xl border-neutral-200 bg-color-card shadow-soft p-4 space-y-3 animate-pulse">
            {/* Label */}
            <div className="h-4 bg-neutral-200 rounded w-1/3" />

            {/* Score */}
            <div className="h-8 bg-neutral-200 rounded w-1/2" />

            {/* Progress bar */}
            <div className="h-2 bg-neutral-200 rounded w-full" />

            {/* Badge */}
            <div className="h-5 bg-neutral-200 rounded w-20" />
        </div>
    );
}

export default function DashboardSkeleton() {
    return (
        <Card className="w-full max-w-6xl">
            {/* Titre centré */}
            <div className="flex justify-center mb-6">
                <div className="h-6 bg-neutral-200 rounded w-64 animate-pulse" />
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                {[1, 2, 3, 4].map((i) => (
                    <ScoreCardSkeleton key={i} />
                ))}
            </div>
        </Card>
    );
}
