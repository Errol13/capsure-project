<?php

namespace App\Filament\Widgets;

use App\Models\Profile\Service;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Log;

class EventsCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Freelancer\'s Category';

    protected static ?string $pollingInterval = '10s';

    protected static ?int $sort = 3;

    protected static string $color = 'indigo';

    protected function getData(): array
    {
        // Get all distinct job categories from the Service table
        $categories = Service::pluck('job_category')->unique();
    
        // Count freelancers for each category
        $categoryCounts = $categories->map(function ($category) {
            return Service::where('job_category', $category)
                ->whereHas('freelancer')
                ->count();
        });
    
        // Convert collections to arrays
        $categoryCountsArray = $categoryCounts->toArray();
        $categoriesArray = $categories->toArray();
    
        // Log data before passing to chart
        Log::info('Categories Array:', $categoriesArray);
        Log::info('Category Counts Array:', $categoryCountsArray);
    
        // Prepare chart data
        return [
            'datasets' => [
                [
                    'label' => 'Freelancers by Category',
                    'data' => array_values($categoryCountsArray), 
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => array_values($categoriesArray),  
        ];
    }
    

    protected function getType(): string
    {
        return 'bar';  
    }
}
