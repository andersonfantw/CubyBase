<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemCriticalEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemCriticalNotification
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
     * @param  SystemCriticalEvent  $event
     * @return void
     */
    public function handle(SystemCriticalEvent $event)
    {
        Log::critical(springf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
