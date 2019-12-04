<?php

namespace App\Listeners;

use App\Events\GenericRedisEvent;
use App\Manager\RedisManager\RedisManager;

class GenericRedisListener
{
   
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(GenericRedisEvent $event)
    {
        $cache = RedisManager::Generic();
        $cache->delete($event->key);
    }
}
