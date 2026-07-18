<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use App\Mail\OrderPlacedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class OrderPlacedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderEvent $event): void
    {
        try {
            //code...
            $order = $event->order;
            Mail::to($order->user->email)->send(new OrderPlacedMail($order));
        } catch (\Throwable $e) {
            //throw $th;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }
    }
}
