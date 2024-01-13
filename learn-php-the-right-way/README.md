# Send email in PHP

use [symfony/mailer](https://symfony.com/doc/current/mailer.html) to send email.

and use [MailHog](https://github.com/mailhog/MailHog) as local mail server receiving emails


Run automated scripts using cron

```cronexp
which crontab
crontab -e
# execute /path/to/email.php every 2 minutes
*/2 * * * * cd ~/git/w3schools-php/learn-php-the-right-way && php scripts/email.php
```
