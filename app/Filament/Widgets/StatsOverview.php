<?php

namespace App\Filament\Widgets;

use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Transaction\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected static ?int $sort = 2;
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

        // Get total count of users excluding the admin
        $totalUsers = User::where('user_type', '!=', 'admin')->count();

        $totalEvents = Event::all()->count();

        $totalJobs = EventJob::all()->count();

        $totalTransactions = Transaction::all()->count();

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

            Stat::make('Event Posts', $totalEvents)
                ->description('Total number of events posted')
                ->descriptionIcon('heroicon-s-calendar')
                ->color('primary'),

            Stat::make('Jobs Posted', $totalJobs)
                ->description('Total number of jobs posted')
                ->descriptionIcon('heroicon-s-briefcase')
                ->color('primary'),

            Stat::make('Transactions', $totalTransactions)
                ->description('Total number of transactions')
                ->descriptionIcon('heroicon-s-credit-card')
                ->color('primary'),
        ];
    }

    protected function getColumns(): int
    {
        return 3; // Defines two columns per row
    }
}
