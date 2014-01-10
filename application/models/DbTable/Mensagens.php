<?php

class Application_Model_DbTable_Mensagens extends Zend_Db_Table_Abstract
{

    protected $_name = 'contatos';
    protected $_primary = 'idContato';
    
    
    public function pesquisarMensagens($id = null, $where = null, $order = null, $limit = null){
        if( !is_null($id) ){
            $arr = $this->find($id)->toArray();
            return $arr[0];
        }else{
            $select = $this->select()->from($this)->order($order)->limit($limit);
            if(!is_null($where)){
                $select->where($where);
            }
            return $this->fetchAll($select)->toArray();
        }
    }
    
    public function incluirMensagem(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'dataContato'      =>  $request['dataContato'],
            'dataResposta'     =>   $request['dataResposta'],
            'dataUpdt'     =>   $date,
            'mensagem'          =>  $request['mensagem'],
            'status'            =>  $request['status'],
            'idCliente'         =>  $request['idCliente'],
            'idUsr'            =>  $usr
        );
        return $this->insert($dados);
    }
    
    public function alterarMensagem(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'dataContato'      =>  $request['dataContato'],
            'dataResposta'     =>   $request['dataResposta'],
            'dataUpdt'     =>   $date,
            'mensagem'          =>  $request['mensagem'],
            'status'            =>  $request['status'],
            'idCliente'         =>  $request['idCliente'],
            'idUsr'            =>  $usr
        );
        $where = $this->getAdapter()->quoteInto("idContato = ?", $request['idContato']);
        $this->update($dados, $where);
    }
    
    
    public function listaMensagens($id = null,$status = NULL){
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $select = $db->select()
             ->from('exibeMensagens');
        
        if( !is_null($id) ){
            $select->where('idContato = ?', $id);
            $results = $select->query()->fetchAll();
        
            return $results[0];
        }
        if( is_null($status)){
            $select->where('status != ?', 'Fechado');
        }elseif( !is_null($status) ){
            $select->where('status = ?', $status);
        }
        $select->order('dataContato DESC');
             
        $results = $select->query()->fetchAll();
        
        return $results;
            
    }
}