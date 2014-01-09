<?php

class Application_Form_Responder extends Zend_Form
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
        
        /*
        idResposta
        idUsr
        mensagem
        dataResposta
        idCliente
        idContato
        */
        
        /*Método do formulário (post ou get)*/
        $this->setMethod('post');
        /*Atributo HTML do form*/
        $this->setAttrib("vertical", true);
                
        /*Elementos*/
        $idContato = new Zend_Form_Element_Hidden('idContato');
        $idCliente = new Zend_Form_Element_Hidden('idCliente');
        

        $mensagem = new Zend_Form_Element_Textarea('mensagem');
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
                ->setAttrib('rows','10')
                ->setAttrib('disabled', $this->exibir)
                ->setDecorators(array(
                            'ViewHelper', 'Errors', 'Description',
                            array(array('inner' => 'HtmlTag'),
                                array('tag' => 'div', 'class' => 'span4')),
                            'Label',
                            array(array('outter' => 'HtmlTag'),
                                array('tag' => 'div', 'class' => 'span4'))
                        ));
        
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
            $mensagem,
            $status,
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
        
    }

}

