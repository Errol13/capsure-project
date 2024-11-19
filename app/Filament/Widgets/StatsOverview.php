<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';
    
    protected function getStats(): array
    {
        // Get count of verified freelancers
        $verifiedFreelancers = User::where('isVerified', true)
            ->where('user_type', 'freelancer')
            ->count();
        
        // Get total count of freelancers
        $totalFreelancers = User::where('user_type', 'freelancer')
            ->count();

        // Get count of verified clients
        $verifiedClients = User::where('isVerified', true)
            ->where('user_type', 'client')
            ->count();
        
        // Get total count of clients
        $totalClients = User::where('user_type', 'client')
            ->count();

        // Get total count of users 
        $totalUsers = User::count();

        return [
            Stat::make('Verified Freelancers', "{$verifiedFreelancers}/{$totalFreelancers}")
                ->description('Number of verified freelancers')
                ->descriptionIcon('heroicon-s-users')
                ->color('info'),

            Stat::make('Verified Clients', "{$verifiedClients}/{$totalClients}")
                ->description('Number of verified clients')
                ->descriptionIcon('heroicon-s-users')
                ->color('info'),

            Stat::make('Users', $totalUsers)
                ->description('Total number of Capsure users')
                ->descriptionIcon('heroicon-s-users')
                ->color('primary'),
        ];
    }
}
