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
        $dadosMensagens = $bdMensagens->listaMensagens();
        
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
        $this->view->teste = $dadosMensagens;
        $this->view->formMensagem = $formMensagem;
    }
    
    
    public function createAction(){
        $grupo = new Application_Model_DbTable_Grupo();
        $grupo->incluirGrupo($this->getAllParams());
        $this->_helper->redirector('index');
        
    }
   
   public function editAction(){
       $formGrupo = new Application_Form_Grupo('edit');
       $grupo = new Application_Model_DbTable_Grupo();
       $dadosGrupo = $grupo->pesquisarGrupo($this->_getParam(('id')));
       $formGrupo->populate($dadosGrupo);
       $this->view->formGrupo = $formGrupo;
   }
   
   public function updateAction()
   {
      $grupo = new Application_Model_DbTable_Grupo();
      $grupo->alterarGrupo($this->getAllParams());
      
      $this->_redirect('grupo/index');
   }

}

