<?php

namespace App\Mailer;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class MessageGenerator
{
    public function __construct(private Environment $twig, private ParameterBagInterface $parameterBag)
    {
    }

    public function getMessage(string $identifier, $parameters = [], $attach = []): Email
    {
        $template   = $this->twig->load('emails/' . $identifier . '.html.twig');
        $parameters = $this->twig->mergeGlobals($parameters);

        $subject  = $template->renderBlock('subject', $parameters);
        $bodyHtml = $template->render($parameters);
        $bodyText = strip_tags($template->renderBlock('body_txt', $parameters));

        $mail = (new Email())
            ->subject($subject)
            ->html($bodyHtml)
            ->text($bodyText)
        ;

        if ($attach) {
            $mail->attach(file_get_contents($attach['path']), $attach['name'], $attach['contentType'] ?? null);
        }

        return $mail;
    }
}
