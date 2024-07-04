<?php

namespace App\Providers;

use App\Events\DocumentSharedNotificationEvent;
use App\Events\DocumentShareEvent;
use App\Events\RegistrationVerificationEvent;
use App\Listeners\DocumentSharedNotificationListener;
use App\Listeners\DocumentShareListener;
use App\Listeners\RegistrationVerificationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        RegistrationVerificationEvent::class => [
            RegistrationVerificationListener::class,
        ],

        DocumentShareEvent::class => [
            DocumentShareListener::class,
        ],

        DocumentSharedNotificationEvent::class => [
            DocumentSharedNotificationListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
