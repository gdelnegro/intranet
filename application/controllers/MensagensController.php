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
        $dadosMensagens = $bdMensagens->listaMensagens(null, null);
        
        $this->view->dadosMensagens = $dadosMensagens;
        
        
        
        
        $campo=$this->_getParam('campo');
        $operador=$this->_getParam('operador');
        $valor=$this->_getParam('valor');
        
        $date = Zend_Date::now()->toString('yyyy-MM-dd');

        if(($campo!=NULL AND $campo!='campo') OR ($operador!=NULL AND $operador!="operador") OR ($valor!=NULL AND $valor!='')){
            #if($operador=='LIKE'){
            #    $where=$campo.' '.$operador.' \'%'.$valor.'%\'';
            #}else{
                $where=$campo.' '.$operador.' \''.$valor.'\'';
            #}
        }else{
            $where='date_="'.$date.'"';
        }
        
        $model = new Application_Model_Sms();
        $dados = $model->select("outgoing",$where);

        $paginator = Zend_Paginator::factory($dados);
        $paginator->setItemCountPerPage(50);
        $paginator->setPageRange(10);
        $paginator->setCurrentPageNumber($this->_request->getParam('pagina'));
        $this->view->paginator = $paginator;
        
        
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

