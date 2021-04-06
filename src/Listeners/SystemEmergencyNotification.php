<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemEmergencyEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemEmergencyNotification
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
     * @param  SystemEmergencyEvent  $event
     * @return void
     */
    public function handle(SystemEmergencyEvent $event)
    {
        Log::emergency(sprintf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
