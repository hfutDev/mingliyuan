<?php
  /**
  * 评论管理
  */
  class Application_Model_commentMapper
  {
  	
  	function __construct(argument)
  	{
		$this->db = new Application_Model_DbTable_Comment();
  	}
  }
?>