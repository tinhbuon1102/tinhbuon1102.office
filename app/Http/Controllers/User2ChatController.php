<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User2;
use App\User1;
use App\Chat;
use App\Chatmessage;
use App\User2requirespace;
use Session;
use Mail;
use Config;
use Auth;
use Response;
use App\Events\NewChatMessage;
use App\Events\NewChatRentUser;
use App\Events\NewChatNotificaion;
use Illuminate\Support\Facades\App;
use Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class User2ChatController extends Controller
{
	public function __construct(){
		$this->middleware('user2');

		if (Auth::guard('user2')->check() && Auth::guard('user2')->user()->IsAdminApproved == 'No')
		{
			return Response::make('Forbidden',403);
		}
	}

	public function auth(Request $request)
	{
		if(\Auth::guard('user2')->check() && $request->channel_name=="private-chat-".Auth::guard('user2')->user()->HashCode)
		{
			$pusher = App::make('Pusher',[getenv('PUSHER_KEY'),getenv('PUSHER_SECRET') ,getenv('PUSHER_APP_ID')]);
			echo $pusher->socket_auth($request->channel_name, $request->socket_id);
		}
		else
		{
			return Response::make('Forbidden',403);
		}
	}

	public function message()
	{
		//
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode]);
		$chatusers=Chat::where('User2ID','=', Auth::guard('user2')->user()->HashCode)->orderBy('LastMsgDateTime', 'DESC')->get();
		return view('chat.message-shareuser',compact('chatusers','chat'));
	}
	public function messageUser($id)
	{
		$user=User1::firstOrNew([
				'HashCode' => $id,
				]);

		if (!$user->exists) {
			return redirect('/RentUser/Dashboard/Message');
		}
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode,
				'User1ID' => $id,
				]);
		if ($chat->exists) {
			//echo "Chat Exist";
		} else {
			$chat->User2ID=Auth::guard('user2')->user()->HashCode;
			$chat->User1ID=$id;
			$chat->HashID=uniqid();
			$chat->save();

			$nm=$chat->user2->LastName." ".$chat->user2->FirstName;
			if(!empty($chat->user2->Logo))
				$logo=$chat->user1->Logo;
			else
				$logo='/images/man-avatar.png';
			Cache::forget('instantChatUsers-'.Auth::guard('user2')->user()->HashCode);
			Cache::forget('instantChatUsers-'.$id);
			event (new NewChatRentUser($id,Auth::guard('user2')->user()->HashCode,$chat->id,$nm,$logo));

		}
		$chatusers=Chat::where('User2ID','=', Auth::guard('user2')->user()->HashCode)->get();

		return view('chat.message-shareuser',compact('chatusers','chat'));

	}
	public function getMessages($id)
	{
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode,
				'id' => $id,
				]);
		if (!$chat->exists) {
			return '';
		}
		if(!empty($chat->user2->Logo))
			$logo2=$chat->user2->Logo;
		elseif($chat->user2->Sex=='女性')
		$logo2='/images/woman-avatar.png';
		else
			$logo2='/images/man-avatar.png';
			
		if(!empty($chat->user1->Logo))
			$logo1=$chat->user1->Logo;
		else
			$logo1='/images/man-avatar.png';
			

		$msgs=Chatmessage::where('ChatID',  $id)->get();
		Chatmessage::where('ChatID',  $id)->where('User2ID',  '')->update(['IsRead' => 'Yes']);

		//return($msg);
		return view('chat.messages',compact('msgs','logo1','logo2'));

	}

	public function getInstantMessages($id)
	{
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode,
				'id' => $id,
				]);
		if (!$chat->exists) {
			return '';
		}
		if(!empty($chat->user2->Logo))
			$logo2=$chat->user2->Logo;
		elseif($chat->user2->Sex=='女性')
		$logo2='/images/woman-avatar.png';
		else
			$logo2='/images/man-avatar.png';
			
		if(!empty($chat->user1->Logo))
			$logo1=$chat->user1->Logo;
		else
			$logo1='/images/man-avatar.png';
			

		$msgs=Chatmessage::where('ChatID',  $id)->get();
		Chatmessage::where('ChatID',  $id)->where('User2ID',  '')->update(['IsRead' => 'Yes']);

		//return($msg);
		return view('chat.instant-msg',compact('msgs','logo1','logo2'));

	}

	
	public function getInstantMessagesByUser($id)
	{
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode,
				'User1ID' => $id,
				]);
		if (!$chat->exists) {
			$chat->User1ID=$id;
			$chat->User2ID=Auth::guard('user2')->user()->HashCode;
			$chat->HashID=uniqid();
			$chat->save();
		}
		if(!empty($chat->user2->Logo))
			$logo2=$chat->user2->Logo;
		elseif($chat->user2->Sex=='女性')
		$logo2='/images/woman-avatar.png';
		else
			$logo2='/images/man-avatar.png';
			
		if(!empty($chat->user1->Logo))
			$logo1=$chat->user1->Logo;
		else
			$logo1='/images/man-avatar.png';
			

		$msgs=Chatmessage::where('ChatID',  $chat->id)->get();
		Chatmessage::where('ChatID',  $chat->id)->where('User2ID',  '')->update(['IsRead' => 'Yes']);

		//return($msg);
		return view('chat.instant-msg',compact('msgs','logo1','logo2'));

	}

	
	public function sendMessage(Request $request)
	{
		$chat=Chat::firstOrNew([
				'User2ID' => Auth::guard('user2')->user()->HashCode,
				'User1ID' => $request->id,
				]);
		$Chatmessage=new Chatmessage();
		$Chatmessage->ChatID=$chat->id;
		$Chatmessage->Message=$request->text;
		$Chatmessage->Sender="User2";
		$Chatmessage->User2ID=Auth::guard('user2')->user()->HashCode;
		$Chatmessage->save();


		$user=User1::firstOrNew([
				'HashCode' => $request->id,
				]);
		$name=$user->LastName." ".$user->FirstName;
		$datetime=$Chatmessage->created_at->format('Y-m-d H:i');
		$eml=$user->Email;

		global $from;
		$from = Config::get('mail.from');

		Chatmessage::where('ChatID',  $chat->id)->where('User2ID',  '')->update(['IsRead' => 'Yes']);
		Chat::where('id',  $chat->id)->update(['LastMsgDateTime' => date('Y-m-d H:i:s')]);

		if(!empty(Auth::guard('user2')->user()->Logo))
			$logo=Auth::guard('user2')->user()->Logo;
		elseif(Auth::guard('user2')->user()->Sex=='女性')
		$logo='/images/woman-avatar.png';
		else
			$logo='/images/man-avatar.png';
		$nm = getUserName(Auth::guard('user2')->user());
		event(new NewChatMessage($request->id,$request->text,$logo,Auth::guard('user2')->user()->HashCode,$nm,'user1',$chat->id));
		event(new NewChatNotificaion($request->id,Auth::guard('user2')->user()->HashCode,$nm,$request->text,$Chatmessage->created_at->diffForHumans(),$logo));
		Cache::forget('chatNotification-'.$request->id);
		return('true');

	}

	public function sendFile(Request $request)
	{
		//print_r($request->all());
		//die;
		$validator = Validator::make(
				$request->all(),
				array('file' => 'required|mimes:jpeg,jpg,bmp,png,pdf,doc,docx')
		);
		if ($validator->fails())
			return array(
					'fail' => true,
					'errors' => $validator->getMessageBag()->toArray()
			);
			
		$extension = $request->file('file')->getClientOriginalExtension(); // getting image extension
		$direc = public_path() .'/chats';
		$filename = uniqid() . '_' . time() . '.' . $extension;
		$request->file('file')->move($direc, $filename);
		$ht="<a href='/chats/".$filename."' target='_blank'>".$filename."</a>";
		$request->merge(array('text' => $ht));
		if($this->sendMessage($request))
			echo $ht;

		//return '/chats/'.$filename;
		//print_r($request->all());
	}
}