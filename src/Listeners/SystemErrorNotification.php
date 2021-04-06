<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemErrorEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemErrorNotification
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
     * @param  SystemErrorEvent  $event
     * @return void
     */
    public function handle(SystemErrorEvent $event)
    {
        Log::error(sprintf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
