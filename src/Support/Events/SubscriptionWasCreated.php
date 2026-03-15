<?php

namespace VueFileManager\Subscription\Support\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use VueFileManager\Subscription\Domain\Subscriptions\Models\Subscription;

class SubscriptionWasCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Subscription $subscription
    ) {}
}
