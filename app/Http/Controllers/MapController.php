<?php

namespace App\Http\Controllers;

use App\Utilities\GoogleMaps;
use Illuminate\Http\Request;
use App\Lot;
use App\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use App\Panoimage;
use DB;
use Illuminate\Auth\AuthenticationException;
use App\Itemintent;
use App\Itemviewed;
use App\Itempurchase;
use App\Transactiontrail;
use App\Radiusscore;
use App\Pricescore;
use App\Criteria;
use App\Estabscore;
use App\Pricerange;
use App\Radiusrange;
class MapController extends Controller
{
    
    public function searchLots(Request $request){
        $id = Auth::id();
        $userLocation = Auth::user()->address;
        $longlat=$this->getLatLong($userLocation);
        $lat2=$longlat['latitude'];
        $lng2=$longlat['longitude'];
        $seller_id=$request->user_fk;
        $lat=$request->lat;
        $lng=$request->lng;
        $tid=$request->tid;
        $lotType=$request->lottype;
        $lotOwner=$request->lotOwner;
        $lotAddress=$request->lotAddress;
        $lotarea=$request->lotarea;
        $unitOfMeasure=$request->unitOfMeasure;
        $lotprice=$request->installmentprice;
        $sellingtype=$request->sellingtype;
        $lots = DB::table('lots')
        ->join('transactions', 'lots.lotId', '=' , 'transactions.lotId_fk')
        ->join('panoimages','panoimages.lotId_fk','=','lots.lotId')
        ->join('users','users.id','=','transactions.user_fk')
        ->where('transactions.user_fk', '!=', $id)
        ->whereAnd('lots.mortgage',"=","no")
        ->whereNull('transactions.sellingStatus')
        ->where('panoimages.filetype',"image")
        ->get();

            $pricepercent=0;
            $establishmentPercent=0;
            $prefpercent=0;
            $proxipercent=0;
            $criteria=DB::table('criterias')->get();

            foreach($criteria as $key => $value){
                if($value->cdesc=='pricereasonability')
                    $pricepercent=$value->cscore * .01;
                if($value->cdesc=='establishment')
                    $establishmentPercent=$value->cscore *.01;
                if($value->cdesc=='userpreference')
                    $prefpercent=$value->cscore * .01;
                if($value->cdesc=='proximity')
                    $proxipercent=$value->cscore * .01;
            }

            $test = [];
            $calculateDist = [];
            $getAllEstabScore = [];
            $getViews = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            $estabScore = 0;

            $views = [];
            $vcom=0;
            $vres=0;
            $vagri=0;
            $vbeach=0;
            $vforlease=0;
            $vforsale=0;
            $vmotor=0;
            $vcar=0;
            $vdumptruck=0;
            $vtenwheel=0;
            // -------------------------
            $intents = [];
            $ccom=0;
            $cres=0;
            $cagri=0;
            $cbeach=0;
            $cforlease=0;
            $cforsale=0;
            $cmotor=0;
            $ccar=0;
            $cdumptruck=0;
            $ctenwheel=0;
            // -------------------------
            $purchases = [];
            $pcom=0;
            $pres=0;
            $pagri=0;
            $pbeach=0;
            $pforlease=0;
            $pforsale=0;
            $pmotor=0;
            $pcar=0;
            $pdumptruck=0;
            $ptenwheel=0;
            // for the views purchased intent
            $lotpref = DB::table('lots')
            ->join('transactions', 'lots.lotId', '=' , 'transactions.lotId_fk')
            ->join('users','users.id','=','transactions.user_fk')
            ->where('transactions.user_fk', '!=', $id)
            ->whereAnd('lots.mortgage',"=","no")
            ->get();

        //    return $lotpref;
            foreach($lotpref as $key => $value){
                $tid=$value->tid;
                $lat1=$value->lat;
                $lng1=$value->lng;
                $lotId=$value->lotId;
                $cview = Transactiontrail::where('tid_fk',$tid)
                ->join('transactions', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
                ->where([['transactiontrails.actions',"view"],['transactiontrails.user_fk',$id]])
                ->where('transactions.lotId_fk',$lotId)
                ->get()->count();

                $cintent = Transactiontrail::where('tid_fk',$tid)
                ->join('transactions', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
                ->where([['transactiontrails.actions',"intent"],['transactiontrails.user_fk',$id]])
                ->where('transactions.lotId_fk',$lotId)
                ->get()->count();

                //count of intent
                $cpurchased = Transactiontrail::where('tid_fk',$tid)
                ->join('transactions', 'transactiontrails.tid_fk', '=' , 'transactions.tid')
                ->where([['transactiontrails.actions',"purchased"],['transactiontrails.user_fk',$id]])
                ->where('transactions.lotId_fk',$lotId)
                ->get()->count();


                if($cview>0){
                    $val = DB::table('transactions')
                    ->join('lots','lots.lotId','=','transactions.lotId_fk')
                    ->where('transactions.tid', $tid)
                    // ->select('rightOfWay')
                    ->get();
                    foreach($val as $key => $v){
                        if($v->lotType == "Commercial Lot"){
                            $vcom += $cview;
                            }
                        if($v->lotType == "Residential Lot"){
                            $vres+=$cview;
                           }
                        if($v->lotType == "Agricultural Lot"){
                            $vagri+=$cview;
                            }
                            
                        if($v->sellingType == "For Sale"){
                            $vforsale+=$cview;
                           }
                        if($v->sellingType == "For Lease")
                            {$vforlease+=$cview;
                            }
                            
                        $rightway=explode( " ",$v->rightOfWay);
                        for($i = 0; $i < count($rightway) ; $i++){  
                               
                                if($rightway[$i] == "TenWheelerTruck")
                                    {
                                        $vtenwheel += $cview;
                                    }
                                
                                if($rightway[$i] == "DumpTruck")
                                {
                                    $vdumptruck += $cview;
                                }
                                
                                if($rightway[$i] == "Car")
                                    {
                                        $vcar += $cview;
                                    }
                                
                                if($rightway[$i] == "Motorcycle")
                                    {
                                        $vmotor += $cview;
                                    }
                            }
                        }//endforeach
                       
                    }
                   
                
                    if($cintent>0){
                        $val = DB::table('transactions')
                            ->join('lots','lots.lotId','=','transactions.lotId_fk')
                            ->where('transactions.tid', $tid)
                            ->get();
                       
                        foreach($val as $key =>$v){
                            if($v->lotType == "Commercial Lot"){
                                $ccom += $cintent;
                                }
                            if($v->lotType == "Residential Lot"){
                                $cres+=$cintent;
                               }
                            if($v->lotType == "Agricultural Lot"){
                                $cagri+=$cintent;
                                }
                            if($v->sellingType == "For Sale"){
                                $cforsale+=$cintent;
                               }
                            if($v->sellingType == "For Lease")
                                {$cforlease+=$cintent;
                                }

                            $rightway=explode( " ",$v->rightOfWay);
                            
                            for($i = 0; $i < count($rightway) ; $i++){  
                                   
                                    if($rightway[$i] == "TenWheelerTruck")
                                        {$ctenwheel += $cintent;
                                        }
                                    
                                    if($rightway[$i] == "DumpTruck")
                                    { $cdumptruck += $cintent;
                                    }
                                    
                                    if($rightway[$i] == "Car")
                                        {$ccar += $cintent;
                                        }
                                    
                                    if($rightway[$i] == "Motorcycle")
                                        {$cmotor += $cintent;
                                    }
                                }
                            }
                            
                        }

                        if($cpurchased>0){
                            $val = DB::table('transactions')
                            ->join('lots','lots.lotId','=','transactions.lotId_fk')
                            ->where('transactions.tid', $tid)
                            ->get();
                            foreach($val as $key =>$v){
                                if($v->lotType == "Commercial Lot")
                                    {$pcom += $cpurchased;
                                    }
                                if($v->lotType == "Residential Lot")
                                   { $pres+=$cpurchased;
                                    }
                                if($v->lotType == "Agricultural Lot")
                                   { $pagri+=$cpurchased;
                                }
                                if($v->sellingType == "For Sale")
                                    {$pforsale+=$cpurchased;
                                    }
                                if($v->sellingType == "For Lease")
                                    {$pforlease+=$cpurchased;
                                    }
                                $rightway=explode( " ",$v->rightOfWay);
                                for($i = 0; $i < count($rightway) ; $i++){              
                                    if($rightway[$i] == "TenWheelerTruck"){
                                        $ptenwheel += $cpurchased;
                                    }
                                    if($rightway[$i] == "DumpTruck"){
                                        $pdumptruck += $cpurchased;
                                    }
                                    if($rightway[$i] == "Car"){
                                        $pcar += $cpurchased;
                                    }  
                                    if($rightway[$i] == "Motorcycle"){
                                        $pmotor += $cpurchased;
                                    }
                                }
                            }
                        }
                            // return $cpurchased;

                }//endforeach
                // return $purchases;
                //views
                array_push($views,$vcom);
                array_push($views,$vres);
                array_push($views,$vagri);
                array_push($views,$vforsale);
                array_push($views,$vforlease);
                array_push($views,$vmotor);
                array_push($views,$vcar);
                array_push($views,$vdumptruck);
                array_push($views,$vtenwheel);
                // array_push($tpurchases,$tid);
                array_push($intents,$ccom);
                array_push($intents,$cres);
                array_push($intents,$cagri);
                array_push($intents,$cforsale);
                array_push($intents,$cforlease);
                array_push($intents,$cmotor);
                array_push($intents,$ccar);
                array_push($intents,$cdumptruck);
                array_push($intents,$ctenwheel);
                // array_push($tpurchases,$tid);
                array_push($purchases,$pcom);
                array_push($purchases,$pres);
                array_push($purchases,$pagri);
                array_push($purchases,$pforsale);
                array_push($purchases,$pforlease);
                array_push($purchases,$pmotor);
                array_push($purchases,$pcar);
                array_push($purchases,$pdumptruck);
                array_push($purchases,$ptenwheel);
                // return $purchases;


            // ------------------------end for user pref
            foreach($lots as $key =>$value){
                $tid=$value->tid;
                $lat1=$value->lat;
                $lng1=$value->lng;
                $lotId=$value->lotId;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);             
                array_push($calculateDist,$dist);
                // array_push($calculateDist,$tid);

                //for the establishments
                 //get all establishments within 2 km in distance based on the lots location
                 $dist = 2;
                 // earth's radius in km = ~6371
                 $r = 6371;
                 // latitude boundaries
                 $maxlat2 = $lat1 + rad2deg($dist / $r);
                 $minlat2 = $lat1 - rad2deg($dist / $r);  
                 // longitude boundaries (longitude gets smaller when latitude increases)
                 $maxlng2 = $lng1 + rad2deg($dist / $r / cos(deg2rad($lat1)));
                 $minlng2 = $lng1 - rad2deg($dist / $r / cos(deg2rad($lat1)));

                $get_estab =DB::table('tertiarysectors')->where([['lat',">=",$minlat2],['lat',"<=",$maxlat2]])->where([['lng',">=",$minlng2],['lng',"<=",$maxlng2]])->get();
                $escore = 0;
                // $estabcount=count($get_estab);
                foreach($get_estab as $key => $results){
                    $x=DB::table('estabscores')->where('estab',$results->type)->first();
                    if($x){
                        $y= $x->escore;
                        $escore += $y;
                    }
                }
                array_push($getAllEstabScore,$escore);
                }
        
                $maxdistance=max($calculateDist);
                $maxestab=max($getAllEstabScore);
                // calculate percent scores
                $percentage = [];
                $rankthem = [];
                
                $avgintent= [];
                $avgpurchased=[];  
               
                $icom=0;
                $ires=0;
                $iagri=0;
                $ibeach=0;
                $iforlease=0;
                $iforsale=0;
                $ivmotor=0;
                $icar=0;
                $idumptruck=0;
                $itenwheel=0;
                
                $itemview =[];
                $itemintent = [];
                $itempurchase = [];
                
                // ------------------
                $iicom=0;
                $iires=0;
                $iiagri=0;
                $iibeach=0;
                $iiforlease=0;
                $iiforsale=0;
                $iivmotor=0;
                $iicar=0;
                $iidumptruck=0;
                $iitenwheel=0;
            foreach($lots as $key=>$value){
                $avgviews = [];

                $tviews =[];
                $tpurchases = []; 
                $tintents =[];
                $spviews = [];
                $spintents= [];
                $sppurchased=[];
                // --------------------
                $ivcom=0;
                $ivres=0;
                $ivagri=0;
                $ivbeach=0;
                $ivforlease=0;
                $ivforsale=0;
                $ivmotor=0;
                $ivcar=0;
                $ivdumptruck=0;
                $ivtenwheel=0;
                // ------------------
                $iicom=0;
                $iires=0;
                $iiagri=0;
                $iibeach=0;
                $iiforlease=0;
                $iiforsale=0;
                $iimotor=0;
                $iicar=0;
                $iidumptruck=0;
                $iitenwheel=0;
                // ------------------
                $ipcom=0;
                $ipres=0;
                $ipagri=0;
                $ipbeach=0;
                $ipforlease=0;
                $ipforsale=0;
                $ipmotor=0;
                $ipcar=0;
                $ipdumptruck=0;
                $iptenwheel=0;

                $scores = [];
                $tid=$value->tid;
                $lat1=$value->lat;
                $lng1=$value->lng;
                $near = 0;
                $fair = 0;
                $far = 0;
                // ------------------------------
                $radiusscore=Radiusscore::get();
                    foreach($radiusscore as $val){
                        if($val->rdesc == "near")
                            $near=$val->rscore;
                        if($val->rdesc == "fair")
                            $fair=$val->rscore;
                        if($val->rdesc == "far")
                            $far=$val->rscore;
                    }
                // ------------------------------
                $nearkm=0;
                $fairkm=0;
                $radiusrange=Radiusrange::get();
                foreach($radiusrange as $val){
                    if($val->radiusdesc == "near")
                        $nearkm=$val->radiuskm;
                    if($val->radiusdesc == "fair")
                        $fairkm=$val->radiuskm;
                }
                // ------------------------------
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                
                if($dist <= $nearkm )
                    $distanceScore=$this->calculateScoreF1($near,$dist,$maxdistance,$tid);
                if($dist > $nearkm && $dist <= $fairkm)
                    $distanceScore=$this->calculateScoreF1($fair,$dist,$maxdistance,$tid);
                if($dist > $fairkm )
                    $distanceScore=$this->calculateScoreF1($far,$dist,$maxdistance,$tid);

                $proximitypercent = $distanceScore * $proxipercent;//10% sa recommendation for proximity
                array_push($test,$tid);
                array_push($test,$dist);
                array_push($test,$distanceScore);
                //  array_push($test,$proximitypercent);
                //for the establishments
                 //get all establishments within 2 km in distance based on the lots location
                 $dist = 2;
                 // earth's radius in km = ~6371
                 $r = 6371;
                 // latitude boundaries
                 $maxlat2 = $lat1 + rad2deg($dist / $r);
                 $minlat2 = $lat1 - rad2deg($dist / $r);  
                 // longitude boundaries (longitude gets smaller when latitude increases)
                 $maxlng2 = $lng1 + rad2deg($dist / $r / cos(deg2rad($lat1)));
                 $minlng2 = $lng1 - rad2deg($dist / $r / cos(deg2rad($lat1)));

                 $get_estab =DB::table('tertiarysectors')->where([['lat',">=",$minlat2],['lat',"<=",$maxlat2]])->where([['lng',">=",$minlng2],['lng',"<=",$maxlng2]])->get();
                $escore = 0;
                    foreach($get_estab as $key => $results){
                        $x=DB::table('estabscores')->where('estab',$results->type)->first();
                        if($x){
                            $y= $x->escore;
                            $escore += $y;
                        }
                    }
                     
                     $estabScore=$this->calculateOtherScore($escore,$maxestab,$tid); //30% for the recommendation on establishments
                     $estabPercent=$estabScore *  $establishmentPercent;
// ------------------------------------------------------------------
                   
                //for the reasonable price
                //low price diff < -500
                //fair price diff -500 - 500
                //high > 500 and up
                $reasonableprice = 0;
                if($value->sellingType=="For Sale"){
                    $low = 0;
                    $fair = 0;
                    $high = 0;
                    $pricecriteria=DB::table('pricescores')->get();
                    foreach($pricecriteria as $key => $val){
                        if($val->pdesc=="low")
                            $low=$val->pscore;
                        if($val->pdesc=="fair")
                            $fair=$val->pscore;
                        if($val->pdesc=="high")
                            $high=$val->pscore;
                    }                    
                    $unitvalue=$value->lotUnitValue;
                    $area=$value->lotArea;
                    $adjustment=$value->lotAdjustment * 0.01;
                    $sellerprice=$value->lotPrice;
                    $uvseller=(($sellerprice)/($area * $adjustment));
                    $lowrange=0;
                    $fairrange=0;
                    $pricerange=DB::table('priceranges')->get();
                    foreach($pricerange as $key => $val){
                        if($val->rangedesc=="low")
                            $lowrange=$val->rangescore;
                        if($val->rangedesc=="fair")
                            $fairrange=$val->rangescore;
                    }
                    // $range = range( -500, 500 );
                    $unitpricediff = $uvseller - $unitvalue;
                    if($unitpricediff < $lowrange){
                        $rprice=$this->calculateScoreF1($low,$uvseller,$unitvalue,$tid);}
                    if($unitpricediff >= $lowrange && $unitpricediff <= $fairrange){
                        $rprice=$this->calculateScoreF1($fair,$uvseller,$unitvalue,$tid);}
                    if($unitpricediff > $fairrange){
                        $rprice=$this->calculateScoreF1($high,$uvseller,$unitvalue,$tid);
                    }
                    $reasonableprice = $rprice * $pricepercent;//40% sa recommendation for reasonable price
                }
                // ------------------------------ for lease
                if($value->sellingType=="For Lease"){
                    $low = 0;
                    $fair = 0;
                    $high = 0;
                    $pricecriteria=DB::table('pricescores')->get();
                    foreach($pricecriteria as $key => $val){
                        if($val->pdesc=="low")
                            $low=$val->pscore;
                        if($val->pdesc=="fair")
                            $fair=$val->pscore;
                        if($val->pdesc=="high")
                            $high=$val->pscore;
                    }                    
                    $unitvalue=$value->lotUnitValue;
                    $sellerprice=$value->lotPrice;
                    $lowrange=0;
                    $fairrange=0;
                    $pricerange=DB::table('priceranges')->get();
                    foreach($pricerange as $key => $val){
                        if($val->rangedesc=="low")
                            $lowrange=$val->rangescore;
                        if($val->rangedesc=="fair")
                            $fairrange=$val->rangescore;
                    }
                    // $range = range( -500, 500 );
                    $unitpricediff = $sellerprice - $unitvalue;
                    if($unitpricediff < $lowrange){
                        $rprice=$this->calculateScoreF1($low,$sellerprice,$unitvalue,$tid);}
                    if($unitpricediff >= $lowrange && $unitpricediff <= $fairrange){
                        $rprice=$this->calculateScoreF1($fair,$sellerprice,$unitvalue,$tid);}
                    if($unitpricediff > $fairrange){
                        $rprice=$this->calculateScoreF1($high,$sellerprice,$unitvalue,$tid);
                    }
                    $reasonableprice = $rprice * $pricepercent;//40% sa recommendation for reasonable price
                }
                              
                        //for per property views
                        if($value->lotType == "Commercial Lot"){
                            $ivcom += 1;
                            $iicom += 1;
                            $ipcom += 1;
                            }
                        if($value->lotType == "Residential Lot"){
                            $ivres+=1;
                            $iires += 1;
                            $ipres+=1;
                           }
                        if($value->lotType == "Agricultural Lot"){
                            $ivagri+=1;
                            $iiagri+=1;
                            $ipagri+=1;
                            }
                            
                        if($value->sellingType == "For Sale"){
                            $ivforsale+=1;
                            $iiforsale+=1;
                            $ipforsale+=1;
                           }
                        if($value->sellingType == "For Lease"){
                            $ivforlease+=1;
                            $iiforlease+=1;
                            $ipforlease+=1;
                            }

                        $rightOfWay=explode( " ",$value->rightOfWay);
                            $rscore = 0;
                            for($x = 0; $x < count($rightOfWay) ; $x++){              
                                if($rightOfWay[$x] == "TenWheelerTruck"){
                                    $ivtenwheel += 1;
                                    $iitenwheel += 1;
                                    $iptenwheel += 1;
                                }
                                if($rightOfWay[$x] == "DumpTruck"){
                                    $ivdumptruck += 1;
                                    $iidumptruck += 1;
                                    $ipdumptruck += 1;
                                }
                                if($rightOfWay[$x] == "Car"){
                                    $ivcar += 1;
                                    $iicar += 1;
                                    $ipcar += 1;
                                }  
                                if($rightOfWay[$x] == "Motorcycle"){
                                    $ivmotor +=1;
                                    $iimotor +=1;
                                    $ipmotor +=1;
                                }
                            }
                       
                        //item viewed
                        array_push($tviews,$ivcom);
                        array_push($tviews,$ivres);
                        array_push($tviews,$ivagri);
                        array_push($tviews,$ivforsale);
                        array_push($tviews,$ivforlease);
                        array_push($tviews,$ivmotor);
                        array_push($tviews,$ivcar);
                        array_push($tviews,$ivdumptruck);
                        array_push($tviews,$ivtenwheel);

                        array_push($spviews,$views);
                        array_push($spviews,$tviews);
                        //item intents
                        array_push($tintents,$iicom);
                        array_push($tintents,$iires);
                        array_push($tintents,$iiagri);
                        array_push($tintents,$iiforsale);
                        array_push($tintents,$iiforlease);
                        array_push($tintents,$iimotor);
                        array_push($tintents,$iicar);
                        array_push($tintents,$iidumptruck);
                        array_push($tintents,$iitenwheel);

                        array_push($spintents,$intents);
                        array_push($spintents,$tintents);
                        // return($spintents);

                       //item purchased
                        array_push($tpurchases,$ipcom);
                        array_push($tpurchases,$ipres);
                        array_push($tpurchases,$ipagri);
                        array_push($tpurchases,$ipforsale);
                        array_push($tpurchases,$ipforlease);
                        array_push($tpurchases,$ipmotor);
                        array_push($tpurchases,$ipcar);
                        array_push($tpurchases,$ipdumptruck);
                        array_push($tpurchases,$iptenwheel);
                        
                        array_push($sppurchased,$purchases);
                        array_push($sppurchased,$tpurchases);
                        // --------------------------
                        $viewscore=0;
                        $intentscore=0;
                        $purchasescore=0;
                        $pref=DB::table('userpreferences')->get();
                        foreach($pref as $key => $val){
                            if($val->udesc=="views")
                                $viewscore=$val->uscore * .01;
                            if($val->udesc=="intents")
                                $intentscore=$val->uscore * .01;
                            if($val->udesc=="purchases")
                                $purchasescore=$val->uscore * .01;
                        }
                        // ---------------------------
                        if(count($spviews)>0){
                            $vproduct = array();
                            for($index=0; $index < count($spviews[0]);$index++ ){
                                $vproduct[$index] = $spviews[0][$index] * $spviews[1][$index];
                            }
                            $vsum_product = array_sum($vproduct);
                            
                            $vsum_product = $vsum_product*$viewscore;
                            array_push($avgviews,$vsum_product);
                        }

                        if(count($spintents) > 0){
                            $iproduct = array();
                            for($index1=0; $index1 < count($spintents[0]);$index1++ ){
                                $iproduct[$index1] = $spintents[0][$index1] * $spintents[1][$index1];
                            }
                            $isum_product = array_sum($iproduct);
                            $isum_product = $isum_product*$intentscore;
                            array_push($avgviews,$isum_product);
                            }

                        
                        if(count($sppurchased) > 0){
                        $pproduct = array();
                        for($index2=0; $index2 < count($sppurchased[0]);$index2++ ){
                            $pproduct[$index2] = $sppurchased[0][$index2] * $sppurchased[1][$index2];
                        }
                        $psum_product = array_sum($pproduct);
                        $psum_product = $psum_product*$purchasescore;
                        array_push($avgviews,$psum_product);
                        }
                        
                    $preferences = array_sum($avgviews);
                    $preferencepercent = $preferences * $prefpercent;
                    
                    
                // $totalScorePercent=$proximitypercent+$rightOfWayPercent + $estabPercent + $reasonableprice;
                $totalScorePercent=($proximitypercent)+($preferencepercent) + ($estabPercent) + ($reasonableprice);
               
                    array_push($scores,$tid);
                    array_push($scores,$totalScorePercent);
                   
                    if($totalScorePercent > 0){
                         array_push($rankthem,$scores);
                     }        
            }
            // ------------------------------------------------------------
            $ranking = [];
            foreach($rankthem as $key => $row){
                $ranking[$key] = $row[1];
            }

            
            array_multisort($ranking, SORT_DESC, $rankthem);
            $ranking = array_splice($rankthem ,0,5);
            // return $ranking;
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][0];
            }
            // return $test;
            $recommend = array();
            foreach($lotids as $key => $pid){
                $lotresults=DB::table('lots')
                    ->join('transactions', 'lots.lotId', '=' , 'transactions.lotId_fk')
                    ->join('panoimages','panoimages.lotId_fk','=','lots.lotId')
                    ->join('users','users.id','=','transactions.user_fk')
                    ->where('transactions.user_fk', '!=', $id)
                    ->where('transactions.tid',$pid)
                    ->whereAnd('lots.mortgage',"=","no")
                    ->whereNull('transactions.sellingStatus')
                    ->where('panoimages.filetype',"image")
                    ->first();
                array_push($recommend,$lotresults);
            }
            return $recommend;
            

