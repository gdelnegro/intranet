<?php

class Application_Model_Respostas
{
    
    private $transport;

    public function __construct(){
        $config = array('auth' => 'login',
                'username' => 'myusername',
                'password' => 'password');
 
        $transport = new Zend_Mail_Transport_Smtp('mail.server.com', $config);
        
        $this->transport = $transport;
    }

    
    public function enviarEmail(array $request) {
        
        $mail = new Zend_Mail();
        $mail->setBodyText($request['resposta']);
        $mail->setFrom('sender@test.com', 'Some Sender');
        $mail->addTo($request['email'], $request['nome']);
        $mail->setSubject('TestSubject');
        //$mail->send($this->transport);
        
        $sent = true;
        
        try {
          $mail->send($this->transport);  
        } catch (Exception $exc) {
            $msgErro = $exc->getMessage();
            $sent = false;
        }
        
        if( $sent ){
            return true;
        }else {
            return $msgErro;
        }
        
    }


}

