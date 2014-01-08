<?php

class Application_Model_DbTable_Contatos extends Zend_Db_Table_Abstract
{

    protected $_name = 'contatos';
    protected $_primary = 'idContato';
    
    
    public function pesquisarContato($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirContato(array $request, $usr){
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
            'idUsur'            =>  $usr
        );
        return $this->insert($dados);
    }
    
    public function alterarContato(array $request, $usr){
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
            'idUsur'            =>  $usr
        );
        $where = $this->getAdapter()->quoteInto("idContato = ?", $request['idContato']);
        $this->update($dados, $where);
    }
    
}