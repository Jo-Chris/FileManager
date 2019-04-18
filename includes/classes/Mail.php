<?php

    /**
        * Class: Mail
        * @function: __construct, send
     */

    class Mail {

        private $attachment = null;
        private $body = "";
        private $error = "";
        private $from = "";
        private $headers = null;
        private $subject = "";
        private $to = "";

        public function __construct($attachment, $body, $from, $subject, $to){
            $this->attachment = $attachment;
            $this->body = $body;
            $this->from = $from;
            $this->subject = $subject;
            $this->to = $to;
        }

        /**
         * Send mail
         */
        public function send(){

            if ($this->to) {

                // Set boundary
                $boundary = md5(rand(5000, 500000000) . date("r"));

                // Attachment

                if ($this->attachment){
                    if (file_exists($this->attachment)){
                        $this->attachment = chunk_split(base64_encode(file_get_contents($this->attachment)));
                    } else {
                        $this->error = "Failed to send mail, attachment file \"{$this->attachment}\" not found";
                        return false;
                    };
                };

                // Headers

                if ($this->from){
                    $this->headers = "From: {$this->from} \r\nReply-To: {$this->from}";
                };

                if ($this->attachment){
                    $this->headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8\r\nboundary=\"_1_{$boundary}\"";
                };

                // Body

                if (!$this->body){
                    $this->error = "Failed to send mail, no message";
                };

                // Send mail

                if (mail($this->to, $this->subject, $this->body, $this->headers)){
                    return true;
                } else {
                    $this->error = "Failed to send mail (check SMTP settings)";
                    return false;
                };

            } else {
                $this->error = "Failed to send mail, invalid params";
                return false;
            };

        }

    }

?>