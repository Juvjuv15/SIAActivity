<?php

namespace App\Http\Controllers;

use App\Utilities\GoogleMaps;
use Illuminate\Http\Request;
use App\Lot;
use App\sellLeasedTransaction;
use Illuminate\Database\Eloquent\Collection;
use DB;
class MapController extends Controller
{
    
    public function searchLots(Request $request){
            
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
        $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereNull('sellLeasedTransactions.sellingstatus')
            ->where('lots.mortgage',"=","no")
            ->get();

        return $lots;
        
    }

    
    public function filter(Request $request){
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
        $slotType=$request->slottype;
        $unitOfMeasure=$request->unitOfMeasure;
        $lotprice=$request->lotprice;
        $paymenttype=$request->paymenttype;
        $leasepaymenttype=$request->leasepaymenttype;     
        $sellingtype=$request->sellingtype;

        if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));

            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where('lots.mortgage',"=","no")
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            $estabScore = 0;

            //get maximum distance, market value and right of ways and establishment
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);
                
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                
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
                //  return $get_estab;
                $escore = 0;
                $estabcount=count($get_estab);
                     foreach($get_estab as $key => $results){

                         if($results->type == "school"){
                             $escore += 100;
                         }
                         if($results->type == "convenience_store"){
                             $escore += 60;
                         }
                         if($results->type == "department_store"){
                             $escore += 75;
                         }
                         if($results->type == "home_goods_store"){
                             $escore += 70;
                         }
                         if($results->type == "pharmacy"){
                             $escore += 70;
                         }
                         if($results->type == "fire_station"){
                             $escore += 50;
                         }
                         if($results->type == "police"){
                             $escore += 50;
                         }
                         if($results->type == "hospital"){
                             $escore += 100;
                         }

                     }
                     $final_escore = $escore/ $estabcount;
                     array_push($getAllEstabScore,$final_escore);
                }
                
                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $maxEstab=max($getAllEstabScore);
                
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];
                $estab = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }

                //for the establishments
                 //get all establishments within 2 km in distance based on the lots location
                 $d = 2;
                 // earth's radius in km = ~6371
                 $r = 6371;
                 // latitude boundaries
                 $maxlat2 = $lat1 + rad2deg($d / $r);
                 $minlat2 = $lat1 - rad2deg($d / $r);  
                 // longitude boundaries (longitude gets smaller when latitude increases)
                 $maxlng2 = $lng1 + rad2deg($d / $r / cos(deg2rad($lat1)));
                 $minlng2 = $lng1 - rad2deg($d / $r / cos(deg2rad($lat1)));

                 $get_estab =DB::table('tertiarysectors')->where([['lat',">=",$minlat2],['lat',"<=",$maxlat2]])->where([['lng',">=",$minlng2],['lng',"<=",$maxlng2]])->get();
                //  return $get_estab;
                $escore = 0;
                $estabcount=count($get_estab);
                foreach($get_estab as $key => $results){

                    if($results->type == "school"){
                        $escore += 100;
                    }
                    if($results->type == "convenience_store"){
                        $escore += 60;
                    }
                    if($results->type == "department_store"){
                        $escore += 75;
                    }
                    if($results->type == "home_goods_store"){
                        $escore += 70;
                    }
                    if($results->type == "pharmacy"){
                        $escore += 70;
                    }
                    if($results->type == "fire_station"){
                        $escore += 50;
                    }
                    if($results->type == "police"){
                        $escore += 50;
                    }
                    if($results->type == "hospital"){
                        $escore += 100;
                    }

                }
                $final_escore = $escore/ $estabcount;
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);
                $estabScore=$this->calculateOtherPercentage($final_escore,$maxEstab,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
                array_push($totalScore,$estabScore);
               
                $tentative_score = $distanceScore + $marketValueScore + $rightOfWayScore + $estabScore;
                $finalScore = $tentative_score / 4;
                array_push($score,$finalScore);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();
            
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            // return $ranking;
            $lotids = [];
            for ($i=0; $i<count( $ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
        //    return $lotids;
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }

        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));

            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));

            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
           
            $calculateDist = [];
            $score=[];
            // $base= new Collection();
            // $result= new Collection();

            //get maximum distance
            foreach($lots as $key =>$value){
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);
                // $base->push($dist);
                // $base->push([$value,$i]);
                }

                $maxDistance=max($calculateDist);
                $dist1 = [];
            //get score percentage
            foreach($lots as $key =>$value){

                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);

                $i=$this->calculatePercentage($dist,$maxDistance,$tid);

                array_push($dist1,$i);

            }
            // return $dist1;
            $d = array();
            foreach ($dist1 as $key => $row)
            {
                $d[$key] = $row[0];
            }
            array_multisort($d, SORT_DESC, $dist1);

            $d = array_splice($dist1,0,2);

            //get the lot ids
            $lotids = [];
            for ($i=0; $i< 2 ; $i++) { 
                $lotids[$i] = $d[$i][1];
            }

            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where('sellLeasedTransactions.slottype',$lotTypeVal)
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $distAndLots = [];
            array_push($distAndLots,$lots);
        
            return $distAndLots;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal!=""  && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();
           
            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', "=" , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', "=" , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal==""  && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }

        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['sellLeasedTransactions.slottype',$lotTypeVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal=="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal==""){
          $lots = DB::table('sellLeasedTransactions')
          ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
          ->where('lots.mortgage',"=","no")
          ->where('sellLeasedTransactions.sellingtype',$sellTypeVal)
          ->where('sellLeasedTransactions.slottype',$lotTypeVal)
          ->where('sellLeasedTransactions.lotprice',"<=",$maxPriceVal)
          ->whereNull('sellLeasedTransactions.sellingstatus')
        //   ->orderBy('created_at', 'desc')
          ->get();

          $getAllMarketValue = [];
          $getAllRightOfWaysScore = [];
          $getAllEstabScore = [];
          $marketValueScore = 0;
          $rightOfWayScore = 0;
          
          //get maximum market value and right of ways
          foreach($lots as $key =>$value){
              
              $tid=$value->tid;
              $marketValue=$value->lotMarketValue;
              array_push($getAllMarketValue,$marketValue);

              $TenWheelerTruck=10;
              $DumpTruck=8;
              $Car=6;
              $Motorcycle=4;
              $tId=$value->tid;
              $rightofway=$value->rightofway;
              $rightofways=explode( " ",$rightofway);
              $rscore = 0;
              for($i = 0; $i < count($rightofways) ; $i++){
                 
                  if($rightofways[$i] == "TenWheelerTruck"){
                      $rscore += $TenWheelerTruck;
                  }
                  if($rightofways[$i] == "Car"){
                      $rscore += $Car;
                  }
                  if($rightofways[$i] == "DumpTruck"){
                      $rscore += $DumpTruck;
                  }
                  if($rightofways[$i] == "Motorcycle"){
                      $rscore += $Motorcycle;
                  }
              }
              array_push($getAllRightOfWaysScore,$rscore);
              }

              $maxMarketValue=max($getAllMarketValue);
              $maxRightOfWay=max($getAllRightOfWaysScore);
              $marketVal = [];
              $rightOfWay = [];

          //get score percentage
          $totalScore = [];
          $rank = [];
          foreach($lots as $key =>$value){
              $score=[];
              $tid=$value->tid;
              $marketValue=$value->lotMarketValue;
              $rightofway=$value->rightofway;
              $rightofways=explode( " ",$rightofway);
              $TenWheelerTruck=10;
              $DumpTruck=8;
              $Car=6;
              $Motorcycle=4;

              $rscore = 0;
              for($i = 0; $i < count($rightofways) ; $i++){
                 
                  if($rightofways[$i] == "TenWheelerTruck"){
                      $rscore += $TenWheelerTruck;
                  }
                  if($rightofways[$i] == "Car"){
                      $rscore += $Car;
                  }
                  if($rightofways[$i] == "DumpTruck"){
                      $rscore += $DumpTruck;
                  }
                  if($rightofways[$i] == "Motorcycle"){
                      $rscore += $Motorcycle;
                  }
              }
              
              $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
              $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

              array_push($totalScore,$marketValueScore);
              array_push($totalScore,$rightOfWayScore);
             
              $i = $marketValueScore + $rightOfWayScore;

              array_push($score,$i);
              array_push($score,$tid);
              array_push($rank,$score);
          }
         
          $ranking = array();
          foreach($rank as $key => $row){
              $ranking[$key] = $row[0];
          }
          array_multisort($ranking, SORT_DESC, $rank);
          $ranking = array_splice($rank ,0,10);
          $lotids = [];
          for ($i=0; $i<count($ranking)  ; $i++) { 
              $lotids[$i] = $ranking[$i][1];
          }
         
          $lotResult = DB::table('sellLeasedTransactions')
          ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
          ->whereIn('sellLeasedTransactions.tid',$lotids)
          ->whereAnd('lots.mortgage',"=","no")
          ->whereNull('sellLeasedTransactions.sellingstatus')
        //   ->orderBy('created_at', 'desc')
          ->get();

          return $lotResult;
      }
      else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal=="" && $searchaddressVal!=""){
        $longlat=$this->getLatLong($searchaddressVal);
        $lat2=$longlat['latitude'];
        $lng2=$longlat['longitude'];
        //get all lots within 5 km in distance based od the searched location
        $distance = 5;

        // earth's radius in km = ~6371
        $radius = 6371;

        // latitude boundaries
        $maxlat = $lat2 + rad2deg($distance / $radius);
        $minlat = $lat2 - rad2deg($distance / $radius);
        
        // longitude boundaries (longitude gets smaller when latitude increases)
        $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
        $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
        
        $lots = DB::table('sellLeasedTransactions')
        ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
        ->where('lots.mortgage',"=","no")
        ->where('sellLeasedTransactions.sellingtype',$sellTypeVal)
        ->where('sellLeasedTransactions.slottype',$lotTypeVal)
        ->where('sellLeasedTransactions.lotprice',"<=",$maxPriceVal)
        ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
        ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
        ->whereNull('sellLeasedTransactions.sellingstatus')
        // ->orderBy('created_at', 'desc')
        ->get();

        $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
    }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal=="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal=="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal==""){
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else if($lotTypeVal!="" && $sellTypeVal!="" && $maxPriceVal!="" && $minPriceVal!="" && $searchaddressVal!=""){
            $longlat=$this->getLatLong($searchaddressVal);
            $lat2=$longlat['latitude'];
            $lng2=$longlat['longitude'];
            //get all lots within 5 km in distance based od the searched location
            $distance = 5;

            // earth's radius in km = ~6371
            $radius = 6371;

            // latitude boundaries
            $maxlat = $lat2 + rad2deg($distance / $radius);
            $minlat = $lat2 - rad2deg($distance / $radius);
            
            // longitude boundaries (longitude gets smaller when latitude increases)
            $maxlng = $lng2 + rad2deg($distance / $radius / cos(deg2rad($lat)));
            $minlng = $lng2 - rad2deg($distance / $radius / cos(deg2rad($lat)));
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where([['sellLeasedTransactions.sellingtype',$sellTypeVal],['sellLeasedTransactions.slottype',$lotTypeVal],['sellLeasedTransactions.lotprice',">=",$minPriceVal],['sellLeasedTransactions.lotprice',"<=",$maxPriceVal],['lots.mortgage',"=","no"]])
            ->where([['lots.lat',">=",$minlat],['lots.lat',"<=",$maxlat]])
            ->where([['lots.lng',">=",$minlng],['lots.lng',"<=",$maxlng]])
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $calculateDist = [];
            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $distanceScore = 0;
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum distance, market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $lat1=$value->lat;
                $lng1=$value->lng;
                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                array_push($calculateDist,$dist);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxDistance=max($calculateDist);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $dist1 = [];
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                // $totalScore = [];
                $lat1=$value->lat;
                $lng1=$value->lng;
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                

                $dist = $this->calculateDistance($lat1,$lng1,$lat2,$lng2,$tid);
                $distanceScore=$this->calculatePercentage($dist,$maxDistance,$tid);
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$distanceScore); 
                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $distanceScore + $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;
        }
        else {
            
            $lots = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->where('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            $getAllMarketValue = [];
            $getAllRightOfWaysScore = [];
            $getAllEstabScore = [];
            $marketValueScore = 0;
            $rightOfWayScore = 0;
            
           
           

            //get maximum market value and right of ways
            foreach($lots as $key =>$value){
                
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                array_push($getAllMarketValue,$marketValue);

                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;
                $tId=$value->tid;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                array_push($getAllRightOfWaysScore,$rscore);
                }

                $maxMarketValue=max($getAllMarketValue);
                $maxRightOfWay=max($getAllRightOfWaysScore);
                $marketVal = [];
                $rightOfWay = [];

            //get score percentage
            $totalScore = [];
            $rank = [];
            foreach($lots as $key =>$value){
                $score=[];
                $tid=$value->tid;
                $marketValue=$value->lotMarketValue;
                $rightofway=$value->rightofway;
                $rightofways=explode( " ",$rightofway);
                $TenWheelerTruck=10;
                $DumpTruck=8;
                $Car=6;
                $Motorcycle=4;

                $rscore = 0;
                for($i = 0; $i < count($rightofways) ; $i++){
                   
                    if($rightofways[$i] == "TenWheelerTruck"){
                        $rscore += $TenWheelerTruck;
                    }
                    if($rightofways[$i] == "Car"){
                        $rscore += $Car;
                    }
                    if($rightofways[$i] == "DumpTruck"){
                        $rscore += $DumpTruck;
                    }
                    if($rightofways[$i] == "Motorcycle"){
                        $rscore += $Motorcycle;
                    }
                }
                
                $marketValueScore=$this->calculateOtherPercentage($marketValue,$maxMarketValue,$tid);
                $rightOfWayScore=$this->calculateOtherPercentage($rscore,$maxRightOfWay,$tid);

                array_push($totalScore,$marketValueScore);
                array_push($totalScore,$rightOfWayScore);
               
                $i = $marketValueScore + $rightOfWayScore;

                array_push($score,$i);
                array_push($score,$tid);
                array_push($rank,$score);
            }
           
            $ranking = array();
            foreach($rank as $key => $row){
                $ranking[$key] = $row[0];
            }
            array_multisort($ranking, SORT_DESC, $rank);
            $ranking = array_splice($rank ,0,10);
            $lotids = [];
            for ($i=0; $i<count($ranking)  ; $i++) { 
                $lotids[$i] = $ranking[$i][1];
            }
           
            $lotResult = DB::table('sellLeasedTransactions')
            ->join('lots', 'lots.lotNumber', '=' , 'sellLeasedTransactions.slotnumber')
            ->whereIn('sellLeasedTransactions.tid',$lotids)
            ->whereAnd('lots.mortgage',"=","no")
            ->whereNull('sellLeasedTransactions.sellingstatus')
            // ->orderBy('created_at', 'desc')
            ->get();

            return $lotResult;

            }
}//end function

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

//calculate the distance between the inputted address and the lot result
function calculateDistance($lotLatitude1, $lotLongitude1, $searchLatitude2, $searchLongitude2,$id) {
    $degrees = rad2deg(acos((sin(deg2rad($lotLatitude1))*sin(deg2rad($searchLatitude2))) + (cos(deg2rad($lotLatitude1))*cos(deg2rad($searchLatitude2))*cos(deg2rad($lotLongitude1-$searchLongitude2)))));

    $distance = $degrees * 111.13384; // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)

    
    $distance=round($distance,2);

        return $distance;
    }
    //calculate the distance percentage
    function calculatePercentage($value,$Greatestvalue,$id) {
        
        $percentage = [];
        $i=(100-($value/$Greatestvalue)*100);
        array_push($percentage,$i);
        // array_push($percentage,$id);

        return $i;

    }
     //calculate the marketvalue percentage
     function calculateOtherPercentage($value,$Greatestvalue,$id) {
        
        $percentage = [];
        $i=(($value/$Greatestvalue)*100);
        array_push($percentage,$i);
        // array_push($percentage,$id);

        return $i;

    }
}