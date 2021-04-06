<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemInfoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemInfoNotification
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
     * @param  SystemInfoEvent  $event
     * @return void
     */
    public function handle(SystemInfoEvent $event)
    {
        Log::info(sprintf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
