<?php

namespace CubyBase\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use CubyBase\Events\SystemEmergencyEvent;
use CubyBase\Events\SystemAlertEvent;
use CubyBase\Events\SystemCriticalEvent;
use CubyBase\Events\SystemErrorEvent;
use CubyBase\Events\SystemWarningEvent;
use CubyBase\Events\SystemNoticeEvent;
use CubyBase\Events\SystemInfoEvent;
use CubyBase\Events\SystemDebugEvent;
use CubyBase\Listeners\SystemEmergencyNotification;
use CubyBase\Listeners\SystemAlertNotification;
use CubyBase\Listeners\SystemCriticalNotification;
use CubyBase\Listeners\SystemErrorNotification;
use CubyBase\Listeners\SystemWarningNotification;
use CubyBase\Listeners\SystemNoticeNotification;
use CubyBase\Listeners\SystemInfoNotification;
use CubyBase\Listeners\SystemDebugNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SystemEmergencyEvent::class => [
            SystemEmergencyNotification::class
        ],
        SystemAlertEvent::class => [
            SystemAlertNotification::class
        ],
        SystemCriticalEvent::class => [
            SystemCriticalNotification::class
        ],
        SystemErrorEvent::class => [
            SystemErrorNotification::class
        ],
        SystemWarningEvent::class => [
            SystemWarningNotification::class
        ],
        SystemNoticeEvent::class => [
            SystemNoticeNotification::class
        ],
        SystemInfoEvent::class => [
            SystemInfoNotification::class
        ],
        SystemDebugEvent::class => [
            SystemDebugNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
