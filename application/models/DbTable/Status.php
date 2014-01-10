<?php

class Application_Model_DbTable_Status extends Zend_Db_Table_Abstract
{

    protected $_name = 'status';
    protected $_primary = 'idStatus';
    
    public function pesquisarStatus($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirStatus(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd HH:ii:ss');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'descricao'      =>  $request['descricao'],
            #'dataUpdt'     =>  $date,
            #'idUsr'     =>  $usr,
            
            
        );
        return $this->insert($dados);
    }
    
    public function alterarGrupo(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'descricao'      =>  $request['descricao'],
            #'dataUpdt'     =>  $date,
            #'idUsr'     =>  $usr,
        );
        $where = $this->getAdapter()->quoteInto("idStatus = ?", $request['idStatus']);
        $this->update($dados, $where);
    }
    
    public function getListaStatus($form=null){
        $select = $this->_db->select();
                if(is_null($form)){
                    $select->from($this->_name, array('key'=>'idStatus','value'=>'descricao'));
                }else{
                    $select->from($this->_name, array('key'=>'descricao','value'=>'descricao'));
                }
                
        $result = $this->getAdapter()->fetchAll($select);
        
        return $result;
    }


}

