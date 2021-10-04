<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemDebugEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemDebugNotification
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
     * @param  SystemDebugEvent  $event
     * @return void
     */
    public function handle(SystemDebugEvent $event)
    {
        Log::debug(sprintf('[%s][%s]%s - %s. %s',date('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
