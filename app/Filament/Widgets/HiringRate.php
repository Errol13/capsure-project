<?php

namespace App\Filament\Widgets;

use App\Models\Hiring\Event;
use Filament\Widgets\ChartWidget;

class HiringRate extends ChartWidget
{
    protected static ?string $heading = 'Event Post\'s Hiring Rate';

    protected static ?string $pollingInterval = '10s';

    protected static ?int $sort = 3;

    protected static string $color = 'indigo';

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        // Get the total number of event posts
        $totalEventPosts = Event::count();

        // Get the number of events with successful hires
        $totalPostsWithHired = Event::whereHas('transactions')->count();

        // Avoid division by zero
        $totalHiringRate = $totalEventPosts > 0
            ? round(($totalPostsWithHired / $totalEventPosts) * 100, 2)
            : 0;

        // Calculate the remaining percentage (events without hires)
        $remainingHiringRate = 100 - $totalHiringRate;

        return [
            'datasets' => [
                [
                    'label' => 'Hiring Success Rate',
                    'data' => [$totalHiringRate, $remainingHiringRate], // Success vs No Hiring yet
                    'backgroundColor' => ['#36A2EB', '#FF6384'], // Colors for doughnut segments
                    'borderColor' => ['#9BD0F5', '#FFB1C1'],   
                    'borderWidth' => 1,
                    'hoverOffset' => 4, 
                ],
            ],
            'labels' => [
                'Events With Hired Freelancers (' . $totalHiringRate . '%)', // Label for the first segment with percentage
                'Events With No Hired Freelancers (' . $remainingHiringRate . '%)', // Label for the second segment with percentage
            ], 
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'datalabels' => [
                    'display' => true,
                    'color' => '#fff',
                    'font' => [
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'formatter' => function ($value, $context) {
                        // Format value as a percentage
                        $total = array_sum($context->chart->data->datasets[0]->data);
                        return $total > 0 ? round(($value / $total) * 100) . '%' : '0%';
                    },
                ],
            ],
            'maintainAspectRatio' => false,
            'responsive' => true,
        ];
    }
    



    protected function getType(): string
    {
        return 'doughnut';
    }
}
