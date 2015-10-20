<?php
  /**
  * 板块分列管理
  */
  class Application_Model_columnMapper
  {
  	
  	function __construct()
  	{
      $this->db = new Application_Model_DbTable_Column();
  	}

    public function findAll($limit)
    {
      $order = 'column_id';
      $select = $this->db->select();
      $select->limit($limit);
      $select->order($order);
      $res = $this->db->fetchAll($select)->toarray();
      return $res;
    }

    //根据id获取子板块信息
    public function getById($column_id)
    {
      $ab = $this->db->select();
      $ab = $ab->from("column",'column_name');
      $where = $ab->where("column_id =?",$column_id);
      $res = $this->db->fetchRow($where);
      if ($res) {
        $res = $res->toarray();
      }
      return $res;
    }

    //根据板块获取子版块
    public function getColumn($module_id)
    {
      $ab = $this->db->select();
      $where = $ab->where("module_id =?",$module_id);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    public function getModule($column_id)
    {
      $ab = $this->db->select();
      $ab = $ab->from("column",'module_id');
      $where = $ab->where("column_id =?",$column_id);
      $result = $this->db->fetchRow($where);
      if ($result) {
        return $result->toarray();
      }
    }

    public function findOther($column_id)
    {
      $ab = $this->db->select();
      $where = $ab->where("column_id =?",$column_id);
      $result = $this->db->fetchRow($where)->toarray();
      if ($result) {
        $ab = $this->db->select();
        $where = $ab->where("module_id =?",$result['module_id']);
        $res = $this->db->fetchAll($where)->toarray();
        if ($res) {
          return $res;
        }
      }
    }

    //根据板块获取子版块id
    public function getColumnId($module_id)
    {
      $ab = $this->db->select();
      $ab = $ab->from("column",'column_id');
      $where = $ab->where("module_id =?",$module_id);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    //添加板块
    public function addColumn($column_info)
    {
      if (count($column_info) == 0) {
        return false;
        exit();
      }
      if (isset($column_info['name'])) {
        $column_name = $column_info['name'];
      } else {
        return false;
        exit();
      }

      if (isset($column_info['mid'])) {
        $column_mid = $column_info['mid'];
      } else {
        return false;
        exit();
      }

      $arr = array(
        'column_name'=>$column_name,
        'module_id'=>$column_mid
        );
      $res = $this->db->insert($arr);
      return $res;
    }

    //删除
    public function delColumn($id)
    {
      if (!is_array($id))
        $id=array($id);

      $ab=$this->db->getAdapter();
      foreach ($id as $id) {
        $where=$ab->quoteInto('column_id=?',$id);
        $arr=$this->db->fetchAll($where)->toArray();
        $del=$this->db->delete($where);
        if ($del!='') {
          $info= true;
        }  else {
          $info= false;
        }
      }
      return $info;
    }

    //更新板块
    public function Update($column_id,$column_info)
    {
      if (isset($column_info['name'])) {
        $column_name = $column_info['name'];
      } else {
        $column_name = new Zend_Db_Expr('column_name');
      }

      if (isset($column_info['mid'])) {
        $column_mid = $column_info['mid'];
      } else {
        $column_mid = new Zend_Db_Expr('module_id');
      }

      $upArr = array(
        'column_name'=>$column_name,
        'module_id'=>$column_mid
        );
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('column_id=?',$column_id);
      $res = $this->db->update($set=$upArr,$where);
      return $res;
    }
  }
?>
