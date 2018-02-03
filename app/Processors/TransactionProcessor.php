<?php
namespace App\Processors;

use App\Events\TransactionComplete;
use App\Holds;
use Illuminate\Support\Facades\DB;

class TransactionProcessor {
    public function process (\App\Transaction $transaction) {
        switch ($transaction->operation) {
            case 'add':
                return $this->add($transaction);

            case 'minus':
                return $this->minus($transaction);

            case 'transfer':
                return $this->transfer($transaction);

            case 'hold':
                return $this->hold($transaction);

            case 'approve':
                return $this->approve($transaction);

            case 'decline':
                return $this->decline($transaction);
        }
    }

    private function add (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            DB::table('users')
                ->where('id', $transaction->u_id)
                ->increment('amount', $transaction->amount);
        });

        event(new TransactionComplete("added {$transaction->amount} EUR for {$transaction->u_id}"));
    }

    private function minus (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            $user = DB::table('users')
                ->where('id', $transaction->u_id)
                ->first();

            if ($user->amount > $transaction->amount) {
                DB::table('users')
                    ->where('id', $transaction->u_id)
                    ->increment('amount', -$transaction->amount);

                event(new TransactionComplete("minus {$transaction->amount} EUR for {$transaction->u_id}"));
            }
        });
    }

    private function transfer (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            $user = DB::table('users')
                ->where('id', $transaction->u_id)
                ->first();

            if ($user->amount > $transaction->amount) {
                DB::table('users')
                    ->where('id', $transaction->u_id)
                    ->increment('amount', -$transaction->amount);

                DB::table('users')
                    ->where('id', $transaction->to_user)
                    ->increment('amount', $transaction->amount);

                event(new TransactionComplete("transfer {$transaction->amount} EUR from {$transaction->u_id} to {$transaction->to_user}"));
            }
        });
    }

    private function hold (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            $user = DB::table('users')
                ->where('id', $transaction->u_id)
                ->first();

            if ($user->amount >= $transaction->amount) {
                DB::table('users')
                    ->where('id', $transaction->u_id)
                    ->increment('amount', -$transaction->amount);

                $hold = new Holds();
                $hold->users_id = $transaction->u_id;
                $hold->amount = $transaction->amount;
                $hold->state = 0;
                $hold->save();

                event(new TransactionComplete("hold {$transaction->amount} EUR on {$transaction->u_id}"));
            }
        });
    }

    private function approve (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            $hold = DB::table('holds')
                ->where(['state' => 0, 'id' => $transaction->hold_id])
                ->first();

            if ($hold) {
                DB::table('holds')
                    ->where(['state' => 0, 'id' => $transaction->hold_id])
                    ->update(['state' => 1]);

                event(new TransactionComplete("approve hold {$hold->id} [{$hold->amount}] EUR on {$transaction->u_id}"));
            }
        });
    }

    private function decline (\App\Transaction $transaction) {
        DB::transaction(function () use ($transaction) {
            $hold = DB::table('holds')
                ->where(['state' => 0, 'id' => $transaction->hold_id])
                ->first();

            if ($hold) {
                DB::table('holds')
                    ->where(['state' => 0, 'id' => $transaction->hold_id])
                    ->update(['state' => 2]);

                DB::table('users')
                    ->where('id', $transaction->u_id)
                    ->increment('amount', $hold->amount);

                event(new TransactionComplete("decline hold {$hold->id} [{$hold->amount}] EUR on {$transaction->u_id}"));
            }
        });
    }
}