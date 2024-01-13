<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\{Get, Post};
use App\Models\Email;
use App\View;
use Symfony\Component\Mime\Address;

class UserController
{

    #[Get('/users/create')]
    public function create(): View
    {
        return View::make('users/register');
    }

    #[Post('/users')]
    public function register(): void
    {
        $name      = $_POST['name'];
        $address   = $_POST['email'];
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
                alt="email"
            />
        </div>
        HTMLBody;

        $to      = new Address($address);
        $from    = new Address('support@example.com', 'Support');
        $subject = 'Welcome';

        $emailModel = new Email();
        $emailModel->queue(
            to: $to,
            from: $from,
            subject: $subject,
            html: $html,
            text: $text
        );
    }

}
