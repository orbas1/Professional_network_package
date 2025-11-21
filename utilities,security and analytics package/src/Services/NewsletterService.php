<?php

namespace ProNetwork\Services;

use ProNetwork\Models\NewsletterSubscription;

class NewsletterService
{
    public function subscribe(string $email, ?int $userId = null): NewsletterSubscription
    {
        return NewsletterSubscription::updateOrCreate(['email' => $email], [
            'user_id' => $userId,
            'subscribed' => true,
        ]);
    }

    public function unsubscribe(string $email): NewsletterSubscription
    {
        return NewsletterSubscription::updateOrCreate(['email' => $email], [
            'subscribed' => false,
        ]);
    }
}
