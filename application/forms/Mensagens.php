<?php

class Application_Form_Mensagens extends Zend_Form
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
        $idUsr = new Zend_Form_Element_Hidden('idUsr');

        $mensagem = new Zend_Form_Element_Text('mensagem');
        $mensagem->setLabel('Mensagem')
                ->setAttrib('lenght', 30)
                ->setRequired(true)
                ->setFilters(array('StringTrim'))
                ->setValidators(array(
                    array('notEmpty', true, array(
                                'messages' => array(
                                    'isEmpty' => 'Não pode ser nulo'
                                )
                        )),
                    ))
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
        
        
        
        $dt_inclusao = new Zend_Form_Element_Text('dt_inclusao');
        $dt_inclusao->setLabel('Data de Inclusão')
                ->setAttrib('disabled', $this->exibir);
        
        $dt_alteracao = new Zend_Form_Element_Text('dt_alteracao');
        $dt_alteracao->setLabel('Data de Alteração')
                ->setAttrib('disabled', $this->exibir);
        

        $usuario = new Zend_Form_Element_Text('usuario');
        $usuario->setLabel('Usuário que alterou')
                ->setAttrib('disabled', $this->exibir);
        
        $submit = new Zend_Form_Element_Submit('enviar');
        $submit->setAttrib(
        'onclick', 
        'if (confirm("Deseja prosseguir?")) { document.form.submit(); } return false;'
        );
        
        
        $this->addElements(array(
            $idContato,
            $idUsr,
            $mensagem,
            $status,
        ));
        
        if ($this->tipo == 'SHOW'){
            $this->addElements(array(
                $dt_inclusao,
                $dt_alteracao,
                $usuario,
            ));
        }
        
        if ($this->tipo != 'SHOW'){
            $this->addElement($submit);
        }
        
        /*Botão Voltar*/
        $this->addElement("button", "voltar", array(
			"class" => "btn-primary",
			"label" => "Voltar",
                        "onclick" => 'window.location =\''.$this->getView()->url(array('controller'=>'grupo','action'=>'index')).'\' '
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

