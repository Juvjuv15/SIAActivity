<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lot;
use App\lotType;
use App\User;
use App\Profile;
use App\Transaction;
use App\Property;
use App\Month;
use App\PendingOwnedLot;
use App\Price;
use App\Notification;
use App\Transactiontrail;
use App\Point;
use App\Usertrail;
use App\Itemintent;
use App\Document;
use App\Itemviewed;
use App\Contract;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NotifyUser;
// use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use DB;
class BuyerController extends Controller
{
    
    //for the map lot type dropdown
    public function viewMap(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lottype = lotType::distinct()->get(['lotType']); 
            $price = Price::distinct()->get(['price']);
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="SEARCH FOR A PROPERTY";
            return view('/map',['picture'=>$picture],['price'=>$price])->with(['lottype'=>$lottype])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }

    public function displayLot($tid){
        $usertype=Auth::user()->userType;
   
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lotDetails = Lot::join('transactions','lots.lotId','=','transactions.lotId_fk')->where('transactions.tid',$tid)->first();
            $user=Transaction::where('tid',$tid)->first();
     
            $counter= DB::tabLe('transactiontrails')->get()->count();
            $counter += 1;
            $newTransaction = new Transactiontrail;
            $newTransaction->trailId="trail".$counter;
            $newTransaction->user_fk=$id;
            $newTransaction->tid_fk=$tid;
            $newTransaction->actions='view';
            $newTransaction->save();
            
        
            $sellerpicture = Profile::where('user_fk',$user->user_fk)->first();

            $getuser=User::findorfail($user->user_fk);
            $lottype = lotType::distinct()->get(['lotType']); 
            $price = Price::distinct()->get(['price']);
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="PROPERTY INFORMATION";
            return view('buyer/viewDetail')->with(['lotDetails'=>$lotDetails])->with(['user'=>$getuser])->with(["picture"=>$picture])->with(["sellerpicture"=>$sellerpicture])->with(['price'=>$price])->with(['lottype'=>$lottype])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }
    public function showDocument($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
    
            $user=Transaction::where('tid',$tid)->pluck('user_fk');
            foreach($user as $value){
            $val=$value;    
            }
            $id=$val;
            $getuser=User::findorfail($id);
            $document = Document::where('tid',$tid)->get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="ATTACHED DOCUMENT(S)";
            return view('buyer/viewproof',['listall'=>$document])->with(["picture"=>$picture])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }

