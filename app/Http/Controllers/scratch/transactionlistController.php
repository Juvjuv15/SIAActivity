
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Transactionlist;
// use App\User;
// class transactionlistController extends Controller
// {
    // public function addTransaction(Request $request){
    //     $userRecord = User::findOrfail($request->id);
    //     $transaction = new Transactionlist;
    //     $countTransaction = $transaction::get()->count();
    //     $transaction->transactionId = "t00".$countTransaction;
    //     $transaction->user_fk=$userRecord;
    //     $transaction->transactionType=$request->transactionType;
    //     $transaction->save();
    //     $id=$transaction->transactionId;
    //     // return redirect(url('seller/sellLot/view'));

    //     if($transaction->transactionType="SELL" or $transaction->transactionType="CHARTER/MAGPAUPA")
    //     {
    //         return redirect(url('seller/sellLot/view'));
    //     }
    //     else{
    //         return redirect(url('landingpage/view'));
    //     }
    //     }

    // public function sellTransaction(Request $request){
    //     $userRecord = User::findOrfail($request->id);
    //     $transactionType="SELL";
    //     $transaction = new Transactionlist;
    //     $countTransaction = $transaction::get()->count();
    //     $transaction->transactionId = "t00".$countTransaction;
    //     $transaction->user_fk=$userRecord;
    //     $transaction->transactionType=$transactionType;
    //     $transaction->save();
    //     $id=$transaction->transactionId;
    //     return redirect(url('seller/sellLot/view'));

        
            // return redirect(url('seller/sellLot/view'));

    // }
    // public function buyTransaction(Request $request){
    //     $userRecord = User::findOrfail($request->id);
    //     $transactionType="BUY";
    //     $transaction = new Transactionlist;
    //     $countTransaction = $transaction::get()->count();
    //     $transaction->transactionId = "t00".$countTransaction;
    //     $transaction->user_fk=$userRecord;
    //     $transaction->transactionType=$transactionType;
    //     $transaction->save();
    //     $id=$transaction->transactionId;
        // return redirect(url('seller/sellLot/view'));

        
            // return redirect(url('seller/sellLot/view'));

            // return redirect(url('landingpage/view'));
//     }
// }
