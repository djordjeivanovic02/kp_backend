<?php
namespace Core;

class Mailer {
    public function sendWelcomeEmail(string $email): void {
        mail($email, 'Dobro došli', 'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...', 'From: adm@kupujemprodajem.com');
    }
}