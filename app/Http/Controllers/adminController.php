<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;    
use App\User;
use App\Profile;
use App\Lot;
use App\lotType;
use App\ConfirmedOwner;
use App\Registeredemail;
use App\Notification;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NotifyUser;
use Session;
use DB;
use App\Radiusscore;
use App\Pricescore;
use App\Criteria;
use App\Estabscore;
use App\Pricerange;
use App\Radiusrange;
class adminController extends Controller{

    private function _getLots(){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            return view('lotDetails');
        }
        else{
            return redirect()->route('homepage');
        }
    }

    public function index(){
        $usertype=Auth::user()->userType;
        
        if($usertype=="1" || $usertype=="2"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $profile = User::where('id',$id)->get();
            $data['title']="HOME";
            return view('admin.adminLanding',['profile'=>$profile])->with(['picture'=>$picture])->with($data);
        }
       

        else{
            return redirect()->route('homepage');
        }
    }

    public function newUser(){
        $usertype=Auth::user()->userType;
        if($usertype=="2"){
            $id=Auth::id();
            $picture = User::where('id',$id)->first();
            $data['title'] = "ADD CITY ASSESSOR ADMIN";
            $mode ='add'; 
            return view('admin/addUser',compact('mode'))->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }
        
    public function saveUser(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype =="2"){
            $city = $request->city; 
            $pass=$request->password;
            $user= New User;
            $check_city = User::where('assessorOffice',$city)->first();
            if($check_city){
                return redirect(url('adminLanding'))->with('adminstatus',
                $city. " already had a city admin.");
            }
            $user->name=$request->name;
            $user->username=$request->username;
            $email_temp=$this->random_str(32);
            $email = User::where('email',$email_temp)->first();
            if($email){
                $email_temp=$this->random_str(32);
            }
            $user->email=$email_temp;
            $user->contact=$request->contact;
            $user->address=$request->address;
            $user->userStatus=$request->userStatus;
            $user->userType=$request->userType;
            $user->assessorOffice = $city;
            $password=Hash::make($pass);
            $user->password=$password;
            $user->save();
            // $id=$user->lotId;
            return redirect(url('adminLanding'))->with('adminstatus',
            'Successfully added city admin in '.$city);
        }else if($usertype=="1"){
            return redirect(url('adminLanding'));
        }
        else{
            return redirect()->route('homepage');
        }
    }
   
    public function updateCriteria(){
        $usertype=Auth::user()->userType;
        if($usertype=="2"){
            $id=Auth::id();
            $picture = User::where('id',$id)->first();
            $criteria=Criteria::get();
            $radiuskm=Radiusrange::get();
            $radiusscore=Radiusscore::get();
            $pricerange=Pricerange::get();
            $pricescore=Pricescore::get();
            $estabscore=Estabscore::get();

            $data['criteria'] = $criteria;
            $data['radiuskm'] = $radiuskm;
            $data['radiusscore'] = $radiusscore;
            $data['pricerange'] = $pricerange;
            $data['pricescore'] = $pricescore;
            $data['estabscore'] = $estabscore;
            $data['title'] = "RECOMMENDER CRITERIA";
            return view('admin/updatecriteria')->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }

    public function updateCriteriaNow(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype =="2"){
        $criteria=$request->cscore;
        $estabscore=$request->escore;
        $pricerange=$request->pricerangescore;
        $pricescore=$request->pricescore;
        $radiuskm=$request->radiuskm;
        $radiusscore=$request->radiusscore;
        for($n = 0; $n < count($criteria); $n++){
            $criteriaupdate= Criteria::where('cId',$n+1)->update([
                        'cscore'=>$criteria[$n]
                    ]);
        } 
        for($n = 0; $n < count($estabscore); $n++){
            $criteriaupdate= Estabscore::where('eId',$n+1)->update([
                        'escore'=>$estabscore[$n]
                    ]);
        } 
        for($n = 0; $n < count($pricerange); $n++){
            $criteriaupdate= Pricerange::where('rangeId',$n+1)->update([
                        'rangescore'=>$pricerange[$n]
                    ]);
        } 
        for($n = 0; $n < count($pricescore); $n++){
            $criteriaupdate= Pricescore::where('pId',$n+1)->update([
                        'pscore'=>$pricescore[$n]
                    ]);
        } 
        for($n = 0; $n < count($radiuskm); $n++){
            $criteriaupdate= Radiusrange::where('radiusId',$n+1)->update([
                        'radiuskm'=>$radiuskm[$n]
                    ]);
        } 
        for($n = 0; $n < count($radiusscore); $n++){
            $criteriaupdate= Radiusscore::where('rId',$n+1)->update([
                        'rscore'=>$radiusscore[$n]
                    ]);
        }

        return redirect(url('adminLanding'))->with('adminstatus',
        'Successfully updated recommender criterias.');
        }else if($usertype=="1"){
            return redirect(url('adminLanding'));
        }
        else{
            return redirect()->route('homepage');
        }
    }

    public function csvIndex(){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
    
            return view('admin.uploadCsv')->with(['picture'=>$picture]);
        }else{
            return redirect()->route('homepage');
        }
    }

    public function csvSave(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $this->validate($request, [
                'file'=> 'mimes|csv,vnd.ms-excel,plain',
                'file'=> 'max:25600',
            ]);

            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            //get csv file
            $upload=$request->file('upload-file');
            // dd($upload);
                if($request->hasfile('upload-file'))
                {
                    if(($request->file('upload-file')->getMimeType()=='application/vnd.ms-excel')||($request->file('upload-file')->getMimeType()=='text/csv')||($request->file('upload-file')->getMimeType()=='text/plain')){
                    $filePath=$upload->getRealPath();

                        //open and read
                        $file=fopen($filePath, 'r');
                        $header=fgetcsv($file);
                        // dd($header);
                        $fHeader=[];
                        //validate header
                        foreach($header as $key => $value){
                            $fileHeader=$value;
                            // $escapedItem=preg_replace('/[^a-z]/','',$fileHeader);               
                            array_push($fHeader,$fileHeader);
                        }
                        //loop the columns
                        while($columns=fgetcsv($file))
                        {
                            if($columns[0]==""){
                                continue;
                            }
                            //trim data
                            foreach($columns as $key => $value){
                                $val=$value;
                            }
                            $data=array_combine($fHeader,$columns);
                            //table update
                            $lotnum = Lot::where('lotNumber',$data['lotNumber'])->first();
                            if($lotnum){
                                continue;
                            }
                            else{
                            $lotid_temp=$this->random_str(32);
                            $lid = Lot::where('lotId',$lotid_temp)->first();
                            if($lid){
                                $lotid_temp=$this->random_str(32);
                            }
                            $lotId =$lotid_temp;
                            $lotNumber=$data['lotNumber'];
                            $lotTitleNumber=$data['lotTitleNumber'];
                            $lotAddress=$data['lotAddress'];
                            $lotOwner=$data['lotOwner'];
                            $lotCornerInfluence=$data['lotCornerInfluence'];
                            $lotType=$data['lotType'];
                            $lotArea=$data['lotArea'];
                            $unitOfMeasure=$data['unitOfMeasure'];
                            $lotUnitValue=$data['lotUnitValue'];
                            
                            if($data['lotCornerInfluence']=="yes" || $data['lotCornerInfluence']=="YES"){
                                $lotAdjustment=$data['lotAdjustment']+15;
                                $lotMarketValue=(($data['lotUnitValue']*$data['lotArea'])*$lotAdjustment)/100;
                            }
                            else{
                                $lotAdjustment=$data['lotAdjustment'];
                                $lotMarketValue=(($data['lotArea']*$data['lotUnitValue'])*$data['lotAdjustment'])/100;
                            }
                            // $lotAdjustment=$data['lotAdjustment'];
                            // $lotMarketValue=$data['lotMarketValue'];
                            $lotNorthEastBoundary=$data['lotNorthEastBoundary'];
                            $lotNorthWestBoundary=$data['lotNorthWestBoundary'];
                            $lotSouthEastBoundary=$data['lotSouthEastBoundary'];
                            $lotSouthWestBoundary=$data['lotSouthWestBoundary'];
                            $lotNorthBoundary=$data['lotNorthBoundary'];
                            $lotEastBoundary=$data['lotEastBoundary'];
                            $lotSouthBoundary=$data['lotSouthBoundary'];
                            $lotWestBoundary=$data['lotWestBoundary'];
                            $lng=$data['lng'];
                            $lat=$data['lat'];
                            $mortgage=$data['mortgage'];


                            $lot=Lot::firstOrNew(['lotId'=>$lotId,'lotNumber'=>$lotNumber]);
                            // $lot=Lot::firstOrNew(['lotNumber'=>$lotNumber,'lotTitleNumber'=>$lotTitleNumber]);
                            $lot->lotId=$lotId; 
                            $lot->lotTitleNumber=$lotTitleNumber;
                            $lot->lotAddress=$lotAddress;
                            $lot->lotOwner=$lotOwner;
                            $lot->lotCornerInfluence=$lotCornerInfluence;
                            $lot->lotType=$lotType;
                            $lot->lotArea=$lotArea;
                            $lot->unitOfMeasure=$unitOfMeasure;
                            $lot->lotUnitValue=$lotUnitValue;
                            $lot->lotAdjustment=$lotAdjustment;
                            $lot->lotMarketValue=$lotMarketValue;
                            $lot->rightOfWay="";
                            $lot->mortgage=$mortgage;
                            $lot->lotNEBoundary=$lotNorthEastBoundary;
                            $lot->lotNWBoundary=$lotNorthWestBoundary;
                            $lot->lotSEBoundary=$lotSouthEastBoundary;
                            $lot->lotSWBoundary=$lotSouthWestBoundary;
                            $lot->lotNBoundary=$lotNorthBoundary;
                            $lot->lotEBoundary=$lotEastBoundary;
                            $lot->lotSBoundary=$lotSouthBoundary;
                            $lot->lotWBoundary=$lotWestBoundary;
                            $lot->lng=$lng;
                            $lot->lat=$lat;
                            $lot->cityadmin=$id;
                            $lot->save();
                        }
                    }
                        return redirect()->route('lotlist')->with(['picture'=>$picture])
                        ->with('uploadstatus',
                        'Successfully uploaded the CSV file of registered lots.');
                    }else{
                        return redirect()->route('adminLanding')->with('csvstatus',
                        'Please upload a valid CSV file of the registered lots.');
                    }
                }
        }else{
            return redirect()->route('homepage');
        }
    }

    public function listLot(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

                $type=$request->lottype;
                $data['title']="PROPERTY LIST";
                if($type){
                    dd($type);
                    $lotDetails = Lot::where("lotType",$type)->get();
                    $lottype = LotType::get();
                    // $notif = Notification::select('data')->get();
                    // foreach($notif as $split){
                    //     $post = $split['data'];
                    // }
                    // dd($post);
                    return view('admin/lotList',['lotList'=>$lotDetails],['lotType'=>$lottype])->with(['picture'=>$picture])->with($data);
                    // return view('admin/lotList',['lotList'=>$lotDetails],['lotType'=>$lottype])->with(['picture'=>$picture,'notifications'=>$notif]);            

                }
                else{
                $lotDetails = Lot::where('cityadmin',$id)->get();
                $lottype = LotType::get();
                // $notif = Notification::select('data')->get();
                //     foreach($notif as $split){
                //         $post = $split['data'];
                //     }

                return view('admin/lotList',['lotList'=>$lotDetails],['lotType'=>$lottype])->with(['picture'=>$picture])->with($data);
                // return view('admin/lotList',['lotList'=>$lotDetails],['lotType'=>$lottype])->with(['picture'=>$picture,'notifications'=>$notif]);;
                
                }
        }else{
            return redirect()->route('homepage');
        }
    }
        
    public function displayLotDetails($lotId){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $data['title']="PROPERTY INFORMATION";
            $lotDetails = Lot::findorfail($lotId);
            return view('admin/lotDetails')->with(['lotDetails'=>$lotDetails])->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }

    public function displayToUser($lotId){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lotDetails = Lot::findorfail($lotId);
            return view('admin/lotDetails')->with(['lotDetails'=>$lotDetails])->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }
        
    public function newLot(){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $data['title'] = "ADD PROPERTY";
            $mode ='add'; 
            return view('admin/addLot',compact('mode'))->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }
        
    public function saveLot(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $address=$request->lotAddress;
            $longlat=$this->getLatLong($address);
            $lat=$longlat['latitude'];
            $lng=$longlat['longitude'];
            $lot = new Lot;
            $countLot = $lot::get()->count()+2;
            $lot->lotId = "lot00".$countLot;
            $lot->lotNumber=$request->lotNumber;
            $lot->lotTitleNumber=$request->lotTitleNumber;
            $lot->lotAddress=$request->lotAddress;
            $lot->lotOwner=$request->lotOwner;
            $lot->lotCornerInfluence=$request->lotCornerInfluence;
            $lot->lotType=$request->lotType;
            $lot->lotArea=$request->lotArea;
            $lot->unitOfMeasure=$request->unitOfMeasure;
            $lot->lotUnitValue=$request->lotUnitValue;
            if($lot->lotCornerInfluence=="yes" || $lot->lotCornerInfluence=="YES"){
                $lot->lotAdjustment=($request->lotAdjustment)+15;
                $lot->lotMarketValue=(($request->lotArea*$request->lotUnitValue*($request->lotAdjustment+15))/100);

            }
            else{
                $lot->lotAdjustment=$request->lotAdjustment;
                $lot->lotMarketValue=(($request->lotArea*$request->lotUnitValue*$lot->lotAdjustment)/100);

            }
            $lot->mortgage=$request->mortgage;   
            $lot->lotNEBoundary=$request->lotNorthEastBoundary;
            $lot->lotNWBoundary=$request->lotNorthWestBoundary;
            $lot->lotSEBoundary=$request->lotSouthEastBoundary;
            $lot->lotSWBoundary=$request->lotSouthWestBoundary;
            $lot->lotNBoundary=$request->lotNorthBoundary;
            $lot->lotEBoundary=$request->lotEastBoundary;
            $lot->lotSBoundary=$request->lotSouthBoundary;
            $lot->lotWBoundary=$request->lotWestBoundary;
            $lot->lng=$lng;
            $lot->lat=$lat;   
            // dd($lot->lotMarketValue);
            $lot->save();
            $id=$lot->lotId;
            return redirect(url('/lots/'.$id.'/view'));
        }else{
            return redirect()->route('homepage');
        }
    }

    public function update($lotId){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lotRecord = Lot::findOrfail($lotId);
            $oldLotType = DB::table('lots')
            ->select('lotType')
            ->where('lotId',$lotId)
            ->first();
            $data['title']="UPDATE INFORMATION";
            $type = lotType::get();
            $lottype = $type->whereNotIn('lotType', $oldLotType);
            $lottype->all();
            return view('admin/update',compact('lotRecord'))->with(['lotType'=>$lottype])->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }
        
    public function saveUpdate($lotId,Request $request){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            // $lotId = Lot::findOrfail($request->lotId);
            $lotRecord = Lot::where('lotId', $lotId)->update([
                "lotNumber"=>$request->input('lotNumber'),
                "lotTitleNumber"=>$request->input('lotTitleNumber'),
                "lotAddress"=>$request->input('lotAddress'),
                "lotOwner"=>$request->input('lotOwner'),
                "lotCornerInfluence"=>$request->input('lotCornerInfluence'),
                "lotType"=>$request->input('lotType'),
                "lotArea"=>$request->input('lotArea'),
                "unitOfMeasure"=>$request->input('unitOfMeasure'),
                "lotUnitValue"=>$request->input('lotUnitValue'),
                "lotAdjustment"=>$request->input('lotAdjustment'),
                "lotMarketValue"=>(($request->input('lotArea')*$request->input('lotUnitValue')*$request->input('lotAdjustment'))/100),
                "mortgage"=>$request->input('mortgage'),
                "lotNEBoundary"=>$request->input('lotNorthEastBoundary'),
                "lotNWBoundary"=>$request->input('lotNorthWestBoundary'),
                "lotSEBoundary"=>$request->input('lotSouthEastBoundary'),
                "lotSWBoundary"=>$request->input('lotSouthWestBoundary'),
                "lotNBoundary"=>$request->input('lotNorthBoundary'),
                "lotEBoundary"=>$request->input('lotEastBoundary'),
                "lotSBoundary"=>$request->input('lotSouthBoundary'),
                "lotWBoundary"=>$request->input('lotWestBoundary')

            ]);
            
            return redirect(url('/lotList'))->with('status',
            'Property detail is updated successfully.');
        }else{
            return redirect()->route('homepage');
        }
    }

    public function confirmOwner(){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

            return view('admin/addAuthorizedOwner')->with(['picture'=>$picture]);
        }else{
            return redirect()->route('homepage');
        }
    }

    public function saveOwner(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
                $id=Auth::id();
                $picture = Profile::where('user_fk',$id)
                        ->first();
                
                $email=$request->email;
                $findEmail=User::where('email',$email)
                        ->first();
                if($findEmail){
                $lotnumber=$request->lnumber;
                // dd($lotnumber);
                foreach($lotnumber as $lotnum){
                $findLotId=Lot::where('lotNumber',$lotnum)->first(['lotId']);
                $nameofowner = Lot::where('lotNumber',$lotnum)->select('lotOwner')->get();
                
                foreach($nameofowner as $name)
                {
                    $ownername = $name['lotOwner']; 
                }

                $finduser = DB::table('users')->where('email',$email)->select('id')->get();
                foreach($finduser as $userid)
                {
                    $id = $userid->id;
                }
                $uid = $id;

                if($findLotId){

                    $lotid=Lot::where('lotNumber',$lotnum)->pluck('lotId');

                    $alreadyConfirmed=Confirmedowner::where([['lotId',$lotid],['email',$email]])->first();

                    $confirmedByOther=Confirmedowner::where('lotId',$lotid)->first();
                        if($alreadyConfirmed){
                            $content = "You already confirmed property ".$lotnum.".";
                            User::findorfail($uid)->notify(new NotifyUser($content));
                            $changenotiftid = Notification::where([['notifiable_id', $uid],['tid_fk', null]])->update(["tid_fk" => "0"]);        
                        }
        
                        elseif($confirmedByOther){
                            $content = "Sorry ".$lotnum." property is already confirmed by aother user.";
                            User::findorfail($uid)->notify(new NotifyUser($content));
                            $changenotiftid = Notification::where([['notifiable_id', $uid],['tid_fk', null]])->update(["tid_fk" => "0"]);
                        }
            
                        else{
                            $lotid=Lot::where('lotNumber',$lotnum)->pluck('lotId');

                            foreach($lotid as $value){
                        
                                $lId=$value;  
                                }
                            $owner=new Confirmedowner;

                
                            
                                $owner->lotId=$lId;
                                $owner->email=$request->email;
                                $owner->status="null";
                                $owner->save();
                                $user = DB::table('users')->where('email',$owner['email'])->select('id')->get();
                                foreach($user as $userid)
                                {
                                    $id = $userid->id;
                                }
                                $ownerid = $id;
                                $content = "Property ".$lotnum." has been successfully confirmed.";
                                User::findorfail($ownerid)->notify(new NotifyUser($content));
                                $changenotiftid = Notification::where([['notifiable_id', $uid],['tid_fk', null]])->update(["tid_fk" => "0"]);
                                // $notifyafterconfirm->save();
                                // $notif = Notification::select('data')->get(); 
            
            
            
                                }
                        }
                    else{
                        $adminId=Auth::id();
                        $content ="Lot number ".$lotnum." not found.";
                        User::findorfail($uid)->notify(new NotifyUser($content));
                        $changenotiftid = Notification::where([['notifiable_id', $uid],['tid_fk', null]])->update(["tid_fk" => "0"]);
                    }
                }
                $data['title']="CONFIRMED PROPERTIES";
                $confirmedList = DB::table('confirmedowners')
                ->join('lots', 'lots.lotId', '=' , 'confirmedowners.lotId')
                ->select('confirmedowners.*', 'confirmedowners.email', 'lots.lotNumber')
                ->get();
                    
                    return view('admin/confirmedlist')->with(['confirmedList'=>$confirmedList])->with(['picture'=>$picture])->with('confirmedstatus','Confirmed successfully.')->with($data);
                    // return view('admin/confirmedlist')->with(['confirmedList'=>$confirmedList])->with(['picture'=>$picture,'notifications'=>$notif])->with('status','Confirmed successfully.');   
                }
                else{
                    return redirect()->route('adminLanding')->with(['picture'=>$picture])
                    ->with('status',
                    'Email is not registered in InstantPlot.')->with($data);
                }         
                
        }else{
            return redirect()->route('homepage');
        }
    }

    public function confirmedList(){
        $usertype=Auth::user()->userType;
        if($usertype=="1"){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

            $confirmedList = DB::table('confirmedowners')
            ->join('lots', 'lots.lotId', '=' , 'confirmedowners.lotId')
            ->select('confirmedowners.*', 'confirmedowners.email', 'lots.lotNumber')
            ->get();

            $data['title']="CONFIRMED PROPERTIES";

            return view('admin/confirmedlist')->with(['confirmedList'=>$confirmedList])->with(['picture'=>$picture])->with($data);
        }else{
            return redirect()->route('homepage');
        }
    }
    //get the latlong of the inputted address
    function getLatLong($searchaddressVal){
        if(!empty($searchaddressVal)){
        //Formatted address
        $formattedAddr = str_replace(' ','+',$searchaddressVal);
        //Send request and receive json data by address
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&key=AIzaSyDxdYAzq688HGpFDMmvo3q9mSM2LfVIgjE');
        $output = json_decode($geocodeFromAddr);
        //Get latitude and longitute from json data
        $data['latitude'] = $output->results[0]->geometry->location->lat; 
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        //Return latitude and longitude of the given address
        if(!empty($data)){
        return $data;
        }else{
        return false;
        }
        }else{
        return false; 
        }
    }

    function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
        {
            $pieces = [];
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $pieces []= $keyspace[random_int(0, $max)];
            }
            return implode('', $pieces);
        }

}
