<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Jobs\ProcessTransaction;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    /**
     * User balans operations: add/minus/hold/transfer
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operation' => 'required|max:20|min:3',
            'amount' => 'required|numeric',
            'u_id' => 'required|integer',
        ]);

        if (!$validator->fails()) {
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
     * Hold operations: (approve/decline)
     *
     * @return \Illuminate\Http\Response
     */
    public function hold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operation' => 'required|max:20|min:3',
            'hold_id' => 'required|integer',
            'u_id' => 'required|integer',
        ]);

        if (!$validator->fails()) {
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
