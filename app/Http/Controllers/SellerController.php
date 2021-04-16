<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
use App\Transactiontrail;
use App\Transaction;
use App\Panoimage;
use App\Lot;
use App\User;
use App\lotType;
use App\SellingType;
use App\Document;
use App\Profile;
use App\PendingOwnedLot;
use App\Mainpicture;
use App\LotHistory;
use App\Confirmedowner;
use App\Notification;
use App\Month;
use App\PaymentType;
use App\Notifications\NotifyUser;
use Session;
use App\Point;
use DB;
use App\Itempurchase;
use App\Property;
use App\Contract;
class SellerController extends Controller
{
    public $filestorage = 'files/';
    private $originalname = '';

    public function getSeller(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            return view('seller/dashboard');
        }
        else
            return redirect()->route('adminLanding');
    }

    public function sellFirst(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            return view('seller/inputLotNumber');
        }
        else
            return redirect()->route('adminLanding');
    }

    //new function; adding a lot property
    public function saveproperty(Request $request)
    {
            $id = Auth::id();
            $ownername=$request->lotowner;
            $lotnum = $request->lotNumber;
            $lotarea = $request->lotArea;
            $lottitlenum = $request->lotTitleNumber;
            $uom = $request->UnitOfMeasure;
            $lotType=$request->lotType;
            $NorthEastBoundary = $request->lotNorthEastBoundary;  
            $NorthWestBoundary = $request->lotNorthWestBoundary;    
            $SouthEastBoundary = $request->lotSouthEastBoundary;  
            $SouthWestBoundary = $request->lotSouthWestBoundary;    
            $NorthBoundary = $request->lotNorthBoundary;  
            $EastBoundary = $request->lotEastBoundary;    
            $SouthBoundary = $request->lotSouthBoundary;  
            $WestBoundary = $request->lotWestBoundary; 

            $findLotId=Lot::where('lotNumber',$lotnum)->select('lotId')->first();
            $alreadyPending=Property::where([['lotId',$findLotId->lotId],['user_fk',$id],['status',"pending"]])->first();
                if($alreadyPending){
                    return redirect('/home')->with('poststatusdanger','Property is already on your pending list.');
                }           
            else{
                $lotid = $findLotId->lotId;
                $alreadyConfirmed=Property::where([['lotId',$lotid],['user_fk',$id]])->first();
                if($alreadyConfirmed){
                    return redirect('/home')->with('poststatuswarning','Property is already on your confirmed list');
                }
                else{
                    $alreadyConfirmedByAnother=Property::where([['lotId',$lotid],['user_fk',"!=",$id]])->first();
                        if($alreadyConfirmedByAnother){
                            return redirect('/home')->with('poststatusdanger','Property invalidated. Property is already confirmed by another person.');
                        }
                        $data = Lot::where([['lotOwner',"LIKE","%$ownername%"],['lotArea',$lotarea],['lotNumber',$lotnum],['UnitOfMeasure',$uom],['lotType',"LIKE","%$lotType%"]]);
                        if($lottitlenum)
                            $data = $data->where('lots.lotTitleNumber',$lottitlenum);
                        if($NorthEastBoundary)
                            $data = $data->where('lots.lotNEBoundary',"LIKE","%$NorthEastBoundary%");
                        if($NorthWestBoundary)
                            $data = $data->where('lots.lotNWBoundary',"LIKE","%$NorthWestBoundary%");
                        if($SouthEastBoundary)
                            $data = $data->where('lots.lotSEBoundary',"LIKE","%$SouthEastBoundary%");
                        if($SouthWestBoundary)
                            $data = $data->where('lots.lotSWBoundary',"LIKE","%$SouthWestBoundary%");
                        if($NorthBoundary)
                            $data = $data->where('lots.lotNBoundary',"LIKE","%$NorthBoundary%");
                        if($EastBoundary)
                            $data = $data->where('lots.lotEBoundary',"LIKE","%$EastBoundary%");
                        if($SouthBoundary)
                            $data = $data->where('lots.lotSBoundary',"LIKE","%$SouthBoundary%");
                        if($WestBoundary)
                            $data = $data->where('lots.lotWBoundary',"LIKE","%$WestBoundary%");
                        $data = $data->first();
                        if($data){
                            $result = new Property;
                            $result->lotId = $data->lotId;
                            $result->user_fk = $id;
                            $result->status = "new";
                            $result->save();

                        return redirect('/home')->with('poststatus',
                        'Successfully added property '.$lotnum.' to your list of confirmed properties.');
                        }
                        else{
                            $result = new PendingOwnedLot;
                            $result->user_fk = $id;
                            $result->lotOwner = $ownername;
                            $result->lotNumber = $lotnum;
                            $result->lotTitleNumber = $lottitlenum;
                            $result->lotType = $lotType;
                            $result->lotArea = $lotarea;
                            $result->unitOfMeasure = $uom;
                            $result->lotNorthWestBoundary= $NorthWestBoundary;
                            $result->lotNorthEastBoundary = $NorthEastBoundary;
                            $result->lotSouthwestBoundary = $SouthWestBoundary;
                            $result->lotSouthEastBoundary = $SouthEastBoundary;
                            $result->lotNorthBoundary = $NorthBoundary;
                            $result->lotSouthBoundary = $SouthBoundary;
                            $result->lotWestBoundary = $WestBoundary;
                            $result->lotEastBoundary = $EastBoundary;
                            $result->status= "pending";
                            $result->save();
                            return redirect('/home')->with('poststatusinvalid',
                            'Please make sure to confirm properties by inputting valid information of the property. Added to the list of properties but still pending for confirmation.');
                        }
                }
             }
    }
    public function updatepending($pid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status',"pending")->get();

            $pendinglotDetails= PendingOwnedLot::where('id',$pid)->first();
            $oldLotType = PendingOwnedLot::where('id',$pid)
            ->select('lotType')
            ->first();
            $type = lotType::get();
            $lottype = $type->whereNotIn('lotType', $oldLotType);
            $lottype->all();
            $sellingType = SellingType::get();
            $user=User::where('id',$id)->first();
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
                    $post = $split['data'];
            }
            
            $months=Month::get();
            $paymenttypes=PaymentType::get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            

            $data['ownedLot'] = $ownedLots;
            $data['pendingLot'] = $pendingLots;
            $data['lotType'] = $lottype;
            $data['sellingType'] = $sellingType;
            $data['pendinglotDetails'] = $pendinglotDetails;
            $data['user'] = $user;
            $data['picture'] = $picture;
            $data['notifications'] = $notif;
            $data['months'] = $months;
            $data['paymenttypes'] = $paymenttypes;
            $data['title']="UPDATE PENDING PROPERTY";
        return view('seller/updatepending')->with($data);
    }
    else
        return redirect()->route('adminLanding');
    }


    public function savepending($pid,Request $request){
        $id = Auth::id(); 
        $ownername = $request->lotowner;       
        $lotnum = $request->lotNumber;
        $lotarea = $request->lotArea;
        $lottitlenum = $request->lotTitleNumber;
        $uom = $request->unitOfMeasure;
        $lotType=$request->lotType;
        $NorthEastBoundary = $request->lotNorthEastBoundary;  
        $NorthWestBoundary = $request->lotNorthWestBoundary;    
        $SouthEastBoundary = $request->lotSouthEastBoundary;  
        $SouthWestBoundary = $request->lotSouthWestBoundary;    
        $NorthBoundary = $request->lotNorthBoundary;  
        $EastBoundary = $request->lotEastBoundary;    
        $SouthBoundary = $request->lotSouthBoundary;  
        $WestBoundary = $request->lotWestBoundary;    
        
        $findLotId=Lot::where('lotNumber',$lotnum)->select('lotId')->first();
            if($findLotId){
                $findLotId=Lot::where('lotNumber',$lotnum)->select('lotId')->get();
                foreach($findLotId as $lid)
                {
                    $tempid = $lid->lotId;
                }
                $lotid = $tempid;

            $data = DB::table('lots')
            ->where([['lotOwner',"LIKE","%$ownername%"],['lotArea',$lotarea],['lotNumber',$lotnum],['UnitOfMeasure',$uom],['lotType',"LIKE","%$lotType%"]]);

            if($NorthEastBoundary)
                $data = $data->where('lots.lotNEBoundary',"LIKE","%$NorthEastBoundary%");
            if($NorthWestBoundary)
                $data = $data->where('lots.lotNWBoundary',"LIKE","%$NorthWestBoundary%");
            if($SouthEastBoundary)
                $data = $data->where('lots.lotSEBoundary',"LIKE","%$SouthEastBoundary%");
            if($SouthWestBoundary)
                $data = $data->where('lots.lotSWBoundary',"LIKE","%$SouthWestBoundary%");
            if($NorthBoundary)
                $data = $data->where('lots.lotNBoundary',"LIKE","%$NorthBoundary%");
            if($EastBoundary)
                $data = $data->where('lots.lotEBoundary',"LIKE","%$EastBoundary%");
            if($SouthBoundary)
                $data = $data->where('lots.lotSBoundary',"LIKE","%$SouthBoundary%");
            if($WestBoundary)
                $data = $data->where('lots.lotWBoundary',"LIKE","%$WestBoundary%");
            $data = $data->first();
            $alreadyConfirmedByAnother=Property::where('lotId',$lotid)->first();
            if($alreadyConfirmedByAnother){
                $saveUpdate = PendingOwnedLot::where([['id', $pid],['user_fk', $id]])->update([
                    "status"=>"invalid",
                    ]);
                return redirect('/home')->with('poststatusdanger','Property invalidated. Property is already confirmed by another person.');
            }
            if($data){
                   
                $saveUpdate = PendingOwnedLot::where([['id', $pid],['user_fk', $id]])->update([
                    "status"=>"confirmed"]);                    
                $result = new Property;
                $result->lotId = $data->lotId;
                $result->user_fk = $id;
                $result->status = "new";
                $result->save();

                return redirect('/home')->with('poststatus',
                'Successfully added property '.$lotnum.' to your list of confirmed properties.');
                }
            else{
                $p = PendingOwnedLot::where([['id', $pid],['user_fk', $id]])->first();
               
                        $saveUpdate = PendingOwnedLot::where([['id', $pid],['user_fk', $id]])->update([
                            "lotOwner"=>$ownername,
                            "lotNumber"=>$lotnum,
                            "lotTitleNumber"=>$lottitlenum,
                            "lotType"=>$lotType,
                            "lotArea"=>$lotarea, 
                            "unitOfMeasure"=>$uom, 
                            "lotNorthEastBoundary"=>$NorthEastBoundary,
                            "lotNorthWestBoundary"=>$NorthWestBoundary,
                            "lotSouthEastBoundary"=>$SouthEastBoundary,
                            "lotSouthWestBoundary"=>$SouthWestBoundary,
                            "lotNorthBoundary"=>$NorthBoundary,
                            "lotEastBoundary"=>$EastBoundary,
                            "lotSouthBoundary"=>$SouthBoundary,
                            "lotWestBoundary"=>$WestBoundary,
                            ]);
                    return redirect('/home')->with('poststatusinvalid',
                    'Make sure to input valid property information. Property is still pending for validation');
                }
            }
            else{
                return redirect('/home')->with('poststatusdanger','Please confirm valid properties only.');
            }
    }

    public function sell($lotId){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();
            $lotDetails=Lot::where('lotId',$lotId)->first();

            $oldLotType = DB::table('lots')
            ->select('lotType')
            ->where('lotId',$lotId)
            ->first();      
            $type = lotType::get();
            $lottype = $type->whereNotIn('lotType', $oldLotType);
            $lottype->all();

            $sellingType = SellingType::get();
            $user=User::where('id',$id)->first();
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
                    $post = $split['data'];
            }            
            $months=Month::get();
            $paymenttypes=PaymentType::get();
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
        $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['lotType'] = $lottype;
            $data['sellingType'] = $sellingType;
            $data['lotDetails'] = $lotDetails;
            $data['user'] = $user;
            $data['picture'] = $picture;
            $data['notifications'] = $notif;
            $data['months'] = $months;
            $data['paymenttypes'] = $paymenttypes;
            $data['title']="SELL/CHARTER PROPERTY";
        return view('seller/sell')->with($data);
    }
    else
        return redirect()->route('adminLanding');
    }
    public function storedata(Request $request){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $lotnumber=$request->slotNumber;
            $sellType=$request->sellingType;
            $findLotId=Lot::where('lotNumber',$lotnumber)->select('lotId')->first();  
            //check if the lot is already posted by the user
            $alreadyPosted = Transaction::where([['lotId_fk',$findLotId->lotId],['user_fk', $id]])->where('status','!=','deleted')->first();
            if($alreadyPosted){
                if($sellType=="For Sale"){
                    return redirect()->route('dashboardsell')->with('lotstatus',
                'Property is already posted as For Sale.');
                }
                if($sellType=="For Rent"){
                    return redirect()->route('dashboardlease')->with('lotstatus',
                'Property is already posted as For Rent.');
                }else{
                    return redirect()->route('dashboardlease')->with('lotstatus',
                'Property is already posted as For Lease.');
                }
            }
            else{
            //check if the inputted lot number exist in the lot database  
            if($findLotId){
            $seller = new Transaction;
            $count = $seller::get()->count()+1;
            $tid="sl".$count;
            $seller->tid = "sl".$count;
            $seller->user_fk=$id;
            $seller->lotId_fk=$findLotId->lotId;

            $rightofway=$request->rightofway;
            $value = "";
            foreach($rightofway as $vehicle)
            {
                $value .= $vehicle ." "; 
            }

            $vehicles =substr($value,0,-1);
            $vehicleAccess = Lot::where('lotId',$findLotId->lotId)->update([
                "rightOfWay"=>$vehicles]);    
            $seller->sellingType=$request->sellingtype;
            $sellType=$request->sellingtype;
                if($sellType=="For Lease"){
                    $paymentType=$request->leasepaymenttype;
                    $seller->paymentType=$paymentType;
                    $leaseprice=$request->leaseprice;
                    $seller->leaseDeposit=$request->leasedeposit;
                    $seller->lotPrice=$leaseprice;
                    $seller->contractPeriod=$request->leasecontract;
                    $seller->installDownpayment=null;
                    $seller->installTimeToPay=null;
                }
                else if($sellType=="For Rent"){
                    $paymentType=$request->rentpaymenttype;
                    $seller->paymentType=$paymentType;
                    $rentprice=$request->rentprice;
                    $seller->leaseDeposit=$request->rentdeposit;
                    $seller->lotPrice=$rentprice;
                    $seller->contractPeriod=$request->rentcontract;
                    $seller->installDownPayment=null;
                    $seller->installTimeToPay=null;
                }
                else if($sellType=="For Sale"){
                    $seller->leasedeposit=null;
                    $sellpaymenttype=$request->sellpaymenttype;
                    $seller->paymentType=$sellpaymenttype;
                    if($sellpaymenttype=="Cash"){
                    
                    $cashlotprice=$request->cashlotprice;
                    $seller->lotPrice=$cashlotprice;
                    $seller->installDownpayment=null;
                    $seller->installTimeToPay=null;
                    
                    }
                    else if($sellpaymenttype=="Installment"){
                    $interestRate=$request->interest;
                    $interest=$request->interest/100;
                    $installmentprice=$request->installmentprice;
                    $timetopay=$request->installmenttimetopay;
                    $installmentdownpayment=$request->installmentdownpayment;
                    $installmentPaymentType=$request->installmentPaymentType;
                    $seller->interest=$interestRate;
                    $seller->installPaymentType=$installmentPaymentType;
                    $seller->installTimeToPay=$timetopay;
                    $seller->lotPrice=$installmentprice;
                    $seller->installDownPayment=$installmentdownpayment;
                    
                    $valMonthYear = preg_replace('!\d+!', '', $timetopay);//remove the numbers from the string nga months or years to pay

                    $valueOfYrMos = preg_replace('/\D/', '', $timetopay);//extract the numbers from the string nga months or years to pay
                    
                    $remainingBalanceToPay=$installmentprice-$installmentdownpayment;

                    if($valMonthYear==" year" || $valMonthYear ==" years"){
                        $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                        $totalPayable=$remainingBalanceToPay+$totalInterest;
                        if($installmentPaymentType=="Monthly"){
                            $monthlyPayment=$totalPayable/($valueOfYrMos*12);
                            $monthlyPayment=round($monthlyPayment,0);
                            $seller->installPayment=$monthlyPayment;
                        }
                        else if($installmentPaymentType=="Quarterly"){
                            $quarterlyPayment=$totalPayable/(($valueOfYrMos*12)/3);
                            $quarterlyPayment=round($quarterlyPayment,0);
                            $seller->installPayment=$quarterlyPayment;
                        }
                        else if($installmentPaymentType=="Semi-Annual"){
                            $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                            $sAnnualPayment=round($sAnnualPayment,0);
                            $seller->installPayment=$sAnnualPayment;
                        }
                        else if($installmentPaymentType=="Anualy"){
                            $annualPayment=$totalPayable/($valueOfYrMos);
                            $annualPayment=round($annualPayment,0);
                            $seller->installPayment=$annualPayment;
                        }
                        
                    }
                    else if($valMonthYear==" month" || $valMonthYear ==" months"){
                        $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                        $totalPayable=$remainingBalanceToPay+$totalInterest;

                        if($installmentPaymentType=="Monthly"){
                            $monthlyPayment=$totalPayable/($valueOfYrMos);
                            $monthlyPayment=round($monthlyPayment,0);
                            $seller->installPayment=$monthlyPayment;
                        }
                        else if($installmentPaymentType=="Quarterly"){
                            $quarterlyPayment=$totalPayable/(($valueOfYrMos)/3);
                            $quarterlyPayment=round($quarterlyPayment,0);
                            $seller->installPayment=$quarterlyPayment;
                        }
                        else if($installmentPaymentType=="Semi-Annual"){
                            $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                            $sAnnualPayment=round($sAnnualPayment,0);
                            $seller->installPayment=$sAnnualPayment;
                        }
                        
                    }

                    }
                }
            $seller->lotDescription=$request->lotdescription;
            $seller->status="free";
            $seller->sellingStatus=null;
            $seller->save();
            
            $ownerLotStatus = Property::join('lots','lots.lotId','=','properties.lotId')
            ->where('lots.lotId', $findLotId->lotId)->update([
                "status"=>"posted"
                ]);
            //for the picture
            $files = $request->file('file');
            if($request->hasfile('file'))
            {
                $remove = Panoimage::where('lotId_fk',$findLotId->lotId)->delete();
                foreach($files as $file){
                        $uploadedfiles = new Panoimage;
                        $fileName = $this->filestorage.$file->getClientOriginalName();
                        Storage::disk('public')->put($fileName, File::get($file));
                        $uploadedfiles->fileExt=url('/storage').'/'.$fileName;
                        $uploadedfiles->lotId_fk=$findLotId->lotId;
                        if($file->getMimeType()=='video/mp4' || $file->getMimeType()=='video/wmv' || $file->getMimeType()=='video/flv'){
                            $uploadedfiles->filetype="video";
                        }
                        else if($file->getMimeType()=='image/jpeg' || $file->getMimeType()=='image/jpg' || $file->getMimeType()=='image/png'){
                            $uploadedfiles->filetype="image";
                        }
                        else{
                            return redirect(url('/dashboard'))->with('fileuploadstatus',
                            'File type uploaded is invalid.');
                        }
                        $uploadedfiles->save();
                }
        }
            //for the document
            $documents = $request->file('document');
            if($request->hasfile('document'))
            {
            foreach($documents as $document){
                    $saveDocument = new Document;
                    $fileName = $this->filestorage.$document->getClientOriginalName();
                    Storage::disk('public')->put($fileName, File::get($document));
                    $saveDocument->fileExt=url('/storage').'/'.$fileName;
                    $saveDocument->tid=$tid;
                    $saveDocument->filetype="image";
    
                    $saveDocument->save();
                }
                
            }
            if($sellType=="For Sale"){
                return redirect()->route('dashboardsell')->with('poststatus',
            'Property is successfully posted as For Sale.');
            }
            else if($sellType=="For Rent"){
                return redirect()->route('dashboardlease')->with('poststatus',
                'Property is successfully posted as For Rent.');
            }
            else{
                return redirect()->route('dashboardlease')->with('poststatus',
            'Property is successfully posted as For Lease.');
            }
            
            }
        }
    }
        else
            return redirect()->route('adminLanding');
          
    }

    public function deletePost($tid){
        $post= Transaction::where('tid',$tid)->first();
        $new = Property::where('lotId',$post->lotId_fk)
                        ->update(["status" => "new"]);
        
        $deletePost = Document::where('tid',$tid)->delete();
        $deletePost = Transaction::where('tid',$tid)
                    ->update(["status" => "deleted","sellingStatus"=>"deleted"]);
        $deletePost = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')
                    ->update(["status" => "1"]);
        return redirect()->route('homepage')->with('favoritestatus','Successfully deleted posted property.');


    }
   
    public function listAllForSale(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $sellers = Lot::join('transactions','lots.lotId','=','transactions.lotId_fk')->where([['user_fk',$id],['sellingType',"For Sale"]])->where('status','!=','deleted')->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->paginate(5);

            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;

            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $data['title']="PROPERTIES FOR SALE";
            $data['listall']=$sellers;
            return view('seller/dashboard',['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);  
        }
        else
            return redirect()->route('adminLanding');      
    }

    public function listAllForLease(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $lease = Lot::join('transactions','lots.lotId','=','transactions.lotId_fk')->where('sellingType',"For Lease")->where('status','!=','deleted')->where('transactions.user_fk',$id)->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->paginate(5);

            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }

            $data['pendingLot']= $pendingLots;
            // $data['rent']= $rent;
            $data['lease']= $lease;
            $data['title']="PROPERTIES FOR LEASE";
            return view('seller/dashboardlease',['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);  
        }
        else
            return redirect()->route('adminLanding');      
    }

    public function propertiesSold(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
        
            $sellers=Lot::join('transactions','lots.lotId','=','transactions.lotId_fk')
            ->join('transactiontrails', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
            ->join('users', 'users.id', '=', 'transactiontrails.user_fk')
            ->join('contracts','transactions.tid','=','contracts.tid_fk')
            ->leftjoin('panoimages', 'panoimages.lotId_fk', '=' , 'lots.lotId')
            ->select('name','transactions.sellingType','transactions.paymentType','lotAddress','lotArea','unitOfMeasure','lotType','lotPrice','transactions.installDownPayment','transactions.installPaymentType','filetype','fileExt','rightOfWay','lotDescription','transactions.interest','transactions.installTimeToPay','transactions.installPayment','tid','transactiontrails.created_at','lotOwner','owner','leaserbuyer','datesold')
            ->where('panoimages.filetype',"image")
            ->where('transactions.sellingType',"For Sale")
            ->where('transactions.user_fk',$id)
            ->where('transactiontrails.actions', 'purchased')
            ->orderBy('transactiontrails.created_at', 'desc')
            ->paginate(5);
            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }

            $data['pendingLot']= $pendingLots;
            $data['title']="PROPERTIES SOLD";
            return view('seller/dashboardsold',['listall'=>$sellers],['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);  
        }
        else
            return redirect()->route('adminLanding');    
    }
    public function history(){
        $id=Auth::id();
        $profile = User::where('id',$id)->get();
        $picture = Profile::where('user_fk',$id)->first();
        // dd($sellers);
        $user=User::where('id',$id)->get(); 
        $email=Auth::user()->email;

        $history = DB::table('transactions')
        ->join('contracts', 'transactions.tid', '=' , 'contracts.tid_fk')
        ->join('lots','lots.lotId','=','transactions.lotId_fk')
        ->select('lots.lotNumber','lots.lotAddress','transactions.sellingStatus','transactions.sellingType','contracts.leaserbuyer','contracts.contractperiod','contracts.startcontract','contracts.endcontract','contracts.datesold','contracts.contractprice','contracts.paymenttype','contracts.amortprice')
        ->where('transactions.user_fk',$id)
        ->orderBy('transactions.created_at', 'desc')
        ->paginate(10);
        $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
        ->where('properties.user_fk',$id)
        ->get();
        
        $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

        $notif = Notification::select('data')->get();
        foreach($notif as $split){
        $post = $split['data'];
        }
        $data['profile']= $profile;
        $data['picture']= $picture;
        $data['pendingLot']= $pendingLots;
        $data['ownedLot']= $ownedLots;
        $data['listall']= $history;
        $data['title']="PROPERY HISTORY";
        return view('seller/history')->with($data);  

    }
    public function propertiesGrantedForLease(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
    
            $sellers=Lot::join('transactions','lots.lotId','=','transactions.lotId_fk')
            ->join('transactiontrails', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
            ->join('users', 'users.id', '=', 'transactiontrails.user_fk')
            ->join('contracts','transactions.tid','=','contracts.tid_fk')
            ->leftjoin('panoimages', 'panoimages.lotId_fk', '=' , 'lots.lotId')
            ->select('name','transactions.sellingType','transactions.status','transactions.sellingStatus','transactions.paymentType','lotAddress','lotArea','unitOfMeasure','lotType','lotPrice','transactions.installDownPayment','transactions.installPaymentType','filetype','fileExt','rightOfWay','lotDescription','transactions.interest','transactions.installTimeToPay','transactions.installPayment','transactions.tid','transactiontrails.created_at','lotOwner','owner','leaserbuyer','startcontract','endcontract')
            ->where('panoimages.filetype',"image")
            ->where('transactions.sellingType',"For Lease")
            ->where('transactions.user_fk',$id)
            ->where('transactiontrails.actions', 'purchased')
            ->orderBy('transactiontrails.created_at', 'desc')
            ->paginate(5);
            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $data['pendingLot']= $pendingLots;
            $data['title']="PROPERTIES GRANTED AS LEASED"; 
            return view('seller/dashboardgrantedleased',['listall'=>$sellers],['profile'=>$profile])->with(['picture'=>$picture])->with(['owner'=>$user])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$notif])->with($data);  
        }
        else
            return redirect()->route('adminLanding');    
    }

    public function listallusersintended($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $sellers = Transaction::where('user_fk',$id)->orderBy('created_at', 'desc')->get();
            $picture = Profile::where('user_fk',$id)->first();
            $userintend = Transaction::join('lots','lots.lotId','=','transactions.lotId_fk')->where('tid',$tid)->first();
            $buyers = Transactiontrail::join('users','transactiontrails.user_fk','=','users.id')->leftjoin('profiles','users.id','=','profiles.user_fk')->where('transactiontrails.tid_fk',$tid)->where('transactiontrails.actions','intent')->where('status',null)->select('users.id','users.name','users.address','users.contact','users.secondarycontact','users.email','profiles.fileExt')->get();
                $notif = Notification::limit(5)->get();
                
                $notif = Notification::select('data')->get();
                foreach($notif as $split){
                $post = $split['data'];
                }
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['tid'] = $tid;
            $data['title']=$userintend->sellingType == "For Sale" ? "INTERESTED BUYER(S)":"INTERESTED LEASER(S)";
            return view('/seller/viewuserwhointended',['listall'=>$buyers],['intended'=>$userintend])->with(['picture'=>$picture])->with(['notifications'=>$notif])->with($data);      
        }
        else
            return redirect()->route('adminLanding');  
    }

    public function confirmbuyerleaser(Request $request,$tid,$buyerleaser){
        $type="";
        $usertype=Auth::user()->userType;
        $dateexecuted=$request->dateexecuted;
        $seller=$request->seller;
        $leaserbuyer=$request->leaserbuyer;
        $amortprice=$request->amortprice;
        $contractperiod=$request->contractperiod;
        $startcontract=$request->startcontract;
        $endcontract=$request->endcontract;
        $datesold=$request->datesold;
        $leasepaymenttype=$request->leasepaymenttype;
        $leasedeposit=$request->leasedeposit;
        // ---------------------------------------
        $contractprice=$request->contractprice;
        $sellpaymenttype=$request->sellpaymenttype;
        $downpayment=$request->downpayment;
        $interest=$request->interest;
        $installpaymenttype=$request->installpaymenttype;
        $installtimetopay=$request->installtimetopay;
        $installpayment=$request->installpayment;
        $transaction = Transaction::where('tid',$tid)->first();
        $newcontract = new Contract;
        $newcontract->user_fk =$buyerleaser;
        $newcontract->tid_fk =$tid;
        $newcontract->dateExecuted=$dateexecuted;
        $newcontract->owner=$seller;
        $newcontract->leaserbuyer=$leaserbuyer;
        if($transaction->sellingType=='For Sale'){
            $newcontract->datesold=$datesold;
            $newcontract->paymenttype=$sellpaymenttype;
            $newcontract->contractprice=$contractprice;
            $newcontract->downpayment=$downpayment;
            $newcontract->interest=$interest;
            $newcontract->installpaymenttype=$installpaymenttype;
            $newcontract->installtimetopay=$installtimetopay;
            $newcontract->installpayment=$installpayment;
            $newcontract->status='active';
        }else{
            $newcontract->startcontract=$startcontract;
            $newcontract->endcontract=$endcontract;
            $newcontract->paymenttype=$leasepaymenttype;
            $newcontract->contractperiod=$contractperiod;
            $newcontract->amortprice=$amortprice;
            $newcontract->leasedeposit=$leasedeposit;
            $newcontract->status='active';
        }
        $newcontract->save();

        if($usertype==0){
            $id = Auth::id();
            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $getLotId=DB::table('transactions')
            ->select('lotId_fk')
            ->where('tid',$tid)
            ->first();

            $sellingType= Transaction::where('tid',$tid)->pluck('sellingType');
            foreach($sellingType as $value){
                $sell=$value;
            }
            $selling=$sell;
            if($selling=="For Lease"){
            $soldleasedlot = Transaction::where('tid',$tid)->update([
                "sellingStatus"=>"leased",
            ]); 
            }
            else if($selling=="For Sale"){
                $soldleasedlot = Transaction::where('tid',$tid)->update([
                    "sellingStatus"=>"sold",
                ]); 
            }

            $soldleasedlot = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')->where('status',null)->update([
                "status"=>"1",
            ]);

            $getLotid=Transaction::where('tid',$tid)->first();

            $getbuyer = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')->select('tid_fk')->get();       
            $getid = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')->select('user_fk')->get();
            foreach($getbuyer as $buyer){
                $buyer['tid_fk'];
            }
            foreach($getid as $id){
                $id['user_fk'];   
            }       
            $getname = User::where('id',$buyerleaser)->select('name')->get();
            
            foreach($getname as $name){
                $buyername = $name['name'];
            }
            if($selling=="For Sale"){
                $update = Property::where('lotId',$getLotid->lotId_fk)->update([
                    "user_fk"=>$buyerleaser,
                    "status"=>"new"
                    ]);
                }
                
                    $counter= DB::tabLe('transactiontrails')->get()->count();
                    $counter += 1;
                    $newTransaction = new Transactiontrail;
                        $newTransaction->trailId="trail".$counter;
                        $newTransaction->user_fk=$buyerleaser;
                        $newTransaction->tid_fk=$tid;
                        $newTransaction->actions='purchased';
                        $newTransaction->save();
                
            $notifyafterintend = new Notification;

            $getseller = Transaction::where('tid',$tid)->select('user_fk')->get();    
                foreach($getseller as $a){
                    $b = $a['user_fk'];
                }
            $kuhasellername = User::where('id',$b)->select('name')->get();
            foreach($kuhasellername as $kuhasellernames){
                $kuhasellernamess = $kuhasellernames['name'];
            }
            $getpropertylocation = Lot::where('lotId',$getLotId->lotId_fk)->select('lotAddress')->get();    
            foreach($getpropertylocation as $value){
                $key = $value['lotAddress'];
            }  
            $lotaddress = $key;
            if($selling=="For Lease"){
                $contentintender = "A property posted by ".$kuhasellernamess.", located at ".$lotaddress." is marked as leased to you.";
                $contentother = "A property that you intended located at ".$lotaddress." is already leased.";
                $type="LEASER";
            }
            else if($selling=="For Sale"){
                $contentintender = "A property posted by ".$kuhasellernamess.", located at ".$lotaddress." is marked as sold to you.";
                $contentother = "A property that you intended located at ".$lotaddress." is already sold.";
                $type="BUYER";
                }
            $getbuyerid = User::where('id',$id['user_fk'])->select('id')->get();        
            foreach($getbuyerid as $idofbuyer){
                $buyerr = $idofbuyer['id'];
            }   
            $otherbuyers = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')->where('user_fk','!=',$buyerleaser)->get();  
            foreach($otherbuyers as $val){
                User::findorfail($val->user_fk)->notify (new NotifyUser($contentother));
                $changesellertid = Notification::where([['notifiable_id', $val->user_fk],['tid_fk', null]])
            ->update(["tid_fk" => $tid]);
            }
            User::findorfail($buyerleaser)->notify (new NotifyUser($contentintender));

            $changesellertid = Notification::where([['notifiable_id', $b],['tid_fk', null]])
                ->update(["tid_fk" => $tid]);
            $changesellertid = Notification::where([['notifiable_id', $buyerleaser],['tid_fk', null]])
            ->update(["tid_fk" => $tid]);
            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="CONFIRM ".$type;
            return redirect(url('/home'))->with(['notifications'=>$notif])->with('favoritestatus',
            'Successfully confirmed property '.$type)->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }

    public function listAllIntended(){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $user=User::where('id',$id)->get();        
            $email=Auth::user()->email;
            

            $ownedLots=DB::table('lots')
            ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            ->where('confirmedowners.user_fk',$id)
            ->get()
            ->toarray();
                        $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $data['pendingLot']= $pendingLots;

            $postedLotLnumber=DB::table('lots')
            ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            ->join('Transactions','lots.lotNumber','=','Transactions.slotnumber')
            ->where('confirmedowners.user_fk',$id)
            ->select('lots.lotNumber')
            ->get();

            $intended = "intended";
            $profile = User::where('id',$id)->get();
            $picture = Profile::where('user_fk',$id)->first();
            $intendedlot = Transaction::where([['user_fk',$id],['status',$intended]])->orderBy('created_at', 'desc')->get();

            $notif = Notification::select('data')->get();
            foreach($notif as $split){
            $post = $split['data'];
            }

            $buyers = DB::table('Transactions')
            ->join('buyerlesseetransactions', 'buyerlesseetransactions.tid_fk', '=' , 'Transactions.tid')
            ->where('Transactions.user_fk',$id)
            ->whereNull('buyerlesseetransactions.status')
            ->orderBy('Transactions.created_at', 'desc')
            ->get();
            foreach($buyers as $buyer){
                $name = $buyer->user_fk;
                $nameofbuyer[] = User::where('id',$name)->get();
                }
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
                $data['pendingLot']= $pendingLots;
                $data['ownedLot'] = $ownedLots;
            return view('seller/intendedByBuyer',['profile'=>$profile])->with(['listallintendedlots'=>$intendedlot])->with(['ownedLot'=>$ownedLots])->with(['posted'=>$postedLotLnumber])->with(['owner'=>$user])->with(['picture'=>$picture])->with(['notifications'=>$notif]);
        }
        else
            return redirect()->route('adminLanding');     
    }

    public function showDocuments($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

            $sellers = Document::where('tid',$tid)->get();

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="ATTACHED DOCUMENTS";
            return view('seller/documents',['listall'=>$sellers])->with(['picture'=>$picture])->with($data);
        }
        else
            return redirect()->route('adminLanding');
    }

    public function edit($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

            $user=User::where('id',$id)->first();

            $singleSeller = Lot::join('transactions','transactions.lotId_fk','lots.lotId')->first();
            $lotDetails = DB::table('transactions')
                ->join('lots', 'lots.lotId', '=' , 'transactions.lotId_fk')
                ->where('transactions.tid',$tid)
                ->first();
            $oldLotType = DB::table('transactions')
            ->join('lots', 'lots.lotId', '=' , 'transactions.lotId_fk')
            ->where('transactions.tid',$tid)
            ->select('lotType')
            ->first();
            $type = lotType::get();
            $lottype = $type->whereNotIn('lotType', $oldLotType);
            $lottype->all();

            $oldSellingType = DB::table('Transactions')
            ->select('sellingType')
            ->where('tid',$tid)
            ->first();
            $stype = SellingType::get();
            $sellingType = $stype->whereNotIn('sellingType', $oldSellingType);
            $sellingType->all();
            
            $oldPtype = DB::table('Transactions')
            ->select('paymentType')
            ->where('tid',$tid)
            ->first();
            $paymenttypes=PaymentType::get();
            $pType = $paymenttypes->whereNotIn('paymentType', $oldPtype);
            $pType->all();

            $oldMonth = DB::table('Transactions')
            ->select('installTimeToPay')
            ->where('tid',$tid)
            ->first();
            $months=Month::get();
            $month = $months->whereNotIn('month', $oldMonth);
            $month->all();

            $oldAdvanceDeposit = DB::table('Transactions')
            ->select('leaseDeposit')
            ->where('tid',$tid)
            ->first();
            if($oldAdvanceDeposit==null){
                $advanceDeposit=Month::get();
            }
            else{
                $months=Month::get();
                $advanceDeposit = $months->whereNotIn('month', $oldAdvanceDeposit);
                $advanceDeposit->all();
            }
            $oldContractPeriod = DB::table('Transactions')
            ->select('contractPeriod')
            ->where('tid',$tid)
            ->first();
           
            $months=Month::get();
            $contractperiod = $months->whereNotIn('month', $oldContractPeriod);
            $contractperiod->all();

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['advanceDeposit'] = $advanceDeposit;
            $data['contractperiod'] = $contractperiod;
            $data['title']= "Update Posted Lot Information";
            return view('seller/update',['singleSeller'=>$lotDetails],['lotType'=>$lottype])->with(['sellingType'=>$sellingType])->with(['user'=>$user])->with(['picture'=>$picture])->with(['month'=>$month])->with(['pType'=>$pType])->with($data); 
        }
        else
            return redirect()->route('adminLanding');
        
    }

    public function update($tid,Request $request){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $this->validate($request, [
                'file'=> 'mimes|jpeg,jpg,png',
                'file'=> 'max:50000',
                'video'=> 'mimes|mp4,flv,wmv',
                'video'=> 'max:50000'
            ]);
            $lotnumber=$request->slotNumber;
            $findLotId=Lot::where('lotNumber',$lotnumber)->select('lotId')->first();
            
                            //for the picture
                            $files = $request->file('file');
                            if($request->hasfile('file'))
                            {
                                $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype','image']])->delete();
                                foreach($files as $file){
                                        $uploadedfiles = new Panoimage;
                                        $fileName = $this->filestorage.$file->getClientOriginalName();
                                        Storage::disk('public')->put($fileName, File::get($file));
                                        $uploadedfiles->fileExt=url('/storage').'/'.$fileName;
                                        $uploadedfiles->lotId_fk=$findLotId->lotId;
                                        if($file->getMimeType()=='video/mp4'){
                                            $uploadedfiles->filetype="video";
                                        }
                                        else if($file->getMimeType()=='image/jpeg' || $file->getMimeType()=='image/jpg' || $file->getMimeType()=='image/png'){
                                            $uploadedfiles->filetype="image";
                                            $image = "image";
                                            $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype',$image]])->delete();
                                        }
                                        else{
                                            return redirect(url('/dashboard'))->with('fileuploadstatus',
                                            'Image type uploaded is invalid.');
                                        }
                                        $uploadedfiles->save();
                                }
                        }
                        $otherfiles = $request->file('video');
                        // dd($otherfiles);
                        if($request->hasfile('video'))
                        {   $video = "video";
                            $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype',$video]])->delete();
                            foreach($otherfiles as $files){
                                $uploadedthefiles = new Panoimage;
                                $fileName = $this->filestorage.$files->getClientOriginalName();
                                Storage::disk('public')->put($fileName, File::get($files));
                                $uploadedthefiles->fileExt=url('/storage').'/'.$fileName;
                                $uploadedthefiles->lotId_fk=$findLotId->lotId;
                                if($files->getMimeType()=='video/mp4' || $files->getMimeType()=='video/flv' || $files->getMimeType()=='video/wmv'){
                                    $uploadedthefiles->filetype="video";
                                    
                                }
                                else{
                                    return redirect(url('/dashboard'))->with('fileuploadstatus',
                                    'Video type uploaded is invalid.');
                                }
                                $uploadedthefiles->save();
                            } 
                    }

            //for the document
            $documents = $request->file('document');
            if($request->hasfile('document'))
                {
                    $remove = Document::where('tid',$tid)->delete();
            foreach($documents as $document){
                    $saveDocument = new Document;
                    $fileName = $this->filestorage.$document->getClientOriginalName();
                    Storage::disk('public')->put($fileName, File::get($document));
                    $saveDocument->fileExt=url('/storage').'/'.$fileName;
                    $saveDocument->tid=$tid;
                    $saveDocument->filetype="image";

                    $saveDocument->save();
                }
                
            }
            
                $rightofway=$request->rightofway;
                $value = "";
                foreach($rightofway as $vehicle)
                {
                    $value .= $vehicle ." "; 
                }

                $vehicles =substr($value,0,-1);
                $vehicleAccess = Lot::where('lotId',$findLotId->lotId)->update([
                    "rightOfWay"=>$vehicles]);    
                $sellType=$request->sellingtype;
                    if($sellType=="For Lease"){
                        $paymentType=$request->leasepaymenttype;
                        $leaseprice=$request->leaseprice;
                        $leasedeposit=$request->leasedeposit;
                        $contractPeriod=$request->contractPeriod;
                        $installmentdownpayment=null;
                        $installmenttimetopay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "paymentType"=>$paymentType,
                            "leaseDeposit"=>$leasedeposit,
                            "lotPrice"=>$leaseprice,
                            "contractPeriod"=>$contractPeriod,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                    }
                    else if($sellType=="For Rent"){
                        $paymentType=$request->rentpaymenttype;
                        $rentprice=$request->rentprice;
                        $leaseDeposit=$request->rentdeposit;
                        $seller->contractPeriod=$request->rentcontract;
                        $installDownPayment=null;
                        $installTimeToPay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "paymentType"=>$paymentType,
                            "leaseDeposit"=>$leasedeposit,
                            "lotPrice"=>$leaseprice,
                            "contractPeriod"=>null,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                    }
                    else if($sellType=="For Sale"){
                        $leasedeposit=null;
                        $sellpaymenttype=$request->sellpaymenttype;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "leaseDeposit"=>$leasedeposit,
                            "paymentType"=>$sellpaymenttype
                        ]);

                        if($sellpaymenttype=="Cash"){
                        
                        $cashlotprice=$request->cashlotprice;
                        $installmentdownpayment=null;
                        $installmenttimetopay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "lotPrice"=>$cashlotprice,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                        
                        }
                        else if($sellpaymenttype=="Installment"){
                        $interestRate=$request->interest;
                        $interest=$request->interest/100;
                        $installmentprice=$request->installmentprice;
                        $timetopay=$request->installmenttimetopay;
                        $installmentdownpayment=$request->installmentdownpayment;
                        $installmentPaymentType=$request->installmentPaymentType;
                    
                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "interest"=>$interestRate,
                            "installPaymentType"=>$installmentPaymentType,
                            "installTimeToPay"=>$timetopay,
                            "lotPrice"=>$installmentprice,
                            "installDownPayment"=>$installmentdownpayment
                        ]);
                        $valMonthYear = preg_replace('!\d+!', '', $timetopay);//remove the numbers from the string nga months or years to pay

                        $valueOfYrMos = preg_replace('/\D/', '', $timetopay);//extract the numbers from the string nga months or years to pay
                        
                        $remainingBalanceToPay=$installmentprice-$installmentdownpayment;

                        if($valMonthYear==" year" || $valMonthYear ==" years"){
                            $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                            $totalPayable=$remainingBalanceToPay+$totalInterest;
                            if($installmentPaymentType=="Monthly"){
                                $monthlyPayment=$totalPayable/($valueOfYrMos*12);
                                $monthlyPayment=round($monthlyPayment,0);
                                $installmentPayment=$monthlyPayment;
                            }
                            else if($installmentPaymentType=="Quarterly"){
                                $quarterlyPayment=$totalPayable/(($valueOfYrMos*12)/3);
                                $quarterlyPayment=round($quarterlyPayment,0);
                                $installmentPayment=$quarterlyPayment;
                            }
                            else if($installmentPaymentType=="Semi-Annual"){
                                $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                                $sAnnualPayment=round($sAnnualPayment,0);
                                $installmentPayment=$sAnnualPayment;
                            }
                            else if($installmentPaymentType=="Anualy"){
                                $annualPayment=$totalPayable/($valueOfYrMos);
                                $annualPayment=round($annualPayment,0);
                                $installmentPayment=$annualPayment;
                            }
                            $sellerRecord = Transaction::where('tid', $tid)->update([
                                "installPayment"=>$installmentPayment
                                ]);
                            
                        }
                        else if($valMonthYear==" month" || $valMonthYear ==" months"){
                            $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                            $totalPayable=$remainingBalanceToPay+$totalInterest;

                            if($installmentPaymentType=="Monthly"){
                                $monthlyPayment=$totalPayable/($valueOfYrMos);
                                $monthlyPayment=round($monthlyPayment,0);
                                $installmentPayment=$monthlyPayment;
                            }
                            else if($installmentPaymentType=="Quarterly"){
                                $quarterlyPayment=$totalPayable/(($valueOfYrMos)/3);
                                $quarterlyPayment=round($quarterlyPayment,0);
                                $installmentPayment=$quarterlyPayment;
                            }
                            else if($installmentPaymentType=="Semi-Annual"){
                                $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                                $sAnnualPayment=round($sAnnualPayment,0);
                                $installmentPayment=$sAnnualPayment;
                            }
                            $sellerRecord = Transaction::where('tid', $tid)->update([
                            "installPayment"=>$installmentPayment
                            ]);
                        }

                        }
                    }
                $slotdescription=$request->lotdescription;
                $sellerRecord = Transaction::where('tid', $tid)->update([
                "sellingType"=>$sellType,
                "lotDescription"=>$slotdescription
                ]);
            
            

                if($sellType=="For Sale"){
                    return redirect()->route('dashboardsell')->with('updatestatus',
                'Successfully updated posted information.');
                }
                else{
                    return redirect()->route('dashboardlease')->with('updatestatus',
                'Successfully updated posted information.');
                }
        }
        else
            return redirect()->route('adminLanding');

    }

    public function repost($tid){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $id=Auth::id();
            $picture = Profile::where('user_fk',$id)->first();

            $user=User::where('id',$id)->first();

            $singleSeller = Transaction::find($tid);
            $lotDetails = DB::table('transactions')
                ->join('lots', 'lots.lotId', '=' , 'transactions.lotId_fk')
                ->where('transactions.tid',$tid)
                ->first();
            $oldLotType = DB::table('transactions')
            ->join('lots', 'lots.lotId', '=' , 'transactions.lotId_fk')
            ->where('transactions.tid',$tid)
            ->select('lotType')
            ->first();
            $type = lotType::get();
            $lottype = $type->whereNotIn('lotType', $oldLotType);
            $lottype->all();

            $oldSellingType = DB::table('Transactions')
            ->select('sellingType')
            ->where('tid',$tid)
            ->first();
            $stype = SellingType::get();
            $sellingType = $stype->whereNotIn('sellingType', $oldSellingType);
            $sellingType->all();
            
            $oldPtype = DB::table('Transactions')
            ->select('paymentType')
            ->where('tid',$tid)
            ->first();
            $paymenttypes=PaymentType::get();
            $pType = $paymenttypes->whereNotIn('paymentType', $oldPtype);
            $pType->all();

            $oldMonth = DB::table('Transactions')
            ->select('installTimeToPay')
            ->where('tid',$tid)
            ->first();
            $months=Month::get();
            $month = $months->whereNotIn('month', $oldMonth);
            $month->all();

            $oldAdvanceDeposit = DB::table('Transactions')
            ->select('leaseDeposit')
            ->where('tid',$tid)
            ->first();
            if($oldAdvanceDeposit==null){
                $advanceDeposit=Month::get();
            }
            else{
                $months=Month::get();
                $advanceDeposit = $months->whereNotIn('month', $oldAdvanceDeposit);
                $advanceDeposit->all();
            }
            $oldContractPeriod = DB::table('Transactions')
            ->select('contractPeriod')
            ->where('tid',$tid)
            ->first();
           
            $months=Month::get();
            $contractperiod = $months->whereNotIn('month', $oldContractPeriod);
            $contractperiod->all();

            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['advanceDeposit'] = $advanceDeposit;
            $data['contractperiod'] = $contractperiod;
            $data['title']="Repost Property";
            return view('seller/repost',['singleSeller'=>$lotDetails],['lotType'=>$lottype])->with(['sellingType'=>$sellingType])->with(['user'=>$user])->with(['picture'=>$picture])->with(['month'=>$month])->with(['pType'=>$pType])->with($data); 
        }
        else
            return redirect()->route('adminLanding');
        
    }

    public function post($tid,Request $request){
        $usertype=Auth::user()->userType;
        if($usertype==0){
            $this->validate($request, [
                'file'=> 'mimes|jpeg,jpg,png',
                'file'=> 'max:50000',
                'video'=> 'mimes|mp4,flv,wmv',
                'video'=> 'max:50000'
            ]);
        $lotnumber=$request->slotNumber;
            $findLotId=Lot::where('lotNumber',$lotnumber)->select('lotId')->first();
            
                            //for the picture
                            $files = $request->file('file');
                            if($request->hasfile('file'))
                            {
                                $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype','image']])->delete();
                                foreach($files as $file){
                                        $uploadedfiles = new Panoimage;
                                        $fileName = $this->filestorage.$file->getClientOriginalName();
                                        Storage::disk('public')->put($fileName, File::get($file));
                                        $uploadedfiles->fileExt=url('/storage').'/'.$fileName;
                                        $uploadedfiles->lotId_fk=$findLotId->lotId;
                                        if($file->getMimeType()=='video/mp4'){
                                            $uploadedfiles->filetype="video";
                                        }
                                        else if($file->getMimeType()=='image/jpeg' || $file->getMimeType()=='image/jpg' || $file->getMimeType()=='image/png'){
                                            $uploadedfiles->filetype="image";
                                            $image = "image";
                                            $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype',$image]])->delete();
                                        }
                                        else{
                                            return redirect(url('/dashboard'))->with('fileuploadstatus',
                                            'Image type uploaded is invalid.');
                                        }
                                        $uploadedfiles->save();
                                }
                        }
                        $otherfiles = $request->file('video');
                        if($request->hasfile('video'))
                        {   $video = "video";
                            $remove = Panoimage::where([['lotId_fk',$findLotId->lotId],['filetype',$video]])->delete();
                            foreach($otherfiles as $files){
                                $uploadedthefiles = new Panoimage;
                                $fileName = $this->filestorage.$files->getClientOriginalName();
                                Storage::disk('public')->put($fileName, File::get($files));
                                $uploadedthefiles->fileExt=url('/storage').'/'.$fileName;
                                $uploadedthefiles->lotId_fk=$findLotId->lotId;
                                if($files->getMimeType()=='video/mp4' || $files->getMimeType()=='video/flv' || $files->getMimeType()=='video/wmv'){
                                    $uploadedthefiles->filetype="video";
                                    
                                }
                                else{
                                    return redirect(url('/dashboard'))->with('fileuploadstatus',
                                    'Video type uploaded is invalid.');
                                }
                                $uploadedthefiles->save();
                            } 
                    }

            //for the document
            $documents = $request->file('document');
            if($request->hasfile('document'))
                {
                    $remove = Document::where('tid',$tid)->delete();
            foreach($documents as $document){
                    $saveDocument = new Document;
                    $fileName = $this->filestorage.$document->getClientOriginalName();
                    Storage::disk('public')->put($fileName, File::get($document));
                    $saveDocument->fileExt=url('/storage').'/'.$fileName;
                    $saveDocument->tid=$tid;
                    $saveDocument->filetype="image";

                    $saveDocument->save();
                }
                
            }
            
                $rightofway=$request->rightofway;
                $value = "";
                foreach($rightofway as $vehicle)
                {
                    $value .= $vehicle ." "; 
                }

                $vehicles =substr($value,0,-1);
                $vehicleAccess = Lot::where('lotId',$findLotId->lotId)->update([
                    "rightOfWay"=>$vehicles]);    
                $sellType=$request->sellingtype;
                    if($sellType=="For Lease"){
                        $paymentType=$request->leasepaymenttype;
                        $leaseprice=$request->leaseprice;
                        $leasedeposit=$request->leasedeposit;
                        $contractPeriod=$request->contractPeriod;
                        $installmentdownpayment=null;
                        $installmenttimetopay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "paymentType"=>$paymentType,
                            "leaseDeposit"=>$leasedeposit,
                            "lotPrice"=>$leaseprice,
                            "contractPeriod"=>$contractPeriod,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                    }
                    else if($sellType=="For Rent"){
                        $paymentType=$request->rentpaymenttype;
                        $rentprice=$request->rentprice;
                        $leaseDeposit=$request->rentdeposit;
                        $seller->contractPeriod=$request->rentcontract;
                        $installDownPayment=null;
                        $installTimeToPay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "paymentType"=>$paymentType,
                            "leaseDeposit"=>$leasedeposit,
                            "lotPrice"=>$leaseprice,
                            "contractPeriod"=>null,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                    }
                    else if($sellType=="For Sale"){
                        $leasedeposit=null;
                        $sellpaymenttype=$request->sellpaymenttype;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "leaseDeposit"=>$leasedeposit,
                            "paymentType"=>$sellpaymenttype
                        ]);

                        if($sellpaymenttype=="Cash"){
                        
                        $cashlotprice=$request->cashlotprice;
                        $installmentdownpayment=null;
                        $installmenttimetopay=null;

                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "lotPrice"=>$cashlotprice,
                            "installDownPayment"=>$installmentdownpayment,
                            "installTimeToPay"=>$installmenttimetopay
                        ]);
                        
                        }
                        else if($sellpaymenttype=="Installment"){
                        $interestRate=$request->interest;
                        $interest=$request->interest/100;
                        $installmentprice=$request->installmentprice;
                        $timetopay=$request->installmenttimetopay;
                        $installmentdownpayment=$request->installmentdownpayment;
                        $installmentPaymentType=$request->installmentPaymentType;
                    
                        $sellerRecord = Transaction::where('tid', $tid)->update([
                            "interest"=>$interestRate,
                            "installPaymentType"=>$installmentPaymentType,
                            "installTimeToPay"=>$timetopay,
                            "lotPrice"=>$installmentprice,
                            "installDownPayment"=>$installmentdownpayment
                        ]);
                        $valMonthYear = preg_replace('!\d+!', '', $timetopay);//remove the numbers from the string nga months or years to pay

                        $valueOfYrMos = preg_replace('/\D/', '', $timetopay);//extract the numbers from the string nga months or years to pay
                        
                        $remainingBalanceToPay=$installmentprice-$installmentdownpayment;

                        if($valMonthYear==" year" || $valMonthYear ==" years"){
                            $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                            $totalPayable=$remainingBalanceToPay+$totalInterest;
                            if($installmentPaymentType=="Monthly"){
                                $monthlyPayment=$totalPayable/($valueOfYrMos*12);
                                $monthlyPayment=round($monthlyPayment,0);
                                $installmentPayment=$monthlyPayment;
                            }
                            else if($installmentPaymentType=="Quarterly"){
                                $quarterlyPayment=$totalPayable/(($valueOfYrMos*12)/3);
                                $quarterlyPayment=round($quarterlyPayment,0);
                                $installmentPayment=$quarterlyPayment;
                            }
                            else if($installmentPaymentType=="Semi-Annual"){
                                $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                                $sAnnualPayment=round($sAnnualPayment,0);
                                $installmentPayment=$sAnnualPayment;
                            }
                            else if($installmentPaymentType=="Anualy"){
                                $annualPayment=$totalPayable/($valueOfYrMos);
                                $annualPayment=round($annualPayment,0);
                                $installmentPayment=$annualPayment;
                            }
                            $sellerRecord = Transaction::where('tid', $tid)->update([
                                "installPayment"=>$installmentPayment
                                ]);
                            
                        }
                        else if($valMonthYear==" month" || $valMonthYear ==" months"){
                            $totalInterest=$remainingBalanceToPay*($interest/100)*$valueOfYrMos;
                            $totalPayable=$remainingBalanceToPay+$totalInterest;

                            if($installmentPaymentType=="Monthly"){
                                $monthlyPayment=$totalPayable/($valueOfYrMos);
                                $monthlyPayment=round($monthlyPayment,0);
                                $installmentPayment=$monthlyPayment;
                            }
                            else if($installmentPaymentType=="Quarterly"){
                                $quarterlyPayment=$totalPayable/(($valueOfYrMos)/3);
                                $quarterlyPayment=round($quarterlyPayment,0);
                                $installmentPayment=$quarterlyPayment;
                            }
                            else if($installmentPaymentType=="Semi-Annual"){
                                $sAnnualPayment=$totalPayable/($valueOfYrMos*2);
                                $sAnnualPayment=round($sAnnualPayment,0);
                                $installmentPayment=$sAnnualPayment;
                            }
                            $sellerRecord = Transaction::where('tid', $tid)->update([
                            "installPayment"=>$installmentPayment
                            ]);
                        }

                        }
                    }
                $slotdescription=$request->lotdescription;
                $sellerRecord = Transaction::where('tid', $tid)->update([
                "count"=>null,
                "sellingStatus"=>null,
                "sellingType"=>$sellType,
                "status"=>'free',
                "lotDescription"=>$slotdescription
                ]);    

                $deletePost = Transactiontrail::where('tid_fk',$tid)->where('actions','intent')->where('status',null)
                            ->update(["status" => "1"]);
        if($sellType=="For Sale"){
            return redirect()->route('dashboardsell')->with('repoststatus',
        'Successfully reposted property.');
        }
        else{
            return redirect()->route('dashboardlease')->with('repoststatus',
        'Successfully reposted property.');
        }
    }
    else
        return redirect()->route('adminLanding');
    }

    public function renewal(){
        $id=Auth::id();
        $profile = User::where('id',$id)->get();
        $picture = Profile::where('user_fk',$id)->first();
        $user=User::where('id',$id)->get(); 
        $email=Auth::user()->email;

        $renewlist = DB::table('transactions')
        ->join('contracts', 'transactions.tid', '=' , 'contracts.tid_fk')
        ->join('transactiontrails','transactiontrails.tid_fk','=','transactions.tid')
        ->join('lots','lots.lotId','=','transactions.lotId_fk')
        ->select('lots.lotNumber','lots.lotAddress','transactions.tid','transactions.sellingStatus','transactions.sellingType','contracts.leaserbuyer','contracts.contractperiod','contracts.startcontract','contracts.endcontract','contracts.datesold')
        ->where('transactions.user_fk',$id)
        ->where('transactiontrails.actions','renew')
        ->orderBy('transactiontrails.created_at', 'desc')
        ->paginate(10);

        $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
        ->where('properties.user_fk',$id)
        ->get();
        
        $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

        $notif = Notification::select('data')->get();
        foreach($notif as $split){
        $post = $split['data'];
        }
        $data['profile']= $profile;
        $data['picture']= $picture;
        $data['pendingLot']= $pendingLots;
        $data['ownedLot']= $ownedLots;
        $data['listall']= $renewlist;
        $data['title']="PROPERY RENEWAL";
        return view('seller/contractrenew')->with($data);  

    }

    public function renewContract($tid,$status){
        $getproperty = Lot::join('transactions','transactions.lotId_fk','=','lots.lotId')->where('tid',$tid)->select('lotAddress','user_fk')->first();    
        $lotaddress = $getproperty->lotAddress;
        $getsellerid = $getproperty->user_fk;

        $getcontract = Contract::where('tid_fk',$tid)->where('status','active')->first();
        $contractperiod=$getcontract->contractperiod;
        $startcontract=$getcontract->startcontract;
        $endcontract=$getcontract->endcontract;
        $leaser=$getcontract->user_fk;
        $years = preg_replace('/\D/', '', $contractperiod);//extract the numbers from the string
        $years=$years*12;
        $startdate = strtotime(date("Y-m-d", strtotime($startcontract)) . " +".$years." month");
        $startdate = date("Y-m-d",$startdate);
        $enddate = strtotime(date("Y-m-d", strtotime($endcontract)) . " +".$years." month");
        $enddate = date("Y-m-d",$enddate);
        if($status=='yes'){

            $contentLeaser = "Your request to renew the contract of lease on a property located at ".$lotaddress." has been approved by the lessor.";

            User::findorfail($leaser)->notify(new NotifyUser($contentLeaser));
            $changesellertid = Notification::where([['notifiable_id', $leaser],['tid_fk', null]])->update(["tid_fk" => $tid]);
            $changestatus = Contract::where('tid_fk',$tid)->where('status','active')->update([
                "status" => "active",
                "startcontract"=> $startdate,
                "endcontract"=> $enddate
                ]);
            $changestatus = Transactiontrail::where('tid_fk',$tid)->where('actions','renew')->update([
                "actions" => "renewed"
                ]);
     
        return redirect()->route('homepage')->with('favoritestatus',
        "A request to renew contract of lease on your property located at ".$lotaddress." has been approved. A notification has been sent to the leaser.");
        }else{
            $contentLeaser = "Your request to renew the contract of lease on a property located at ".$lotaddress." has been declined by the lessor.";

            User::findorfail($getsellerid)->notify(new NotifyUser($contentLeaser));
            $changesellertid = Notification::where([['notifiable_id', $getsellerid],['tid_fk', null]])->update(["tid_fk" => $tid]);

            $changestatus = Transaction::where('tid',$tid)->update([
                "status" => "free",
                "count"=> NULL,
                "sellingStatus"=> NULL
                ]);

            $changestatus = Contract::where('tid_fk',$tid)->where('user_fk',$id)->where('status','active')->update([
                "status" => "inactive"
                ]);
                
            $changestatus = Transactiontrail::where('tid_fk',$tid)->where('actions','renew')->update([
                "actions" => "declined"
                ]);

            return redirect()->route('homepage')->with('favoritestatus',
        "A request to renew a contract of lease on your property located at ".$lotaddress." has been declined. A notification has been sent to the leaser.");
        }
    }

}