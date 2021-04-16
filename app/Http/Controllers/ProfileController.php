<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\User;
use App\Profile;
use App\PendingOwnedLot;
use App\Lot;
use Session;
use DB;
class ProfileController extends Controller
{
    public $filestorage = 'profile/';
    private $originalname = '';

    public function userProfile(){
        $usertype=Auth::user()->userType;
        if($usertype=="0"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $profile = User::where('id',$id)->get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['picture'] = $picture;
            $data['profile'] = $profile;
            $data['ownedLot'] = $ownedLots;
            $data['title'] = "PROFILE";


            return view('profile/profile')->with($data);
        }
        else
            return redirect()->route('adminLanding');     
    }

public function updateProfile($id){
        // $profile = User::findOrfail($id);
        $profile = User::leftjoin('profiles','users.id','=','profiles.user_fk')->where('users.id',$id)->first();
        $user=Auth::user();    
        $data['title'] = "UPDATE PROFILE";
        // dd($id);  
        // $companyowner=Auth::user()->companyname;  
        return view('profile.changeProfile',compact('user','profile'))->with($data); 
        }
    
public function saveProfile($id,Request $request){
    $id=Auth::id();
    $utype=Auth::user()->userType;
    // dd($utype);
    // $oldPass=Auth::user()->password;
    // $checkPassword = $request->password;
    // $profilePicture = user::where('id',$id)->first();

    $this->validate($request, [
        'file'=> 'mimes|jpeg,jpg,png',
        'file'=> 'max:25600',
    ]);
    // dd($oldPass);
    // $check = DB::table('users')->where('password',$checkPassword)->first();
    // if($check){
        // $check = DB::table('users')->where([['password',$checkPassword],['id',$id]])->first(['password']);
        // if($oldPass!=$checkPassword){
        //     echo "true";
        // }
        // else{
        //     echo "false";
        // }
        // dd($oldPass);
        // if($check){
    $profile = User::where('id', $id)->update([
    "name"=>$request->input('name'),
//    "lname"=>$request->input('lname'),
   "contact"=>$request->input('contact'),
   "secondarycontact"=>$request->input('secondarycontact'),
   "address"=>$request->input('address'),
    "email"=>$request->input('email'),
    ]);
    
    $picture = $request->file('picture');
    //delete existing profile
    if($request->hasfile('picture')){
        if($picture->getMimeType()=='image/jpeg' || $picture->getMimeType()=='image/jpg' || $picture->getMimeType()=='image/png'){

            $remove = Profile::where('user_fk',$id)->delete();

            $pictures = new Profile;
            $fileName = $this->filestorage.$picture->getClientOriginalName();
            Storage::disk('public')->put($fileName, File::get($picture));
            $pictures->fileExt=url('/storage').'/'.$fileName;
            
            $otherprofile = Profile::where('user_fk',$id)->update([
            "fileExt"=>$pictures
            ]);

            $pictures->user_fk=$id;

            $pictures->save();
            }
        else{
            if($utype=="0"){ 
                return redirect(url('/myprofile'))->with('status',
                'Personal Information is updated successfully. <br/>Profile picture is not updated. Please upload a valid image.');
            }
            else{ 
                return redirect(url('/adminLanding'))->with('updatestatus',
                'Personal Information is updated successfully. Profile picture is not updated. Please upload a valid image.');
                }
        }
    }

    if($utype=="0"){ 
        return redirect(url('/myprofile'))->with('status',
        'Profile successfully updated.');
    }
    else{ 
        return redirect(url('/adminLanding'))->with('updatestatus',
        'Profile successfully updated.');
    }
}
public function viewProfile($userId){
    $id=Auth::id();
    $picture = Profile::where('user_fk',$id)->first();
    $intender=User::where('id',$userId)->first();
    $intend=User::where('id',$userId)->pluck('id');
    foreach($intend as $value){
    $val=$value;    
    }
    $profile=$val;
    $profilepicture = Profile::where('user_fk',$profile)->first();
    $data['title'] = "PROFILE";
    return view('profile/viewprofile')->with(['profilepicture'=>$profilepicture])->with(['intender'=>$intender])->with(['picture'=>$picture])->with($data);
}

}
