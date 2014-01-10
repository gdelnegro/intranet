<?php

class Application_Form_SelectStatus extends Twitter_Form
{

    public function init()
    {
        $this->setMethod('post');

        
        $dbStatus = new Application_Model_DbTable_Status();
        
        $listaStatus = $dbStatus->getListaStatus(true);
            
        $status = new Zend_Form_Element_Select('status');
        $status->setLabel('Status do contato:')
                ->setRequired(true)
                ->addMultiOptions($listaStatus);
        
        $this->addElement($status);
        
        $submit = new Zend_Form_Element_Submit('enviar');
        $submit->setLabel('Filtrar')
                ->setAttrib('class','btn-primary');
        
        $this->addElement($submit);
            
    }


}

