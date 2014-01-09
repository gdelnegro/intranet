<?php

class Application_Model_DbTable_Respostas extends Zend_Db_Table_Abstract
{

    protected $_name = 'respostas';
    protected $_primary = 'idResposta';
    
    
    public function pesquisarResposta($id = null, $where = null, $order = null, $limit = null){
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
    
    public function incluirResposta(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'dataResposta'     =>   $request['dataResposta'],
            'mensagem'          =>  $request['mensagem'],
            'idCliente'         =>  $request['idCliente'],
            'idContato'         =>  $request['idContato'],
            'idUsr'            =>  $usr
        );
        return $this->insert($dados);
    }
    
    public function alterarResposta(array $request, $usr){
        $date = Zend_Date::now()->toString('yyyy-MM-dd');
        $dados = array(
            /*
             * formato:
             * 'nome_campo => valor,
             */
            'dataResposta'     =>   $request['dataResposta'],
            'mensagem'          =>  $request['mensagem'],
            'idCliente'         =>  $request['idCliente'],
            'idContato'         =>  $request['idContato'],
            'idUsr'            =>  $usr
        );
        $where = $this->getAdapter()->quoteInto("idResposta = ?", $request['idResposta']);
        $this->update($dados, $where);
    }
    
    
    public function listaMensagens($id = null,$todas = NULL){
        $db = Zend_Db_Table::getDefaultAdapter();
        
        $select = $db->select()
             ->from('exibeMensagens');
        
        if( !is_null($id) ){
            $select->where('idContato = ?', $id);
            $results = $select->query()->fetchAll();
        
            return $results[0];
        }
        if( is_null($todas)){
            $select->where('status != ?', 'Fechado');
        }
        $select->order('dataContato DESC');
             
        $results = $select->query()->fetchAll();
        
        return $results;
            
    }
    
    /**
     * @author Gustavo Del Negro
     * @param integer $idContato
     * @param integer $idUsr
     */
    public function contRespostas($idContato = NULL ,$idUsr = NULL){
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                ->from('respostas', array('count(*) as total'));
        
        if ( !is_null($idContato) and is_null($idUsr)){
            $select->where('idContato = ?', $idContato);
            
        }elseif ( !is_null($idUsr) and is_null($idContato)) {
            $select->where('idUsr = ?', $idContato);
        }
        
        $results = $select->query()->fetchAll();
        
        return $results[0]['total'];

    }


}

