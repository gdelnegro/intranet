<?php

class ContatosController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $bdContatos = new Application_Model_DbTable_Contatos();
        
        $dadosContatos = $bdContatos->pesquisarContato();
        
        $this->view->dadosContatos = $dadosContatos;
    }


}

