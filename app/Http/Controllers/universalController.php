<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Session;
use DB;
use App\Profile;
use App\BuyerLesseeTransaction;
use App\Transaction;
use App\SoldLeasedLot;
use App\Property;
use App\Lot;
use App\User;
use App\PendingOwnedLot;
use App\lottype;
Use App\Price;
use App\Usertrail;
use App\Contract;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class universalController extends Controller
{
    use RegistersUsers;
    
    public function register(){
        return view('auth/register');
    }
    public function registeragain(){
        return view('auth/reg');
    }

    public function login(){
        Auth()->user()->unreadNotifications()->first()->update(['read_at'=>now()]);
        // Auth()->user()->unreadNotifications()->update(['read_at'=>now()]);
        $notif = Notification::select('data')->get();
        foreach($notif as $split){
                $post = $split['data'];
        }
        // dd($notif);
        // return view('auth/login');
        return view('auth/login')->with(['notifications'=>$notif]);        
    }
    public function showContract($tid){
        if(Auth::user()->userType == "0"){
            $id=Auth::id();  

            $contract=Contract::join('transactions','contracts.tid_fk','=','transactions.tid')->join('lots','transactions.lotId_fk','=','lots.lotId')->join('users','contracts.user_fk','=','users.id')->where('contracts.tid_fk',$tid)->where('contracts.user_fk',$id)->where('contracts.status','active')->select('transactions.sellingType','lotAddress','lotArea','unitOfMeasure','lotNumber','contracts.dateexecuted','contracts.owner','contracts.leaserbuyer','contracts.datesold','contracts.paymenttype','contracts.contractprice','contracts.startcontract','contracts.endcontract','contracts.owner','contracts.contractperiod','contracts.amortprice','contracts.leasedeposit','contracts.downpayment','contracts.interest','contracts.installpaymenttype','contracts.installtimetopay','contracts.installpayment','contracts.status','address')->first();
            $picture = Profile::where('user_fk',$id)->first();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['picture']=$picture;
            $data['contract']=$contract;
            $data['title']='CONTRACT';
            return view('seller/contract')->with($data);
        }else{
            return view('instantplot');
        }
    }
    public function showContractSeller($tid){
        if(Auth::user()->userType == "0"){
            $id=Auth::id();  

            $contract=Contract::join('transactions','contracts.tid_fk','=','transactions.tid')->join('lots','transactions.lotId_fk','=','lots.lotId')->join('users','contracts.user_fk','=','users.id')->where('contracts.tid_fk',$tid)->where('transactions.user_fk',$id)->where('contracts.status','active')->select('transactions.sellingType','lotAddress','lotArea','lotNumber','unitOfMeasure','contracts.dateexecuted','contracts.owner','contracts.leaserbuyer','contracts.datesold','contracts.paymenttype','contracts.contractprice','contracts.startcontract','contracts.endcontract','contracts.owner','contracts.contractperiod','contracts.amortprice','contracts.leasedeposit','contracts.downpayment','contracts.interest','contracts.installpaymenttype','contracts.installtimetopay','contracts.installpayment','contracts.status','address')->first();
            // dd($contract);
            $picture = Profile::where('user_fk',$id)->first();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['picture']=$picture;
            $data['contract']=$contract;
            $data['title']='CONTRACT';
            return view('seller/contract')->with($data);
        }else{
            return view('instantplot');
        }
    }
    public function landing(){
        if(Auth::user()->userType == "0"){
            $id=Auth::id();  
            $picture = Profile::where('user_fk',$id)->first(); 
            $notif = Notification::select('data')->get();
              
            foreach($notif as $split){
                $post = $split['data'];
            }
            Session::save();
            $lottype = lotType::distinct()->get(['lotType']); 
            $price = Price::distinct()->get(['price']);
            $sellers = Transaction::where('user_fk',$id)->orderBy('created_at', 'desc')->get();
            $sold=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")
                ->where([["Transactions.user_fk",$id],["Transactions.sellingtype","==","For Sale"]])->get();
            $grantedleased=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")
                ->where([["Transactions.user_fk",$id],["Transactions.sellingtype","==","For Lease"]])->get();
            $rented=SoldLeasedLot::where("user_fk",$id)->get();
            $intended=BuyerLesseeTransaction::join('users','buyerlesseetransactions.user_fk',"=","users.id")
                        // ->where('buyerlesseetransactions.user_fk',$id)
                        ->get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();            $data['pendingLot']= $pendingLots;
            $data['lottype'] = $lottype;
            $data['price'] = $price;
            $data['propertysold']=$sold;
            $data['grantedleased']=$grantedleased;
            $data['ownedLot']=$ownedLots;
            $data['rented']=$rented;
            $data['intended']=$intended;
            $data['listall']=$sellers;
            $data['title'] = "HOME";
            return view('home')->with(['picture'=>$picture,'notification'=>$notif])->with($data);
        }
        else{
            return view('instantplot');
        }
    }
        
    public function markasread($notif_id){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $notif=Notification::where('id',$notif_id)->update(['read_at'=>now()]);
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title'] = "VIEW NOTIFICATION";
            return redirect()->route('properties')->with($data);
        }
        else
            return redirect()->route('adminLanding');

    }

    public function marknotif($tid_fk, $notif_id){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $notif=Notification::where('id',$notif_id)->update(['read_at'=>now()]);
            $picture = Profile::where('user_fk',$id)->first();
            $lotDetails = Lot::join('transactions','transactions.lotId_fk','lots.lotId')->where('transactions.tid',$tid_fk)->first();
            
            $user=Transaction::where('tid',$tid_fk)->pluck('user_fk');
            foreach($user as $value){
                $val=$value;    
            }
            $owner=$val;
            $sellerpicture = Profile::where('user_fk',$owner)->first();
        
            $getuser=User::findorfail($owner);
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title'] = "VIEW NOTIFICATION";
            return view('seller/viewnotifdata')->with(['lotDetails'=>$lotDetails])->with(['user'=>$getuser])->with(["picture"=>$picture])->with(["sellerpicture"=>$sellerpicture])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }
    public function back(){
        return redirect()->back();
    }
    public function viewnotif($tid_fk){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();

            $picture = Profile::where('user_fk',$id)->first();
        
            // $lotDetails = Transaction::findorfail($tid_fk);
            $lotDetails = Lot::join('transactions','transactions.lotId_fk','lots.lotId')->where('transactions.tid',$tid_fk)->first();
            $user=Transaction::where('tid',$tid_fk)->pluck('user_fk');
            foreach($user as $value){
                $val=$value;    
            }
            $owner=$val;
            $sellerpicture = Profile::where('user_fk',$owner)->first();
        
            $getuser=User::findorfail($owner);
            // $ownedLots=DB::table('lots')
            // ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            // ->where('confirmedowners.user_fk',$id)
            // ->get()
            // ->toArray();
            // $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title'] = "VIEW NOTIFICATION";
            return view('seller/viewnotifdata')->with(['lotDetails'=>$lotDetails])->with(['user'=>$getuser])->with(["picture"=>$picture])->with(["sellerpicture"=>$sellerpicture])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    
    }

     /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'contact' => 'max:13',
            'secondarycontact' => 'max:13',
            'address' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function create(Request $data)
    {
        $email = User::where('email',$data->email)->first();
        if($email){
            $info['name'] = $data->name;
            $info['contact'] = $data->contact;
            $info['secondarycontact'] = $data->secondarycontact;
            $info['address'] = $data->address;
            $info['email'] = $data->email;
            $info['status']="Email is already taken.";
            $info['passwordstatus']="";
            return view('auth.reg')->with($info);
        }
        if(strlen($data->password) < 6){
            $info['name'] = $data->name;
            $info['contact'] = $data->contact;
            $info['secondarycontact'] = $data->secondarycontact;
            $info['address'] = $data->address;
            $info['email'] = $data->email;
            $info['status']="";
            $info['passwordstatus'] = "Password must be 6 characters long.";
            return view('auth.reg')->with($info);
        }
        if($data->password != $data->password_confirmation){
            $info['name'] = $data->name;
            $info['contact'] = $data->contact;
            $info['secondarycontact'] = $data->secondarycontact;
            $info['address'] = $data->address;
            $info['email'] = $data->email;
            $info['status']="";
            $info['passwordstatus'] = "Password does not match.";
            return view('auth.reg')->with($info);
        }
        $user = new User;
                $user->name=$data->name;
                $user->contact=$data->contact;
                $user->secondarycontact=$data->secondarycontact;
                $user->address=$data->address;
                $user->email=$data->email;
                $user->password=Hash::make($data->password);
                $user->usertype=$data->userType;
            
        $user->save();

        return redirect()->route('login')->with('status', 'Successfully created account. Log in now');
    }
}
    // public function marknotif($tid_fk){
    //     $id=Auth::id();
    //     Auth()->user()->unreadNotifications()->first()->update(['read_at'=>now()]);
    //     // Auth()->user()->unreadNotifications()->update(['read_at'=>now()]);

    // //    $notif= Auth()->user()->unreadNotifications()->where([['tid_fk',$tid_fk],['notifiable_id',$id]])->whereNull('read_at')->update(['read_at'=>now()]);
    // //   dd($notif);
    //     $picture = Profile::where('user_fk',$id)->first();
    
    //     $lotDetails = Transaction::findorfail($tid_fk);
        
    //     $user=Transaction::where('tid',$tid_fk)->pluck('user_fk');
    //     foreach($user as $value){
    //     $val=$value;    
    //     }
    //     $owner=$val;
    //     $sellerpicture = Profile::where('user_fk',$owner)->first();
    
    //     $getuser=User::findorfail($owner);
       
        
    //     return view('seller/viewnotifdata')->with(['lotDetails'=>$lotDetails])->with(['user'=>$getuser])->with(["picture"=>$picture])->with(["sellerpicture"=>$sellerpicture]);
    
    // }