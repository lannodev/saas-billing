<?php

namespace VueFileManager\Subscription\App\Scheduler;

use VueFileManager\Subscription\Domain\Subscriptions\Models\Subscription;
use VueFileManager\Subscription\Support\Events\SubscriptionWasExpired;

class HaltExpiredSubscriptionsSchedule
{
    public function __invoke()
    {
        Subscription::where('status', 'cancelled')
            ->where('type', 'fixed')
            ->whereDate('ends_at', today())
            ->get()
            ->each(function ($subscription) {
                // Update status
                $subscription->update([
                    'status' => 'completed',
                ]);

                // Dispatch event
                SubscriptionWasExpired::dispatch($subscription);
            });
    }
}
