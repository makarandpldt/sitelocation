<?php

declare(strict_types=1);

namespace Drupal\sitelocation\EventSubscriber;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Cache\Cache;

class SetExpiresSubscriber implements EventSubscriberInterface
{
    public function onResponse(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        if ($event->isMasterRequest()) {
            $request_time = $request->server->get('REQUEST_TIME');
            $expires_time = (new \Datetime())->setTimestamp($request_time + 60);
            $response->setExpires($expires_time);

            // Clear cache tags of our block.
            Cache::invalidateTags(['sitelocation']);
        }
    }

    public static function getSubscribedEvents()
    {
        $events[KernelEvents::RESPONSE][] = ['onResponse'];
        return $events;
    }
}
