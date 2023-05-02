<?php

namespace App\Controller;

use App\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        $subscribedServices = parent::getSubscribedServices();

        $subscribedServices['app.mailer'] = Mailer::class;

        return $subscribedServices;
    }

    protected function getMailer(): Mailer
    {
        return $this->container->get('app.mailer');
    }
}