            // return $lotids;
            
        
    }

    
    public function filter(Request $request){
        $id = Auth::id();
        $array=[];
        $distance=0;
        $searchaddressVal=$request->searchaddressVal;
        $lotTypeVal=$request->lotTypeVal;
        $sellTypeVal=$request->sellTypeVal;
        $minPriceVal=$request->minPriceVal;
        $maxPriceVal=$request->maxPriceVal;

        $lat=$request->lat;
        $lng=$request->lng;
        $tid=$request->tid;
        $lotOwner=$request->lotOwner;
        $slotAddress=$request->slotAddress;
        $slotarea=$request->slotarea;
        $lotType=$request->lotType;
        $unitOfMeasure=$request->unitOfMeasure;
        $lotprice=$request->lotprice;
        $paymenttype=$request->paymenttype;
        $leasepaymenttype=$request->leasepaymenttype;     
        $sellingtype=$request->sellingtype;

        $lotResult = DB::table('lots')
        ->join('transactions', 'lots.lotId', '=' , 'transactions.lotId_fk')
        ->join('panoimages','panoimages.lotId_fk','=','lots.lotId')
        ->join('users','users.id','=','transactions.user_fk')
        ->where('transactions.user_fk', '!=', $id)
        ->whereAnd('lots.mortgage',"=","no")
        ->whereNull('transactions.sellingStatus')
        ->where('panoimages.filetype',"image");
        

        if($searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 10;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));

            $lotResult = $lotResult->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
                                    ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]]);
        }
        if($lotTypeVal!="")
            $lotResult = $lotResult->where('lots.lotType',$lotTypeVal);
        if($sellTypeVal!="")
            $lotResult = $lotResult->where('transactions.sellingType',$sellTypeVal);
        if($minPriceVal!="")
            $lotResult = $lotResult->where('transactions.lotPrice',">=",$minPriceVal);
        if($maxPriceVal!="")
            $lotResult = $lotResult->where('transactions.lotPrice',"<=",$maxPriceVal);

        $lotResult = $lotResult->get();
        
        return $lotResult;

       }//end function

