<?php

namespace App\Filament\Widgets;

use App\Models\Stock;
use Filament\Widgets\ChartWidget;

class TopPerformersChart extends ChartWidget
{
    protected ?string $heading = 'Top 5 Best Performers (by Price Gain)';

    protected function getData(): array
    {
        // Fetch distinct companies and calculate gains
        $top5 = Stock::select('company')
            ->distinct()
            ->get()
            ->map(function ($s) {
                $first = Stock::where('company', $s->company)
                    ->orderBy('date', 'asc')
                    ->first();

                $last = Stock::where('company', $s->company)
                    ->orderBy('date', 'desc')
                    ->first();

                return (object) [
                    'company' => $s->company,
                    'gain' => $last->price - $first->price,
                ];
            })
            ->sortByDesc('gain')
            ->take(5);

        return [
            'datasets' => [
                [
                    'label' => 'Price Gain',
                    'data' => $top5->pluck('gain')->toArray(),
                    'backgroundColor' => [
                        '#4ade80', // green
                        '#60a5fa', // blue
                        '#fbbf24', // amber
                        '#f87171', // red
                        '#a78bfa', // purple
                    ],
                ],
            ],
            'labels' => $top5->pluck('company')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Chart.js bar chart
    }
}
