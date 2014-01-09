<?php

class Application_Model_DbTable_Clientes extends Zend_Db_Table_Abstract
{

    protected $_name = 'clientes';
    protected $_primary = 'idCliente';
    
    
    public function pesquisarCliente($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirCliente(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'nome'      =>  $request['nome'],
            'dataUpdt'     =>   $date,
            'empresa'          =>  $request['mensagem'],
            'cnpj'            =>  $request['status'],
            'email'     => $request['email'],
            'idUsur'            =>  $usr
        );
        return $this->insert($dados);
    }
    
    public function alterarCliente(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'nome'      =>  $request['nome'],
            'dataUpdt'     =>   $date,
            'empresa'          =>  $request['mensagem'],
            'cnpj'            =>  $request['status'],
            'email'     => $request['email'],
            'idUsur'            =>  $usr
        );
        $where = $this->getAdapter()->quoteInto("idCliente = ?", $request['idCliente']);
        $this->update($dados, $where);
    }
    
    public function getNomeCliente(int $id){
        $select = $this->_db->select()
                ->from($this->_name, array('key'=>'idCliente','value'=>'nome'))
                ->where($this->getAdapter()->quoteInto("idCliente = ?", $id));
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}