//get the latlong of the inputted address
function getLatLong($address){
    if(!empty($address)){
    //Formatted address
    $formattedAddr = str_replace(' ','+',$address);
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

//calculate the distance between the inputted address and the lot result
function calculateDistance($lotLatitude1, $lotLongitude1, $Latitude2, $Longitude2,$id) {
    $degrees = rad2deg(acos((sin(deg2rad($lotLatitude1))*sin(deg2rad($Latitude2))) + (cos(deg2rad($lotLatitude1))*cos(deg2rad($Latitude2))*cos(deg2rad($lotLongitude1-$Longitude2)))));
    $dist = [];
    $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

    
    $distance=round($distance,2);
        return $distance;
}
    //calculate the distance percentage
    function calculateScore($firstval,$secondval,$tid) {
        
        $percentage = [];
        $score=(100-($firstval/$secondval)*100);

        return $score;

}

    //calculate the distance score
    function calculateScoreF1($percentscore,$firstvalue,$secondvalue,$tid) {
        
        $percentage = [];
        $score=($percentscore-($firstvalue/$secondvalue)*$percentscore);
        return $score;

    }
     //calculate the marketvalue percentage
     function calculateOtherScore($value,$secondvalue,$tid) {
        $score=(($value/$secondvalue)*100);
        return $score;

    }
}