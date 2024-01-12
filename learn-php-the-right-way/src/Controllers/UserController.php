<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\{Get, Post};
use App\View;
use Symfony\Component\Mailer\{Mailer, Transport};
use Symfony\Component\Mime\Email;

class UserController
{
    public function __construct()
    {
    }

    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register');
    }

    #[Post('/users')]
    public function register(): void
    {
        $name      = $_POST['name'];
        $emailAddress     = $_POST['email'];
        $firstName = explode(' ', $name)[0];

        $text = <<<Body
        Hello $firstName,
        Thank you for signing up!
        Body;

        $html = <<<HTMLBody
        <div>
            <h1 style="color: pink;">Welcome</h1>
            Hello <strong>$firstName</strong>,
            <br />
            Thank you for signing up!
            <br />
            <br />
            <img 
                src="https://fastly.picsum.photos/id/408/300/300.jpg?hmac=7VHQsDQRHCnsHbC3XZGBMHGIT-ls8f1QRzYcU3Evs68" 
                width="300" 
                height="300" 
                style="border-radius: 20px;"
            />
        </div>
        HTMLBody;

        $dsn = 'smtp://localhost:11025';

        $mailer = new Mailer(Transport::fromDsn($dsn));

        $email = (new Email())
          ->from('support@example.com')
          ->to($emailAddress)
          ->subject('Welcome!')
          ->attach('Hello World!', 'welcome.txt')
          ->text($text)
          ->html($html);

        $mailer->send($email);

        echo 'email sent successfully, please check your email';
    }
}
