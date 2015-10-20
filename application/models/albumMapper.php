<?php
  /**
  * 图片管理
  */
  class Application_Model_albumMapper
  {
  	
  	function __construct()
  	{
      $this->db = new Application_Model_DbTable_Album();
  	}
    //根据id获取板块name
    public function findByMid($mid)
    {
      $ab = $this->db->select();
      $where = $ab->where("mid =?",$mid);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    public function findByMidLimit($mid,$limit)
    {
      $ab = $this->db->select();
      $ab->where("mid =?",$mid);
      $ab->limit($limit);
      $ab->order("filetime DESC");
      $res = $this->db->fetchAll($ab)->toarray();
      return $res;
    }

    //根据id获取详情
    public function getById($id)
    {
      $ab = $this->db->select();
      $where = $ab->where("id =?",$id);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    public function delImg($id)
    {
      if (!is_array($id))
        $id=array($id);

      $ab=$this->db->getAdapter();
      foreach ($id as $id) {
        $where=$ab->quoteInto('id=?',$id);
        $arr=$this->db->fetchAll($where)->toArray();
        $del=$this->db->delete($where);
        if ($del!='') {
          $info=true;
        }  else {
          $info=false;
        }
      }
      return $info;
    }

    //添加板块
    public function addImg($album)
    {
      if (count($album) == 0) {
        return false;
        exit();
      }
      if (isset($album['mid'])) {
        $mid = $album['mid'];
      } else {
        $mid = '';
      }

      if (isset($album['path'])) {
        $path = $album['path'];
      } else {
        $path = '';
      }
      
      if (isset($album['filetime'])) {
        $filetime = $album['filetime'];
      } else {
        $filetime = '';
      }

      $arr = array(
        'mid' => $mid,
        'path' => $path,
        'filetime' => $filetime
        );
      $res = $this->db->insert($arr);
      return $res;
    }
  }
?>