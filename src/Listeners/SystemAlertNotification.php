<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemAlertEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemAlertNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SystemAlertEvent  $event
     * @return void
     */
    public function handle(SystemAlertEvent $event)
    {
        Log::alert(springf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
