<?php

namespace CubyBase\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SystemDebugEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $subject;
    public $content;
    public $debug;

    /**
     * Create a new event instance.
     *
     * @param String $_sender
     * @param String $_subject
     * @param String $_content
     * @param $_debug
     */
    public function __construct(String $_sender, String $_subject, String $_content, $_debug)
    {
        $this->sender = $_sender;
        $this->subject = $_subject;
        $this->content = $_content;
        $this->debug = $_debug;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('System');
    }
}
