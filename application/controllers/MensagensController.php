<?php

class MensagensController extends Zend_Controller_Action
{

    public function init()
    {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        //$this->view->usuario = $usuario;
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);
    }

    public function indexAction()
    {
        $bdMensagens = new Application_Model_DbTable_Mensagens();
        
        $dadosMensagens = $bdMensagens->pesquisarMensagens();
        
        $this->view->dadosMensagens = $dadosMensagens;
    }

}

