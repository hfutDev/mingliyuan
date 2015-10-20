<?php
  /**
  * ��Ѷ���¹���
  */
  class Application_Model_zixunMapper
  {
  	
  	function __construct()
  	{
      $this->db = new Application_Model_DbTable_Zixun();
  	}

    //��ȡ������Ѷ
    public function getAll($limit)
    {
      $order = 'addtime DESC';
      $select = $this->db->select();
      $select->limit($limit);
      $select->order($order);
      $res = $this->db->fetchAll($select)->toarray();
      return $res;
    }

    //�ְ������Ѷ
    public function findByModule($module_id)
    {
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('module_id IN(?)',$module_id);
      $order = 'addtime DESC';
      $resArr = $this->db->fetchAll($where,$order)->toArray();
      return $resArr;
    }

    //�ְ��������Ѷ
    public function findByMidLimit($module_id,$limit)
    {
      $ab = $this->db->select();
      $ab->where("module_id =?",$module_id);
      $ab->limit($limit);
      $ab->order("addtime DESC");
      $res = $this->db->fetchAll($ab)->toarray();
      return $res;
    }

    public function search($title)
    {
      $ab = $this->db->getAdapter();
      $word = "%" . $title . "%";
      $sql = "SELECT * FROM `zixun` WHERE `title` LIKE ?";
      $sql = $ab->quoteInto($sql, $word);
      $res = $ab->query($sql)->fetchAll();
      return $res;
    }

    //����id��ȡ��������
    public function getById($id)
    {
      $ab = $this->db->select();
      $where = $ab->where("id =?",$id);
      $res = $this->db->fetchAll($where)->toarray();
      return $res;
    }

    //�����û�id��ȡ����������
    public function getByUid($uid,$limit=null)
    {
      $ab = $this->db->select();
      $ab->where("uid =?",$uid);
      $ab->limit($limit);
      $res = $this->db->fetchAll($ab)->toarray();
      return $res;
    }

    //���������
    public function visitUpdate($id)
    {
      $upArr = array('visited' => new Zend_Db_Expr('visited+1'));
      $ab = $this->db->getAdapter();
      $where = $ab->quoteInto('id=?',$id);
      $res = $this->db->update($set=$upArr,$where);
      return $res;
    }

    //�������
    public function writeArticle($urlType,$id,$uid,$author,$source,$addtime,$visited,$content,$title,$module_id)
    {
      if ($urlType == "update" || empty($uid)) {
        $uid = 0;
      }
      $arr = array(
        'uid' => $uid,
        'author' => $author, 
        'source' => $source,
        'addtime' => $addtime,
        'visited' => $visited,
        'content' => $content,
        'title' => $title,
        'module_id' => $module_id
        );
      if ($urlType == 'update') {
        $ab=$this->db->getAdapter();
        $where=$ab->quoteInto('id=?',$id);
        $res=$this->db->update($set=$arr,$where);
      } else {
        $res=$this->db->insert($arr);
      }
      
      return $res;
    }

    public function delarticle($id)
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
  }
?>