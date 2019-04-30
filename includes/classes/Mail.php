<?php

    /**
        * Class: Mail
        * @function: __construct, send
     */

    class Mail {

        private $body = "";
        private $from = "";
        private $headers = "";
        private $replyTo = "";
        private $subject = "";
        private $to = "";

        public function __construct($body, $from, $replyTo, $subject, $to){
            $this->body = $body;
            $this->from = $from;
            $this->replyTo = $replyTo;
            $this->subject = $subject;
            $this->to = $to;
        }

        /**
         * Send mail
         */
        public function send(){

            if ($this->to){

                // Headers

                $this->headers = "MIME-Version: 1.0\r\n";
                $this->headers .= "Content-type: text/html; charset=utf-8\r\n";

                if ($this->from){
                    $this->headers .= "From: {$this->from} \r\nReply-To: {$this->replyTo}\r\n";
                };

                $this->headers .= "X-Mailer: PHP ". phpversion();

                // Send mail

                if (mail($this->to, $this->subject, $this->body, $this->headers)){
                    return "Mail successfully send";
                } else {
                    return "Mail couldn't be sended";
                };

            } else {
                return "Mail couldn't be sended. Please check params";
            };

        }

    }

?>