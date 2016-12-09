<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewChatMessage extends Event implements ShouldBroadcast
{
    use SerializesModels;

	public $id;
	public $cid;
	public $sid;
	public $msg;
	public $img;
	public $name;
	public $whichuser;
	
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id,$msg,$img,$sid,$name,$whichuser,$cid)
    {
        $this->msg=$msg;
		$this->id=$id;
		$this->cid=$cid;
		$this->sid=$sid;
		$this->img=$img;
		$this->name=$name;
		$this->whichuser=$whichuser;
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
