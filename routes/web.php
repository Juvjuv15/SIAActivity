<?php
use App\Profile;
use App\Lot;
use App\lotType;
use App\Price;
use App\Transaction;
use App\Property;
use App\Notification;
use App\Transactiontrail;
use App\PendingOwnedLot;

// ---------------------
use App\Radiusscore;
use App\Pricescore;
use App\Criteria;
use App\Estabscore;
use App\Pricerange;
use App\Radiusrange;
// ----------------------
use Illuminate\Notifications\Notifiable;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::middleware(['auth'])->group(function(){
Route::get('/home', function () { 
    $usertype=Auth::user()->userType;
    if($usertype=="0"){
        $id=Auth::id();
        $email=Auth::user()->email;
        
        $picture = Profile::where('user_fk',$id)->first();
        $notif = Notification::select('data')->get();
        // $notif->unreadNotifications()->update(['read_at'=> now()]);
            foreach($notif as $split){
                    $post = $split['data'];
            }
            // $post->unreadNotifications->update(['read_at'=> now()]);
        $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
        $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();
        $renew=Transactiontrail::join('transactions','transactions.tid','=','transactiontrails.tid_fk')->where('actions','renew')->get();
        $forsale = Transaction::where([['user_fk',$id],['sellingType',"For Sale"]])->orderBy('created_at', 'desc')->get();
        $forlease = Transaction::orWhere('sellingType',"For Lease")->where('user_fk',$id)->orderBy('created_at', 'desc')->get();
        // $forlease = Transaction::where([['user_fk',$id],['sellingType',"For Lease"]])->orWhere('sellingType',"For Rent")->orderBy('created_at', 'desc')->get();
        // $lottype = lotType::distinct()->get(['lotType']); 
        // $price = Price::distinct()->get(['price']);
        $data['pendingLot']=$pendingLots;
        // $data['propertysold']=$sold;
        // $data['grantedleased']=$grantedleased;
        $data['ownedLot']=$ownedLots;
        $data['renew']=$renew;
        // $data['bought']=$bought;
        // $data['rented']=$rented;
        // $data['intended']=$intended;
        // $data['soldasset']=$soldasset;
        // $data['boughtasset']=$boughtasset;
        $data['forsale']=$forsale;
        $data['forlease']=$forlease;
        $data['title']="HOME";
        return view('home')->with(['picture'=>$picture])->with(['notifications'=>$notif])->with($data); 
    }
    else
        return redirect()->route('adminLanding');
    })->name('homepage');

//for the seller
Route::get('/history','SellerController@history')->name('propertyhistory');
Route::get('/sellLot','SellerController@sellFirst');
Route::get('/sell/{lotId}/post','SellerController@sell')->name('sell');
Route::post('seller/saveproperty','SellerController@saveproperty');
Route::post('/seller/addlot','SellerController@storedata');
//update pending
Route::get('/pendingDashboard','SellerController@pendingDashboardList')->name('pendingDashboard');
Route::get('/update/{id}/pending','SellerController@updatePending')->name('updatePending');
Route::post('/add/{id}/savependingProperty','SellerController@savePending')->name('savePending');
//display dashboard
Route::get('/dashboard','SellerController@listAllForSale')->name('dashboardsell');
Route::get('/dashboardlease','SellerController@listAllForLease')->name('dashboardlease');
Route::get('/sellerpotentialdashboard','SellerController@listAllIntended')->name('potential');
Route::get('/documents/{tid}/view','SellerController@showDocuments')->name('document');
Route::get('/viewuserwhointended/{tid}/list','SellerController@listallusersintended')->name('listuser');
Route::post('/dashboard/{tid}/{buyerleaser}/soldleased','SellerController@confirmbuyerleaser');
Route::get('/ownedlots','SellerController@displayOwnedLots')->name('ownedLots');
Route::get('/propertiesSold','SellerController@propertiesSold')->name('propertiesSold');
Route::get('/propertiesGrantedForLease','SellerController@propertiesGrantedForLease')->name('propertiesGrantedForLease');
//edit post
Route::get('/seller/{tid}/edit','SellerController@edit');
Route::post('/seller/{tid}/edit','SellerController@update');
//repost
Route::get('/seller/{tid}/repost','SellerController@repost');
Route::post('/seller/{tid}/repost','SellerController@post');
Route::get('/properties', function () { 
    $usertype=Auth::user()->userType;
    if($usertype==0){
        $id=Auth::id();
        $email=Auth::user()->email;

        $picture = Profile::where('user_fk',$id)->first();
        $ownedLots=DB::table('lots')
            ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
            ->where('confirmedowners.email',$email)
            // ->select('lots.*', 'lots.lotNumber')
            ->get()
            ->toArray();
             //query
                    $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();


        return view('seller/properties')->with(['picture'=>$picture])->with(['ownedLot'=>$ownedLots])->with(['pendingLot'=>$pendingLots]);
    }
    else
        return redirect()->route('adminLanding');
})->name('properties');
Route::get('/deletePost/{tid}/delete','SellerController@deletePost');
Route::get('/renewcontract/lease','SellerController@renewal')->name('propertiesRenew');
Route::get('/renewcontract/{tid}/{status}/lease','SellerController@renewContract');

//both
Route::get('/contract/{tid}/view','universalController@showContract')->name('viewcontract');
Route::get('/contracts/{tid}/view','universalController@showContractSeller')->name('viewcontract');

 // for the buyer
Route::get('/map','BuyerController@viewMap');
Route::get('/displayData/{tid}/view', 'BuyerController@displayLot');
Route::get('/document/{tid}/view','BuyerController@showDocument');
Route::get('/displayIntended/{tid}/view', 'BuyerController@displayIntended');
Route::get('/newInquire/{tid}/intend','BuyerController@newinquire');
Route::get('/cancelInquire/{tid}/cancel','BuyerController@cancelInquire');
Route::get('/intendeddashboard','BuyerController@dashboard')->name('intendedlots');
Route::get('/boughtLots','BuyerController@boughtLots')->name('boughtproperties');
Route::get('/rentedLots','BuyerController@rentedLots')->name('rentedproperties');
Route::get('/viewDetail/{tid}/show','BuyerController@notify');
Route::get('/displaydatainnotif/{tid}/popoutnotif', 'BuyerController@displaydatainnotif'); 
Route::get('/cancel/{tid}/lease','BuyerController@cancelLease');
Route::get('/renew/{tid}/{status}/lease','BuyerController@renewContract');
// Route::get('/searchLots', 'MapController@searchLots');

//for the admin
Route::get('/adminLanding','adminController@index')->name('adminLanding');
Route::get('uploadCsv','adminController@csvIndex');
Route::post('uploadCsv','adminController@csvSave');
Route::get('/lotList','adminController@listLot')->name('lotlist');
Route::get('/lots/{lotId}/view','adminController@displayLotDetails');
Route::get('/lot/addLot','adminController@newLot');
Route::post('/lot/newLot','adminController@saveLot');
Route::get('/updatelot/{lotId}/edit','adminController@update');
Route::post('/updatelot/{lotId}/save','adminController@saveUpdate');
Route::get('/confirmOwner','adminController@confirmOwner')->name('confirmOwner');
Route::post('/saveOwner','adminController@saveOwner');
Route::get('/confirmedList','adminController@confirmedList');
Route::get('/changePassword','LoginController@changePass')->name('changePassIndex');
Route::post('/changePassword','LoginController@changePassword')->name('changePassword');
Route::get('/add/adminUser','adminController@newUser');
Route::post('/save/adminUser','adminController@saveUser')->name('saveUser');
Route::get('/update/criteria','adminController@updateCriteria')->name('updatecriteria');
Route::post('/update/recommender','adminController@updateCriteriaNow');
//for updating profile picture
Route::get('/changeProfile/{id}/edit','ProfileController@updateProfile');
Route::post('/changeProfile/{id}/save','ProfileController@saveProfile');
Route::get('/myprofile','ProfileController@userProfile')->name('userProfile');
//for viewing user profile
Route::get('/UserProfile/{userId}/view','ProfileController@viewProfile');

//for the notification
Route::get('/mark/{tid_fk}/{notif_id}/notif','universalController@marknotif');
Route::get('/view/{tid_fk}/notif','universalController@viewnotif');
Route::get('markasread/{notif_id}/confirmedproperty','universalController@markasread');
//view all notifcation page
Route::get('/viewallnotif', function () { 
    $usertype=Auth::user()->userType;
    if($usertype==0){
        $id=Auth::id();
        $email=Auth::user()->email;
        Auth()->user()->unreadNotifications()->update(['read_at'=>now()]);
        $picture = Profile::where('user_fk',$id)->first();
        // $ownedLots=DB::table('lots')
        //     ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
        //     ->where('confirmedowners.email',$email)
        //     // ->select('lots.*', 'lots.lotNumber')
        //     ->get()
        //     ->toArray();
        $allnotif = Notification::select('data')->get();
        foreach($allnotif as $split){
                    $post = $split['data'];
            }
            $ownedLots=Lot::join('properties','lots.lotId','=','properties.lotId')
            ->where('properties.user_fk',$id)
            ->get();
            
            $pendingLots = PendingOwnedLot::where('user_fk',$id)->where('status','=',"pending")->get();

            $data['pendingLot']= $pendingLots;
            $data['ownedLot'] = $ownedLots;
            $data['title']="NOTIFICATION(S)";
        return view('viewallnotif')->with(['picture'=>$picture])->with(['notifications'=>$allnotif])->with($data);
    }
    else
        return redirect()->route('adminLanding');
    })->name('allnotif');

    Route::get('instantplot.com','universalController@landing')->name('instantplot.com');

    // Route::get('/searchLots', 'MapController@searchLots');
    // Route::get('/polygon', 'MapController@drawPolygon');
    // Route::post('/filter', 'MapController@filter');
});
//loging in and for the universal controller
Route::get('/instantplot','LoginController@loginAdmin')->name('admin_login');
Route::view('/login','auth.login')->name('login');
Route::post('/login','LoginController@authenticate');
Route::get('/logout','LoginController@logouts')->name('logouts');
Route::get('/log','universalController@login');
Route::get('/reg','universalController@register');
Route::get('/registeragain','universalController@registeragain')->name('reg');
Route::post('/reg','universalController@create')->name('createuser');
Route::get('back','universalController@back')->name('backtoprevious');

