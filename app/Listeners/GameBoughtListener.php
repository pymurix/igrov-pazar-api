<?php

namespace App\Listeners;

use App\Events\OrderAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;

class GameBoughtListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(OrderAdded $event): void
    {
        $event->order->game()->first()->update(['is_bought' => true]);
    }

    public function viaConnection(): string
    {
        return 'sync';
    }

    public function viaQueue(): string
    {
        return 'listeners';
    }

    public function shouldQueue(OrderAdded $event): bool
    {
        return Config::get('app.env') === 'production';
    }
}
