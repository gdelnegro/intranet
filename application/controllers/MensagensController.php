<?php

class MensagensController extends Zend_Controller_Action
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
        
        $bdMensagens = new Application_Model_DbTable_Mensagens();
        
        $formSelectStatus = new Application_Form_SelectStatus();
        
        $status=$this->_getParam('status');
                
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        
        $dadosMensagens = $bdMensagens->listaMensagens(null, $status);

        $paginator = Zend_Paginator::factory($dadosMensagens);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
        $this->view->formSelectStatus = $formSelectStatus;
        $this->view->status = $status;
        
        
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

}

