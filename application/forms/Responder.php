<?php

class Application_Form_Responder extends Twitter_Form
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
        $this->setAttrib("horizontal", true);
                
        /*Elementos*/
        $idContato = new Zend_Form_Element_Hidden('idContato');
        $idCliente = new Zend_Form_Element_Hidden('idCliente');
        $idUsr = new Zend_Form_Element_Hidden('idUsr');
        

        $mensagem = new Zend_Form_Element_Textarea('resposta');
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
        
        $dataResposta = new Zend_Form_Element_Text('dataResposta');
        $dataResposta->setLabel('Data da Resposta')
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
                ->setLabel('Enviar')
                ->setAttrib('class','btn-primary');
        
        
        $this->addElements(array(
            $idContato,
            $idCliente,
            $idUsr,
            $mensagem,
        ));
        
        if ($this->tipo == 'SHOW'){
            $this->addElements(array(
                $dataResposta,
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
        $this->addElement("button", "Fechar", array(
			"class" => "btn-primary",
			"label" => "Voltar",
                        "onclick" => 'window.close();'
                        
		));
        
    }

}

