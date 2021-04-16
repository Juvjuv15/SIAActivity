<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Profile;
use App\Notification;
use DB;
use Validator;
use App\lotType;
use App\Lot;
use App\Price;
use App\PendingOwnedLot;
use App\Transactiontrail;
use App\Transaction;
class LoginController extends Controller
{
    //  private $rules=[
    //         'password'=>'required',
    //         'email'=>'required',
    // ];
    // private $messages =[
    //     'password.required'=>'Invalid password',
    //     'email.required'=>'Invalid email'
    // ];
    // use AuthenticatesUsers;
//return what uis the value to be processed during authentication
    public function username(){
        return 'email';
    }
//attempt is a method that checks if the authentication is successful-returns true or false value
    public function authenticate(Request $request){ 
        if($request['email']){
            $authResult = Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]);

            $email=$request->email;
            $password=$request->password;
            $checkEmail = DB::table('users')->where('email',$email)->first();
            // $checkPass = DB::table('users')->where('password',$password)->first();
            $checkAccount = DB::table('users')->where([['email',$email],['password',$password]])->first();
            $userType = DB::table('users')->where('email',$email)->first(['userType']);
            if($authResult){
                $id=Auth::id();
                $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
                ->where('properties.user_fk',$id)
                ->get();

                $id=Auth::id();  
                $picture = Profile::where('user_fk',$id)->first(); 
                $notif = Notification::select('data')->get();
                
                foreach($notif as $split){
                    $post = $split['data'];
                }
                Session::save();
                
                $lottype = lotType::distinct()->get(['lotType']); 
                $price = Price::distinct()->get(['price']);
                $sellers = Transaction::where([['user_fk',$id],['sellingType',"For Sale"]])->orderBy('created_at', 'desc')->whereNull('sellingStatus')->get();
                $forsale = Transaction::where([['user_fk',$id],['sellingType',"For Sale"]])->orderBy('created_at', 'desc')->get();
                $forlease = Transaction::orWhere('sellingType',"For Lease")->where('user_fk',$id)->orderBy('created_at', 'desc')->get();
                $renew=Transactiontrail::join('transactions','transactions.tid','=','transactiontrails.tid_fk')->where('actions','renew')->get();
                // dd($forlease);  
                // $forlease = Transaction::where([['user_fk',$id],['sellingType',"For Lease"]])->orderBy('created_at', 'desc')->whereNull('sellingStatus')->get();
                // $sold=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")
                //     ->where([["Transactions.user_fk",$id],["Transactions.sellingtype","=","For Sale"]])->get();   
                // $soldasset=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")
                // ->where([["Transactions.user_fk",$id],["Transactions.sellingtype","=","For Sale"]])->sum("Transactions.lotprice");
                // $grantedleased=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")
                //     ->where([["Transactions.user_fk",$id],["Transactions.sellingtype","=","For Lease"]])->get();
                // $bought=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")->where([["soldleasedlots.user_fk",$id],["Transactions.sellingtype","=","For Sale"]])->get();
                // $boughtasset=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")->where([["soldleasedlots.user_fk",$id],["Transactions.sellingtype","=","For Sale"]])->sum("Transactions.lotprice");;
                // $rented=SoldLeasedLot::join("Transactions",'soldleasedlots.tid_fk',"=","Transactions.tid")->where([["soldleasedlots.user_fk",$id],["Transactions.sellingtype","=","For Lease"]])->get();
                // $intended=BuyerLesseeTransaction::join('users','buyerlesseetransactions.user_fk',"=","users.id")
                //             ->where('buyerlesseetransactions.user_fk',$id)
                //             // ->whereNull('status')
                //             ->get();
                $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
                $data['pendingLot']= $pendingLots;
                // $data['lottype'] = $lottype;
                // $data['price'] = $price;
                // $data['propertysold']=$sold;
                // $data['grantedleased']=$grantedleased;
                $data['ownedLot']=$ownedLots;
                // $data['bought']=$bought;
                // $data['rented']=$rented;
                // $data['intended']=$intended;
                // $data['listall']=$sellers;
                // $data['soldasset']=$soldasset;
                // $data['boughtasset']=$boughtasset;
                $data['renew']=$renew;
                $data['forlease']=$forlease;
                $data['forsale']=$forsale;
                $data['title']="HOME";
                return view('home')->with(['picture'=>$picture,'notification'=>$notif])->with($data);
            }
            else {   
                // dd($checkEmail);
                // dd($checkPass);        
                if($checkEmail!=null && $checkAccount==null) {   
                // if(!$checkAccount){
                return redirect()->to(route('login'))
                ->with('passwordstatus',
                'Email and password does not match');
                }
                else if($checkEmail==null){
                return redirect()->to(route('login'))
                ->with('emailstatus',
                'Email is not yet registered');
                }
            }
        }
        else{
            $authResult = Auth::attempt(['userName'=>$request['username'],'password'=>$request['password']]);
            $username=$request->username;
            $password=$request->password;
            $checkUser = DB::table('users')->where('userName',$username)->first();
            // $checkPass = DB::table('users')->where('password',$password)->first();
            $checkAccount = DB::table('users')->where([['userName',$username],['password',$password]])->first();
            $userType = DB::table('users')->where('userName',$username)->first(['userType']);
            $userStatus = DB::table('users')->where('userName',$username)->first(['userStatus']);
            if($authResult){
                //get the user type/error std class if dle eh foreach
            foreach($userType as $user){
                $users=$user;    
                }
                $utype=$users;
                $userStat=Auth::user()->userStatus;
                // dd($user);
                //check if admin or regular user

                if($utype==="2") {
                    $id=Auth::id();       
                    $picture = Profile::where('user_fk',$id)->first();

                    return redirect()->to(route('adminLanding'))->with(['picture'=>$picture]);       
                }        
                else if($utype==="1" && $userStat===0) { 
                        return redirect()->to(route('changePassIndex'));     
                } else if($utype==="1" && $userStat===1) { 
                    $id=Auth::id();       
                    $picture = Profile::where('user_fk',$id)->first();
                    
            
                    return redirect()->to(route('adminLanding'))->with(['picture'=>$picture]);    
                }

            }
            else {         
                if($checkUser!=null && $checkAccount==null) {   
                // if(!$checkAccount){
                return redirect()->to(route('admin_login'))
                ->with('passwordstatus',
                'Username and password does not match');
                }
                else if($checkUser==null){
                return redirect()->to(route('admin_login'))
                ->with('emailstatus',
                'User is not yet registered');
                }
            }
        }
    }
    public function changePass(){
        return view('admin.changepassword');
    }
    public function changePassword(Request $request){

        $email =$request->email;
        $password=$request->password;


        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $userId = Auth::user()->id;
        $value= 1;
        $user->password = bcrypt($request->get('password'));
        $user->save();
        $changesellertid = User::where('id', $userId)->update(["userStatus" => $value]);
        return redirect()->to(route('adminLanding'))->with("success","Password changed successfully !");

    }

    public function logouts(){
        Auth::logout();
        return redirect()->to(route('login'));
    }

    public function loginAdmin(){
        // $id=Auth::id();
        // $userType = DB::table('users')->where('id',$id)->first(['userType']);
        // if($id){
        //     if($userType->userType == '1'){
        //         $picture = Profile::where('user_fk',$id)->first();
                    
        //             Session::save();
        
        //             return redirect()->to(route('adminLanding'))->with(['picture'=>$picture]);
        //     }
        // }
        // else
            return view('auth/adminlogin');
    }
    public function logoutAdmin(){
        Auth::logout();
        return redirect()->to(route('admin_login'));
    }
}