// Route::get('markAsRead', function(){
//     Auth()->user()->unreadNotifications()->first()->update(['read_at'=>now()]);
//     return redirect()->route('properties');
// })->name('markRead');

//  Route::get('/otherInquire/{tid}/intend','BuyerController@othercontentnotiftobuyer');
 
//notification
//  Route::get('/backtointendpage/{tid}/show','BuyerController@notify');


//Routes for the seller
// add lot
// Route::get('/seller/addlotform','SellerController@addlot')->name('sell');
// Route::get('/seller/addlotform','SellerController@addlot');
// Route::get('/home','HomeController@notif');

//auto-complete try
 
// Route::get('display-search-queries','SellerController@searchData');


// Route::get('/index', function () {
//     return view('index');
// });

// Route::get('/sell','imageController@seller');
// Route::post('/store','imageController@save')->name('seller.store');
// Route::get('/landingpage',function(){
//     return view('landingpage');
// });
// Route::get('/sellLot',function(){
//     return view('seller/sellLot');
// });
//custom login

// Route::view('/login','members.login')->name('login');
// Route::post('/login','LoginController@authenticate');
// Route::get('/logout','LoginController@logout')->name('logout');
//view all notifcation page
// Route::get('/viewallnotif', function () { 
//     $id=Auth::id();
//     $email=Auth::user()->email;

//     $picture = Profile::where('user_fk',$id)->first();
//     $ownedLots=DB::table('lots')
//         ->join('confirmedowners','lots.lotId','=','confirmedowners.lotId')
//         ->where('confirmedowners.email',$email)
//         // ->select('lots.*', 'lots.lotNumber')
//         ->get()
//         ->toArray();
//     $allnotif = Notification::select('data')->get();
//     foreach($allnotif as $split){
//                 $post = $split['data'];
//         }
//     return view('viewallnotif')->with(['picture'=>$picture])->with(['ownedLot'=>$ownedLots])->with(['notifications'=>$allnotif]);
//     });

// Route::get('markAsRead', function(){
//     Auth()->user()->unreadNotifications()->update(['read_at'=>now()]);
//     return redirect()->route('properties');
// })->name('markRead');