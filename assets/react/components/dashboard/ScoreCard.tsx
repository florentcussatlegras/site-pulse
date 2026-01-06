// assets\react:components\dashboard\ScoreCard.tsx

import Card from "../ui/Card";
import Badge from "../ui/Badge";
import { scoreMeta } from "../../utils/scoreMeta";
import { useAnimatedNumber } from "../../hooks/useAnimatedNumber";
import ProgressBar from "../ui/ProgressBar";

type Props = {
    label: string;
    score: number;
};

export default function ScoreCard({ label, score }: Props) {
    const animatedScore = useAnimatedNumber(score);
    const meta = scoreMeta(score);

    return (
        <Card className="p-4 shadow-soft transition hover:scale-[1.02] space-y-2 hover:shadow-lg border border-color-card">
            <span className="text-sm font-semibold text-neutral-500">
                {label}
            </span>

            <p
                className={`text-3xl font-bold mt-1 ${meta.text} transition-colors`}
            >
                {animatedScore}%
            </p>

            <ProgressBar value={animatedScore} color={meta.color} />

            <Badge
                className={`${meta.bg} ${
                    meta.text
                } transition-all duration-500 ${
                    animatedScore > 0
                        ? "opacity-100 scale-100"
                        : "opacity-0 scale-95"
                }`}
            >
                {meta.label}
            </Badge>
        </Card>
    );
}
