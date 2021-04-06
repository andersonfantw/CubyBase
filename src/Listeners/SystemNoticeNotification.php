<?php

namespace CubyBase\Listeners;

use CubyBase\Events\SystemNoticeEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SystemNoticeNotification
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
     * @param  SystemNoticeEvent  $event
     * @return void
     */
    public function handle(SystemNoticeEvent $event)
    {
        Log::notice(sprintf('[%s][%s]%s - %s. %s',datetime('Y-m-d H:i:s'), $event->sender, $event->subject, $event->content, print_r($event->debug)));
    }
}