    public function newInquire($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $getTransactionType= DB::table('transactions')
            ->select('sellingType')
            ->where('tid',$tid)
            ->first();   
            $getLotId=DB::table('transactions')
            ->select('lotId_fk')
            ->where('tid',$tid)
            ->first();
            $checkIfOwned= DB::tabLe('transactions')->where([['lotId_fk',$getLotId->lotId_fk],['tid', $tid]])->first();
            $idNum=$checkIfOwned->user_fk;
            if($idNum!=$id){
                $getbuyerid = User::where('id',$id)->get();
            foreach($getbuyerid as $buyerid){
                $buyerni = $buyerid['id'];
            }
            foreach($getbuyerid as $getbuyername){
                $intendbuyer = $getbuyername['name'];
            }
                $getseller = Transaction::where('tid',$tid)->select('user_fk')->get();    
                foreach($getseller as $a){
                    $b = $a['user_fk'];
                }
                $kuhasellername = User::where('id',$b)->select('name')->get();
                foreach($kuhasellername as $kuhasellernames){
                    $kuhasellernamess = $kuhasellernames['name'];
                }
                $getsellermaonani = User::where('id',$b)->get();
                foreach($getsellermaonani as $finalgetseller){
                    $getsellerid = $finalgetseller['id'];
                }

                $getpropertylocation = Lot::where('lotId',$getLotId->lotId_fk)->select('lotAddress')->get();    
                foreach($getpropertylocation as $value){
                    $key = $value['lotAddress'];
                }  
                $lotaddress = $key;
            // check if already intended
            $check= Transactiontrail::where([['tid_fk',$tid],['user_fk', $id],['actions','intent']])->where('status',null)->first();
            if(!$check){
                $sellingType= Transaction::where('tid',$tid)->pluck('sellingtype');
                foreach($sellingType as $value){
                    $sell=$value;
                }
                $selling=$sell;
                $otherbuyers = Transactiontrail::where('tid_fk',$tid)->where('actions',"intent")->where('status',null)->get();
                if($selling=="For Lease"){
                    $contentseller = $intendbuyer." is interested to lease your property located at ".$lotaddress.".";
                    $contentother = "Another person is interested to lease on a property that you intended, located at ".$lotaddress.", posted by ".$kuhasellernamess.".";
                    $type="lease";
                }
                else if($selling=="For Sale"){
                    $contentseller = $intendbuyer." is interested to buy your property located at ".$lotaddress.".";
                    $contentother = "Another person is interested to buy on a property that you intended, located at ".$lotaddress.", posted by ".$kuhasellernamess.".";
                    $type="buy";
                }
                else{
                    $contentseller = $intendbuyer." is interested to rent your property located at ".$lotaddress.".";
                    $contentother = "Another person is interested to rent on a property that you intended, located at ".$lotaddress.", posted by ".$kuhasellernamess.".";
                    $type="buy";
                }
                User::findorfail($getsellerid)->notify(new NotifyUser($contentseller));
                foreach($otherbuyers as $val){
                    User::findorfail($val->user_fk)->notify (new NotifyUser($contentother));
                    $changesellertid = Notification::where([['notifiable_id', $val->user_fk],['tid_fk', null]])
                ->update(["tid_fk" => $tid]);
                }
                $counter= DB::tabLe('transactiontrails')->get()->count();
                $counter += 1;

                $newTransaction = new Transactiontrail;
                    $newTransaction->trailId="trail".$counter;
                    $newTransaction->user_fk=$id;
                    $newTransaction->tid_fk=$tid;
                    $newTransaction->actions='intent';
                    $newTransaction->save();
                $count= DB::tabLe('transactiontrails')->where([['tid_fk',$tid]])->where('actions',"intent")->where('status',null)->get()->count();
                $c=$count;
                // dd($c);
                $intended = "intended";
                $changestatus = Transaction::where('tid',$tid)->update([
                "status" => $intended,
                "count"=> $c]);

                $changesellertid = Notification::where([['notifiable_id', $b],['tid_fk', null]])
                ->update(["tid_fk" => $tid]);
                $changesellertid = Notification::where([['notifiable_id', $id],['tid_fk', null]])
                ->update(["tid_fk" => $tid]);

                return redirect('/intendeddashboard')->with('favoritestatus',
                'Added to the list of properties you are interested with.');
                }
            else{
                return redirect('/intendeddashboard')->with('intendedstatus',
                'Already placed on your intended list.');
            }
        }
            else{
                    return redirect('/map')->with('intendedstatus',
                    'Cannot place an intend to property you owned.');
                }
        }
        else
            return redirect()->route('adminLanding');
            
    }
    public function cancelInquire($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $getTransactionType= DB::table('transactions')
            ->select('sellingType')
            ->where('tid',$tid)
            ->first();

            
            foreach($getTransactionType as $value){
                $val = $value;
            }
            $transactionType = $val;

            $getbuyerid = User::where('id',$id)->get();
            foreach($getbuyerid as $buyerid){
                $buyerni = $buyerid['id'];
            }
        
            foreach($getbuyerid as $getbuyername){
                $intendbuyer = $getbuyername['name'];
            }
            $getseller = Transaction::where('tid',$tid)->select('user_fk')->get();    
            foreach($getseller as $a){
                $b = $a['user_fk'];
            }
            $kuhasellername = User::where('id',$b)->select('name')->get();
            foreach($kuhasellername as $kuhasellernames){
                $kuhasellernamess = $kuhasellernames['name'];
            }

            $getsellermaonani = User::where('id',$b)->get();
            foreach($getsellermaonani as $finalgetseller){
                $getsellerid = $finalgetseller['id'];
            }
            $getpropertylocation = Lot::join('transactions','transactions.lotId_fk','=','lots.lotId')->where('tid',$tid)->select('lotAddress')->first();    
         
                $lotaddress = $getpropertylocation->lotAddress;
                $sellingType= Transaction::where('tid',$tid)->pluck('sellingType');
                foreach($sellingType as $value){
                    $sell=$value;
                }
                $selling=$sell;

                if($selling=="For Lease"){
                    $contentseller = $intendbuyer." cancelled an intention to lease your property located at ".$lotaddress.".";
                    $type="lease";
                }
                else if($selling=="For Sale"){
                    $contentseller = $intendbuyer." cancelled an intention to buy your property located at ".$lotaddress.".";
                    $type="buy";
                }
                User::findorfail($getsellerid)->notify(new NotifyUser($contentseller));
  
                $getTransaction = Transactiontrail::where([['tid_fk',$tid],['user_fk',$id]])->where('actions','intent')->select('trailId')->first();

                $cancelRequest = Transactiontrail::where('trailId',$getTransaction->trailId)
                        ->update(["actions" => "cancelled"]);

                $counter= DB::tabLe('transactiontrails')->where('tid_fk',$tid)->where('actions','intent')->where('status',null)->get()->count();
                $cancelRequest = Transaction::where('tid',$tid)
                        ->update(["count" => $counter]);
                if($counter == 0){
                    $changestatus = Transaction::where('tid',$tid)->update([
                    "status" => "free",
                    "count"=> NULL,
                    "sellingStatus"=> NULL
                    ]);
                }
                $changesellertid = Notification::where([['notifiable_id', $getsellerid],['tid_fk', null]])
                ->update(["tid_fk" => $tid]);
                
             
                return redirect()->route('homepage')->with('favoritestatus',
                "You cancelled your interest to ".$type." on a property located at ".$lotaddress.".");
                }
        else
            return redirect()->route('adminLanding');
    }
    public function dashboard(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first(); 
            // $buyer = DB::table('transactions')
            // ->join('lots', 'lots.lotNumber', '=' , 'transactions.slotnumber')
            // ->join('buyerlesseetransactions', 'buyerlesseetransactions.tid_fk', '=' , 'transactions.tid')
            // ->join('users', 'users.id', '=' , 'transactions.user_fk')
            // ->leftjoin('files', 'files.tid', '=' , 'transactions.tId')
            // ->where('files.filetype',"image")
            // ->where('buyerlesseetransactions.user_fk',$id)
            // ->whereNull('buyerlesseetransactions.status')
            // ->whereNull('buyerlesseetransactions.cancelled')
            // ->orderBy('buyerlesseetransactions.blt_id', 'asc')
            // ->get();
             $buyer = Lot::join('transactions', 'lots.lotId', '=' , 'transactions.lotId_fk')
            ->join('transactiontrails', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
            ->join('users', 'users.id', '=' , 'transactions.user_fk')
            ->leftjoin('panoimages', 'panoimages.lotId_fk', '=' , 'lots.lotId')
            ->where('transactions.status','!=','deleted')
            ->where('panoimages.filetype',"image")
            ->where('transactiontrails.user_fk',$id)
            ->where('actions',"intent")
            // ->whereNull('buyerlesseetransactions.status')
            // ->whereNull('buyerlesseetransactions.cancelled')
            ->orderBy('transactiontrails.created_at', 'desc')
            ->paginate(5);
            // dd($buyer);
            $profile = User::where('id',$id)->get();
            
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $email=Auth::user()->email;
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['title']="PROPERTIES YOU ARE INTERESTED TO BUY/LEASE";
            return view('buyer/dashboard',['profile'=>$profile],['dashboard'=>$buyer])->with(['picture'=>$picture,'notifications'=>$notif])->with(['ownedLot'=>$ownedLots])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }
    public function displayIntended($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lotDetails = Transaction::findorfail($tid);
            
            return view('buyer/viewIntended')->with(['lotDetails'=>$lotDetails])->with(["picture"=>$picture]);
        }
        else
            return redirect()->route('adminLanding');
    }

    public function boughtLots(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();

            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;   
            
            $bought=DB::table('lots')
            ->join('transactions','lots.lotId','=','transactions.lotId_fk')
            ->join('users', 'users.id', '=' , 'transactions.user_fk')
            ->join('transactiontrails', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
            ->join('contracts','transactions.tid','=','contracts.tid_fk')
            ->leftjoin('panoimages', 'panoimages.lotId_fk', '=' , 'lots.lotId')
            ->select('name','sellingType','transactions.paymentType','lotAddress','lotArea','unitOfMeasure','lotType','lotPrice','transactions.installDownPayment','transactions.installPaymentType','filetype','fileExt','rightOfWay','lotDescription','transactions.interest','transactions.installTimeToPay','transactions.installPayment','tid','transactiontrails.created_at','lotOwner','owner','datesold')
            ->where('transactions.status','!=','deleted')
            ->where('panoimages.filetype',"image")
            ->where([['transactiontrails.user_fk',$id],['transactions.sellingType',"For Sale"]])
            ->where('transactiontrails.actions','purchased')
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(5);

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $data['pendingLot']= $pendingLots;
            $data['title']="PROPERTIES BOUGHT";
                return view('buyer/boughtrentedlots',['listall'=>$bought],['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);        
        }
        else
            return redirect()->route('adminLanding');
    }

    public function rentedLots(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();

            // $bought=DB::table('soldleasedlots')
            // ->join('transactions','soldleasedlots.tid_fk','=','transactions.tid')
            // ->join('users', 'users.id', '=' , 'soldleasedlots.user_fk')
            // ->leftjoin('files', 'files.tid', '=' , 'transactions.tId')
            // ->where('files.filetype',"image")
            // ->where([['soldleasedlots.user_fk',$id],['sellingtype',"For Lease"]])
            // ->andWhere('')
            // ->orderBy('transactions.created_at', 'desc')
            // ->get();
            $bought=DB::table('lots')
            ->join('transactions','lots.lotId','=','transactions.lotId_fk')
            ->join('users', 'users.id', '=' , 'transactions.user_fk')
            ->join('transactiontrails', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
            ->join('contracts','transactions.tid','=','contracts.tid_fk')
            ->leftjoin('panoimages', 'panoimages.lotId_fk', '=' , 'lots.lotId')
            ->select('name','sellingType','transactions.paymentType','lotAddress','lotArea','unitOfMeasure','lotType','lotPrice','transactions.installDownPayment','transactions.installPaymentType','filetype','fileExt','rightOfWay','lotDescription','transactions.interest','transactions.installTimeToPay','transactions.installPayment','tid','transactiontrails.created_at','lotOwner','transactions.leaseDeposit','transactions.contractPeriod','owner','startcontract','endcontract')
            ->where('transactions.status','!=','deleted')
            ->where('panoimages.filetype',"image")
            ->where([['transactiontrails.user_fk',$id],['transactions.sellingType',"For Lease"]])
            ->where('transactiontrails.actions','purchased')
            ->orderBy('transactions.created_at', 'desc')
            ->paginate(5);
            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            // dd($sellers);
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;        

            // $getPostedLotLnumber=DB::table('lots')
            // ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            // ->join('transactions','lots.lotNumber','=','transactions.slotnumber')
            // ->where('confirmedowners.user_fk',$id)
            // ->select('lots.lotNumber')
            // ->get();

            // $postedLotLnumber=DB::table('lots')
            // ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            // ->join('transactions','lots.lotNumber','=','transactions.slotnumber')
            // ->where('confirmedowners.user_fk',$id)
            // ->select('lots.lotNumber')
            // ->get();

            // foreach($getPostedLotLnumber as $value){
            //     $val=$value;
            // }
            
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $data['title']="PROPERTIES LEASED";
                return view('buyer/rentedlots',['listall'=>$bought],['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);        
        }
        else
            return redirect()->route('adminLanding');
    }

    public function renewContract($tid, $status){
        $id=Auth::id();
        $user=Auth::user()->name;
        $getproperty = Lot::join('transactions','transactions.lotId_fk','=','lots.lotId')->where('tid',$tid)->select('lotAddress','user_fk')->first();    
            $lotaddress = $getproperty->lotAddress;
            $getsellerid = $getproperty->user_fk;
            $getcontract = Contract::where('tid_fk',$tid)->where('user_fk',$id)->where('status','active')->first();
            $contractperiod=$getcontract->contractperiod;
            $startcontract=$getcontract->startcontract;
            $endcontract=$getcontract->endcontract;
            $years = preg_replace('/\D/', '', $contractperiod);//extract the numbers from the string
            $years=$years*12;
            $startdate = strtotime(date("Y-m-d", strtotime($startcontract)) . " +".$years." month");
            $startdate = date("Y-m-d",$startdate);
            $enddate = strtotime(date("Y-m-d", strtotime($endcontract)) . " +".$years." month");
            $enddate = date("Y-m-d",$enddate);

            // dd($startdate);
            // dd($getcontract->endcontract);
        if($status=='yes'){

                    $contentseller = $user." wants to renew the contract of lease on your property located at ".$lotaddress.".";

                    // $contentLeaser = "A notification has been sent to the Lessor that you want to renew your contract of lease on a property located at ".$lotaddress.", wait for the confirmation.";


                    User::findorfail($getsellerid)->notify(new NotifyUser($contentseller));
                    // User::findorfail($id)->notify(new NotifyUser($contentLeaser));
                    $changesellertid = Notification::where([['notifiable_id', $getsellerid],['tid_fk', null]])->update(["tid_fk" => $tid]);
                    // $changesellertid = Notification::where([['notifiable_id', $id],['tid_fk', null]])->update(["tid_fk" => $tid]);

                    $counter= DB::tabLe('transactiontrails')->get()->count();
                    $counter += 1;
                    $newTransaction = new Transactiontrail;
                        $newTransaction->trailId="trail".$counter;
                        $newTransaction->user_fk=$id;
                        $newTransaction->tid_fk=$tid;
                        $newTransaction->actions='renew';
                        $newTransaction->save();
                
             
                return redirect()->route('homepage')->with('favoritestatus',
                "You request to renew your contract on a property located at ".$lotaddress." has been sent. Wait for the confirmation of the lessor");
                }else{
                    $contentseller = $user."don't want to renew the contract of lease on your property located at ".$lotaddress.".";


                    User::findorfail($getsellerid)->notify(new NotifyUser($contentseller));

                    $changesellertid = Notification::where([['notifiable_id', $getsellerid],['tid_fk', null]])->update(["tid_fk" => $tid]);
                    $counter= DB::tabLe('transactiontrails')->get()->count();
                    $counter += 1;
                    $newTransaction = new Transactiontrail;
                        $newTransaction->trailId="trail".$counter;
                        $newTransaction->user_fk=$id;
                        $newTransaction->tid_fk=$tid;
                        $newTransaction->actions='unrenew';
                        $newTransaction->save();
                    $changestatus = Transaction::where('tid',$tid)->update([
                        "status" => "free",
                        "count"=> NULL,
                        "sellingStatus"=> NULL
                        ]);
                    $changestatus = Contract::where('tid_fk',$tid)->where('user_fk',$id)->where('status','active')->update([
                        "status" => "inactive"
                        ]);

                    return redirect()->route('homepage')->with('favoritestatus',
                "Your request not to renew your contract on a property located at ".$lotaddress." has been sent to the lessor");
                }
    }

}
