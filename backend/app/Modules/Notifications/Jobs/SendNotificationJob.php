<?php

namespace App\Modules\Notifications\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Modules\Notifications\Models\LmsNotification;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private LmsNotification $notification) {}

    public function handle(): void
    {
        // Integration with WA/Email API would go here
        
        $this->notification->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);
    }
}
