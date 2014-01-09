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
        $dadosMensagens = $bdMensagens->listaMensagens(null, null);
        
        $this->view->dadosMensagens = $dadosMensagens;
    }
    
    public function newAction()
    {
        $formGrupo = new Application_Form_Grupo('new');
        $this->view->formGrupo = $formGrupo;
    }
    
    public function showAction(){
        
        $formMensagem = new Application_Form_Mensagens('show');
        $bdMensagens = new Application_Model_DbTable_Mensagens();
        
        $dadosMensagens = $bdMensagens->listaMensagens( $this->_getParam('id') );
        
        $formMensagem->populate($dadosMensagens);
        
        $this->view->formMensagem = $formMensagem;
    }
    
    
    public function createAction(){
        $grupo = new Application_Model_DbTable_Grupo();
        $grupo->incluirGrupo($this->getAllParams());
        $this->_helper->redirector('index');
        
    }
   
   public function editAction(){
              
       $formMensagem = new Application_Form_Mensagens('edit');
       $bdMensagens = new Application_Model_DbTable_Mensagens();
        
       $dadosMensagens = $bdMensagens->listaMensagens( $this->_getParam('id') );
        
       $formMensagem->populate($dadosMensagens);
        
       $this->view->formMensagem = $formMensagem;
   }
   
   public function updateAction()
   {
       $usuario = Zend_Auth::getInstance()->getIdentity();
       
       $dbMensagens = new Application_Model_DbTable_Mensagens();
       
       $dbMensagens->alterarMensagem($this->_getAllParams(), $usuario->idUsr);
       $this->_redirect('mensagens/index');
   }
   
   public function responderAction()
   {
       $this->_helper->layout()->disableLayout();
       
       $usuario = Zend_Auth::getInstance()->getIdentity();
       
       $dbMensagens = new Application_Model_DbTable_Mensagens();
       
       $dadosMensagem = $dbMensagens->listaMensagens($this->_getParam('id'));
       
       $this->view->dados = $dadosMensagem;
   }

}

