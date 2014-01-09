<?php

class ResponderController extends Zend_Controller_Action
{

    public function init()
    {   
        $usuario = Zend_Auth::getInstance()->getIdentity();
        Zend_Layout::getMvcInstance()->assign('usuario', $usuario);

        if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                return $this->_helper->redirector->goToRoute( array('controller' => 'index'), null, true);
        }

    }

    public function indexAction()
    {
        // action body
        $bdRespostas = new Application_Model_DbTable_Respostas();
        $contagem = $bdRespostas->contRespostas();
        
        $this->view->contagem = $contagem;
    }
    
    public function mensagemAction()
    {
        $this->_helper->layout()->disableLayout();
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $dbMensagens = new Application_Model_DbTable_Mensagens();
        $dadosMensagem = $dbMensagens->listaMensagens($this->_getParam('id'));
        
        $formResposta = new Application_Form_Responder();
        
        $formResposta->populate($dadosMensagem);
        
        $this->view->formResposta = $formResposta;
    }


}

