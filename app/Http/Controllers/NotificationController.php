<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lot;
use App\lotType;
use App\User;
use App\Profile;
use App\sellLeasedTransaction;
use App\BuyerLesseeTransaction;
use App\Month;
use App\Price;
use App\Notification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NotifyUser;
// use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use DB;

class NotificationController extends Controller
{
    public function viewnotif($tid){
        $id=Auth::id();
        $picture = Profile::where('user_fk',$id)->first();

        $lotDetails = sellLeasedTransaction::findorfail($tid);
        
        $user=sellLeasedTransaction::where('tid',$tid)->pluck('user_fk');
        foreach($user as $value){
        $val=$value;    
        }
        $owner=$val;
        $sellerpicture = Profile::where('user_fk',$owner)->first();

        $getuser=User::findorfail($owner);
       
        $notif = Notification::select('data')->get();
              
            foreach($notif as $split)
                {
                    $post = $split['data'];
                }
        
        return view('viewnotif')->with(['lotDetails'=>$lotDetails])->with(['user'=>$getuser])->with(["picture"=>$picture])->with(["sellerpicture"=>$sellerpicture])->with(['notification'=>$notif]);
    }

}
