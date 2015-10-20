<?php
  /**
  * 板块管理
  */
  class Application_Model_moduleMapper
  {
  	
  	function __construct()
  	{
      $this->db = new Application_Model_DbTable_Module();
  	}

    public function findAll($limit)
    {
      $order = 'module_id';
      $select = $this->db->select();
      $select->limit($limit);
      $select->order($order);
      $res = $this->db->fetchAll($select)->toarray();
      return $res;
    }

    //根据id获取板块name
    public function getById($module_id)
    {
      $ab = $this->db->select();
      $ab = $ab->from("module",'module_name');
      $where = $ab->where("module_id =?",$module_id);
      $res = $this->db->fetchRow($where)->toarray();
      return $res;
    }

    //根据type获取板块name
    public function getByType($module_type)
    {
      $ab = $this->db->select();
      $where = $ab->where("module_type =?",$module_type);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    public function getModule($module_id)
    {
      $ab = $this->db->select();
      $where = $ab->where("module_id =?",$module_id);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    //更新板块
    public function Update($module_id,$module_info)
    {
      if (isset($module_info['name'])) {
        $module_name = $module_info['name'];
      } else {
        $module_name = new Zend_Db_Expr('module_name');
      }

      if (isset($module_info['img'])) {
        $module_img = $module_info['img'];
      } else {
        $module_img = new Zend_Db_Expr('module_img');
      }
      
      if (isset($module_info['type'])) {
        $module_type = $module_info['type'];
      } else {
        $module_type = new Zend_Db_Expr('module_type');
      }

      $upArr = array(
        'module_name'=>$module_name,
        'module_img'=>$module_img,
        'module_type'=>$module_type
        );
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('module_id=?',$module_id);
      $res = $this->db->update($set=$upArr,$where);
      return $res;
    }

    //添加板块
    public function addModule($module_info)
    {
      if (count($module_info) == 0) {
        return false;
        exit();
      }
      if (isset($module_info['name'])) {
        $module_name = $module_info['name'];
      } else {
        $module_name = '';
      }

      if (isset($module_info['img'])) {
        $module_img = $module_info['img'];
      } else {
        $module_img = '';
      }
      
      if (isset($module_info['type'])) {
        $module_type = $module_info['type'];
      } else {
        $module_type = '';
      }

      $arr = array(
        'module_name'=>$module_name,
        'module_img'=>$module_img,
        'module_type'=>$module_type
        );
      $res = $this->db->insert($arr);
      return $res;
    }

    //删除
    public function delModule($id)
    {
      if (!is_array($id))
        $id=array($id);

      $ab=$this->db->getAdapter();
      foreach ($id as $id) {
        $where=$ab->quoteInto('module_id=?',$id);
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
  }
?>