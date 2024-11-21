<?php

namespace App\Jobs;

use App\Models\Profile\Report;
use App\Models\Profile\Suspension;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ArchiveReportJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $reportId;

    /**
     * Create a new job instance.
     *
     * @param int $reportId
     */
    public function __construct(int $reportId)
    {
        $this->reportId = $reportId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find the report and archive it
        $report = Report::find($this->reportId);
        if ($report) {
            $report->isArchived = true;
            $report->save();
        }

        // Find the user's suspension and lift it
        $suspension = Suspension::where('user_id', $report->reported_user_id)->first();
        if ($suspension && $suspension->isSuspended) {
            $suspension->isSuspended = false;
            $suspension->start_at= null;
            $suspension->end_at = null;
            $suspension->suspended_reason = null;
            $suspension->save();
        }
    }
}
