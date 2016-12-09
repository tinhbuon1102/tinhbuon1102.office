<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewChatNotificaion extends Event implements ShouldBroadcast
{
    use SerializesModels;
	public $id;
	public $uid;
	public $name;
	public $message;
	public $created;
	public $photo;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id,$uid,$name,$message,$created,$photo)
    {
		$this->id=$id;
		$this->uid=$uid;
		$this->name=$name;
		$this->message=$message;
		$this->created=$created;
		$this->photo=$photo;
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['private-chat-'.$this->id];
    }
}
