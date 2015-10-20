<?php
  /**
  * 用户管理
  */
  class Application_Model_userMapper
  {
  	function __construct()
  	{
      $this->db = new Application_Model_DbTable_User();
  	}

    //检查用户名密码
    public function checkUser($uname,$pwd)
    {
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('uname = ?',$uname)
      .$ab->quoteInto('AND pwd = ?',$pwd);
      $arr = $this->db->fetchAll($where)->toArray();
      return $arr;
    }

    //查找用户
    public function getByName($uname)
    {
      $ab = $this->db->select();
      $where = $ab->where("uname =?",$uname);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    public function getById($uid)
    {
      $ab = $this->db->select();
      $where = $ab->where("uid =?",$uid);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    //添加用户
    public function addUser($uname,$pwd)
    {
      $pwd = md5($pwd);
      $arr = array(
        'uname' => $uname,
        'pwd' => $pwd
        );
      $res = $this->db->insert($arr);
      return $res;
    }

    //查看所有用户
    public function findAll($limit)
    {
      $order = 'uid';
      $select = $this->db->select();
      $select->limit($limit);
      $select->order($order);
      $res = $this->db->fetchAll($select)->toarray();
      return $res;
    }

    // 删除用户
    public function delUser($uid)
    {
      if (!is_array($uid)) {
        $uid=array($uid);
      }
      $ab=$this->db->getAdapter();
      foreach ($uid as $uid) {
        $where=$ab->quoteInto('uid IN(?)',$uid);
        $arr=$this->db->fetchAll($where)->toArray();

        $del=$this->db->delete($where);
        if ($del!='')  {
          $info = true;
        }
        else {
          $info = false;
        }
      }
      return $info;
    }

    //修改
    public function update($uid,$uname,$pwd)
    {
      $pwd = md5($pwd);
      $arr = array(
        'uname' => $uname,
        'pwd' => $pwd
        );
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('uid=?',$uid);
      $res = $this->db->update($set=$arr,$where);
      return $res;
    }
  }
?>