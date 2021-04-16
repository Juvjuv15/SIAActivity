<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Ramsey\Uuid\Uuid;
// use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Str;
use Validator;
use App\SellerLessorTransaction;
use App\Lot;
use App\User;
class sellerLessorController extends Controller
{   
    private $fileStorage='files/';
    private $originalName="";
    public function seller(){
        return view('seller.sellLot');
    }

    public function saveTransaction(Request $request){
      $userId=Auth::id();
       
      $lotNumber=$request->lotNumber;
      //check if the inputted lot number exist in the lot database
      $lotExist=Lot::where('lotNumber',$lotNumber)->first();
      if($lotExist){
      $sellerLessor = new SellerLessorTransaction;
      $count = $sellerLessor::get()->count()+1;
      $sellerLessor->SLT_id = "SLT00".$count;
      $sellerLessor->lotNumber=$lotExist->lotNumber;
      $sellerLessor->sellingType=$request->sellingType;
      $sellerLessor->price=$request->price;
      $sellerLessor->lotArea=$request->lotArea;
      $sellerLessor->contactNumber=$request->contactNumber;
      $sellerLessor->lotDescription=$request->lotDescription;
      $sellerLessor->save();
            return view('seller.sellLot');
     }
     else{
            echo "lot number is invalid";
     }
        
    }
    public function retrieve($fileName){
        $soldLeased = sellerLessorTransaction::get();
        // return view('listall',['listall'=>$sellers]);
        if(Storage::disk('public')->has($this->fileStorage.$fileName)){
            $url=Storage::url($this->fileStorage.$fileName);    
            $found=true;
        }
            else{
            $found=false;

            }
            return view('seller.dashboard',['soldLeased'=>$soldLeased],compact('found','url','fileName'));
}
}

