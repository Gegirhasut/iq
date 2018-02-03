<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Jobs\ProcessTransaction;

class OperationController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->amount) && !empty($request->u_id)) {
            $transaction = new Transaction();
            $transaction->operation = $request->operation;
            $transaction->u_id = $request->u_id;
            $transaction->amount = $request->amount ?? 0;
            $transaction->to_user = $request->to_user ?? null;
            $transaction->save();

            ProcessTransaction::dispatch($transaction);
        }

        return redirect('/');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function hold(Request $request)
    {
        if (!empty($request->hold_id) && !empty($request->u_id)) {
            $transaction = new Transaction();
            $transaction->operation = $request->operation;
            $transaction->hold_id = $request->hold_id;
            $transaction->u_id = $request->u_id;
            $transaction->save();

            ProcessTransaction::dispatch($transaction);
        }

        return redirect('/');
    }
}
