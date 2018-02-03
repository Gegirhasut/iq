<?php

namespace App\Listeners;

use App\Events\TransactionComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransactionNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TransactionComplete  $event
     * @return void
     */
    public function handle(TransactionComplete $event)
    {
        echo $event->message . PHP_EOL;
    }
}
