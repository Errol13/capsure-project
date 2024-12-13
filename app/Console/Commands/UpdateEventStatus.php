<?php

namespace App\Console\Commands;

use App\Models\Hiring\Event;
use Illuminate\Console\Command;

class UpdateEventStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-event-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the events that are due to closed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find events where the end_date is in the past and the status is not already "Closed"
        $events = Event::where('end_date', '<', now())->where('status', '!=', 'Closed')->get();

        // Update their status
        foreach ($events as $event) {
            $event->status = 'Closed';
            $event->save();
            $this->info("Event ID {$event->event_id} has been marked as Closed.");
        }

        $this->info('Event status update completed.');
    }
}
