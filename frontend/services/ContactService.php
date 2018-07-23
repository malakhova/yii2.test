<?php
/**
 * Created by PhpStorm.
 * User: elmira
 * Date: 11.07.18
 * Time: 15:12
 */

namespace frontend\services;

use frontend\forms\ContactForm;
use Yii;
use yii\mail\MailerInterface;

class ContactService
{
    private $adminEmail;
    private $mailer;

    public function __construct($adminEmail, MailerInterface $mailer)
    {
        $this->adminEmail = $adminEmail;
        $this->mailer = $mailer;
    }

    public function getSendStatus(ContactForm $form)
    {
        if ($this->sendEmail($form)) {
            Yii::$app->session->setFlash('success',
                'Thank you for contacting us. We will respond to you as soon as possible.');
        } else {
            Yii::$app->session->setFlash('error', 'There was an error sending your message.');
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param ContactForm $form
     * @return bool whether the email was sent
     */
    public function sendEmail(ContactForm $form /*, $email*/)
    {
        return $this->mailer->compose()
            ->setTo($this->adminEmail)
            ->setFrom([$form->email => $form->name])
            ->setSubject($form->subject)
            ->setTextBody($form->body)
            ->send();
    }
}