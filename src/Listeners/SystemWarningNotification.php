<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemWarningEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemWarningNotification
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
     * @param  SystemWarningEvent  $event
     * @return void
     */
    public function handle(SystemWarningEvent $event)
    {
        Log::warning(sprintf('[%s][%s]%s - %s. %s',date('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
