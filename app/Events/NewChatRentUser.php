<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewChatRentUser extends Event implements ShouldBroadcast
{
    use SerializesModels;
	public $uid;
	public $sid;
	public $cid;
	public $name;
	public $logo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($uid,$sid,$cid,$name,$logo)
    {
		$this->uid=$uid;
		$this->sid=$sid;
		$this->cid=$cid;
		$this->name=$name;
		$this->logo=$logo;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['private-chat-'.$this->uid];
    }
}
