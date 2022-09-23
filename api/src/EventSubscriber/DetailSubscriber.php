<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Detail;
use App\Entity\Order;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class DetailSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setTotalOrder', EventPriorities::POST_RESPOND],
        ];
    }

    public function setTotalOrder(ViewEvent $event): void
    {
        $detail = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$detail instanceof Detail || Request::METHOD_POST !== $method) {
            return;
        }

        /** @var Order $order */
        $order = $detail->getOrderDelivery();

        $order->setTotal($order->getTotal() + $detail->getPrice());
    }
}
