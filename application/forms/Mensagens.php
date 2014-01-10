<?php

class Application_Form_Mensagens extends Twitter_Form
{
    
    protected $exibir;
    protected $tipo;
    protected $usr;

    public function __construct($tipo = null, $usr = null, $options = null) {
        $this->tipo = strtoupper($tipo);
        $this->usr = $usr;
        
        if ( strtoupper($tipo)=='EDIT' OR strtoupper($tipo)=='NEW'){
            $this->exibir = null;
        }else if ( strtoupper($tipo) == 'SHOW' ){
            $this->exibir = true;
        }
        parent::__construct($options);
    }
    
    public function init()
    {
        /*Método do formulário (post ou get)*/
        $this->setMethod('post');
        /*Atributo HTML do form*/
        $this->setAttrib("horizontal", true);
                
        /*Elementos*/
        $idContato = new Zend_Form_Element_Hidden('idContato');
        $idCliente = new Zend_Form_Element_Hidden('idCliente');
        $idUsr = new Zend_Form_Element_Hidden('idUsr');

        $mensagem = new Zend_Form_Element_Textarea('mensagem');
        $mensagem->setLabel('Mensagem')
                ->setAttrib('rows', 10)
                ->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators(array(
                    array('notEmpty', true, array(
                                'messages' => array(
                                    'isEmpty' => 'Não pode ser nulo'
                                )
                        )),
                    ))
                ->setAttrib('rows','10')
                ->setAttrib('disabled', $this->exibir);

        $obs = new Zend_Form_Element_Textarea('obs');
        $obs->setLabel('Comentário')
                ->setAttrib('rows', 10)
                ->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators(array(
                    array('notEmpty', true, array(
                                'messages' => array(
                                    'isEmpty' => 'Não pode ser nulo'
                                )
                        )),
                    ))
                ->setAttrib('rows','10')
                ->setAttrib('disabled', $this->exibir);
        
        /*
         *Seleciona os valores do status de acordo com a tabela status 
         */
        
        if( $this->exibir == TRUE){
            $status = new Zend_Form_Element_Text('status');
            $status->setLabel('Status do Contato:')
                    ->setAttrib('disabled', $this->exibir);
        }else{
            $dbStatus = new Application_Model_DbTable_Status();
            $listaStatus = $dbStatus->getListaStatus();
            
            $status = new Zend_Form_Element_Select('status');
            $status->setLabel('Status do contato:')
                    ->setRequired(true)
                    ->addMultiOptions($listaStatus)
                    ->setAttrib('disabled', $this->exibir);
        }
        
        
        
        $dt_inclusao = new Zend_Form_Element_Text('dataContato');
        $dt_inclusao->setLabel('Data de Contato')
                ->setAttrib('disabled', $this->exibir);
        
        $dt_alteracao = new Zend_Form_Element_Text('dataUpdt');
        $dt_alteracao->setLabel('Data de Alteração')
                ->setAttrib('disabled', $this->exibir);
        
        $cliente = new Zend_Form_Element_Text('nomeCliente');
        $cliente->setLabel('Enviada por:')
                ->setAttrib('disabled', $this->exibir);
        

        $usuario = new Zend_Form_Element_Text('nomeUsuario');
        $usuario->setLabel('Usuário que alterou')
                ->setAttrib('disabled', $this->exibir);
        
        $submit = new Zend_Form_Element_Submit('enviar');
        $submit->setAttrib(
        'onclick', 
        'if (confirm("Deseja prosseguir?")) { document.form.submit(); } return false;'
        )
                ->setAttrib('class','btn-primary');
        
        
        $this->addElements(array(
            $idContato,
            $idCliente,
            $idUsr,
            $mensagem,
            $status,
            $obs,
        ));
        
        if ($this->tipo == 'SHOW'){
            $this->addElements(array(
                $dt_inclusao,
                $dt_alteracao,
                $usuario,
                $cliente
            ));
        }
        
        if ($this->tipo != 'SHOW'){
            $this->addElements(array(
                $submit,
                    ));
            
        }
        
        /*Botão Voltar*/
        $this->addElement("button", "voltar", array(
			"class" => "btn-primary",
			"label" => "Voltar",
                        "onclick" => 'window.location =\''.$this->getView()->url(array('controller'=>'mensagens','action'=>'index')).'\' '
                        
		));
        
        $this->addElement("button", "responder", array(
			"class" => "btn-primary",
			"label" => "Responder",
                        #"onclick" => 'window.location =\''.$this->getView()->url(array('controller'=>'mensagens','action'=>'responder')).'\' '
                        #"onclick" => 'window.open (\''.$this->getView()->url(array('controller'=>'mensagens','action'=>'responder')).'\'"_blank","toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400 ") '
                        "onclick" => 'window.open("'.$this->getView()->url(array('controller'=>'responder','action'=>'mensagem',)).'","_blank","toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=600, height=400 ")'                       
		));
                
        
        /*Botão Imprimir*/
        $this->addElement("button", "imprimir", array(
			"class" => "btn-primary",
			"label" => "Imprimir",
                        "onclick" => 'window.print()',
                        //"onclick" => 'window.location =\''.$this->getView()->url(array('controller'=>'papel','action'=>'print')).'\' '
		));
        
    }

}

