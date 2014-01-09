<?php

class ResponderController extends Zend_Controller_Action
{

    public function init()
    {   
        $usuario = Zend_Auth::getInstance()->getIdentity();
        //$this->view->usuario = $usuario;
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);

        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                return $this->_helper->redirector->goToRoute( array('controller' => 'index'), null, true);
            //$this->_redirect('/');
        }

    }

    public function indexAction()
    {
        // action body
        $bdRespostas = new Application_Model_DbTable_Respostas();
        $contagem = $bdRespostas->contRespostas();
        
        $this->view->contagem = $contagem;
    }


}

