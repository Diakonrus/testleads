<?php

class MailService extends CApplicationComponent
{

    public $smtp = [];
    public $host = 'localhost:25';
    public $sender = 'admin@leads.ru';
    public $name_sender = 'Администратор сайта Leads';
    public $pathViews = null;
    public $pathLayouts = null;

    public function send($data = [])
    {

        $mailer = Yii::createComponent('application.components.MailService.EMailer');

        $mailer->IsHTML(true);

        if (is_array($this->smtp)) {
            $mailer->IsSMTP();
        }

        $mailer->From = $this->sender;
        $mailer->FromName = $this->name_sender;
        $mailer->AddReplyTo($this->sender);
        $mailer->AddAddress($data['email']);
        $mailer->Subject = $data['subject'];
        $mailer->CharSet = 'UTF-8';
        $mailer->Body = $data['body'];

        if (isset($data['attach'])) {
            $mailer->AddAttachment($data['attach']['patch'], $data['attach']['name']);
        }

        $mailer->Send();
        return true;
    }
}

