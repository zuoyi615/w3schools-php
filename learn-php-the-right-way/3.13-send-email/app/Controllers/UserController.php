<?php
    
    declare(strict_types=1);
    
    namespace SendEmail\Controllers;
    
    use SendEmail\Attributes\Get;
    use SendEmail\Attributes\Post;
    use SendEmail\View;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;
    
    class UserController
    {
        
        public function __construct(protected MailerInterface $mailer) {}
        
        #[Get('/users/create')]
        public function create(): View
        {
            return View::make('users/register');
        }
        
        /**
         * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
         */
        #[Post('/users')]
        public function register(): void
        {
            $name      = $_POST['name'];
            $email     = $_POST['email'];
            $firstName = explode(' ', $name)[0];
            
            $text = <<<Body
Hello $firstName,

Thank you for signing up!
Body;
            
            $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Welcome</h1>
<div style="text-align: center;">
Hello $firstName,
<br /><br />
Thank you for signing up!
</div>
HTMLBody;
            
            $email = (new Email())
                ->from('support@example.com')
                ->to($email)
                ->subject('Welcome!')
                ->attach('Hello World!', 'welcome.txt')
                ->text($text)
                ->html($html);
            
            $this->mailer->send($email);
            
            echo $html;
        }
        
    }
