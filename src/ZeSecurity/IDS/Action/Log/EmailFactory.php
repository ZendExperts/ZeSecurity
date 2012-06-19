<?php
namespace ZeSecurity\IDS\Action\Log;

use Zend\Log\Writer\Mail;

class EmailFactory implements FactoryInterface
{
    /**
     * Factory method for creating an email log writer based on the configuration array
     * @param array $config
     * @return \Zend\Log\Writer\Mail
     */
    public function create($config)
    {
        $to = $config['to'];
        $from = $config['from'];
        $subject = $config['subject'];

        //create the message object that should be sent
        $message = new \Zend\Mail\Message();

        //populate it with data based on the config
        $message->setFrom($from);
        $message->setSubject($subject);
        if (is_string($to)) {
            $to = array($to);
        }
        foreach ($to as $email) {
            $message->addTo($email);
        }

        //create the log writer
        $writer = new Mail($message);

        //set up a formatter if present
        if (isset($config['formatter'])) {
            $formatter = new $config['formatter']();
            $writer->setFormatter($formatter);
        }
        return $writer;
    }

}