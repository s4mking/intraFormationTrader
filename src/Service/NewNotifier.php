<?php

namespace App\Service;

use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

class NewNotifier implements NotifierInterface
{

    public function send(Notification $notification, RecipientInterface ...$recipients): void
    {

    }


}
