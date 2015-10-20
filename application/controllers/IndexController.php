<?php
header("Content-Type:text/html; charset=UTF-8");
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout("index");  
    }

    public function indexAction()
    {
        $moduleMapper = new Application_Model_moduleMapper();
        $zixunMapper = new Application_Model_zixunMapper();
        $albumMapper = new Application_Model_albumMapper();
        $modules = $moduleMapper->findAll(0);
        for ($i=0; $i < count($modules); $i++) {
            $modules[$i]['article'] = $zixunMapper->findByMidLimit($modules[$i]['module_id'],4);
            $limit = 4;
            if ($i > 8) {
                $limit = 5;
            }
            $modules[$i]['album'] = $albumMapper->findByMidLimit($modules[$i]['module_id'],$limit);
        }
        $this->view->modules = $modules;
    }

    //板块
    public function moduleAction()
    {
        $moduleMapper = new Application_Model_moduleMapper();
        if ($this->getRequest()->getParam('mid')) {
            $m = trim($this->getRequest()->getParam('mid'));
            if (!empty($m)) {
                $mcheck = $moduleMapper->getModule($m);
                if ($mcheck) {
                    $this->view->module_name = $mcheck[0]['module_name'];
                    $module_id = $m;
                }
                else {
                    $module_id = 1;
                }
            }
        }
        else {
            $module_id = 1;
        }

        if (isset($module_id) && is_numeric($module_id)) {
            $zixunMapper = new Application_Model_zixunMapper();
            $zixun = $zixunMapper->findByModule($module_id);
            $num=20; $page=1;
            $paginator_articleinfo = new Zend_Paginator(new Zend_Paginator_Adapter_Array($zixun));
            $paginator_articleinfo->setItemCountPerPage($num);
            $paginator_articleinfo->setCurrentPageNumber($page);
            $paginator_articleinfo->setCurrentPageNumber($this->_getParam('page'));
            $this->view->paginator_articleinfo = $paginator_articleinfo;
        }

        $this->view->newArticle = $zixunMapper->getAll(10);
    }

    public function searchAction()
    {
        $zixunMapper = new Application_Model_zixunMapper();
        @$keyword = trim($this->getRequest()->getParam('kw'));
        $this->view->keyword = $keyword ? $keyword : "搜索结果";
        
        if (isset($keyword) && !empty($keyword)) {
            $zixun = $zixunMapper->search($keyword);
            $num=20; $page=1;
            $paginator_articleinfo = new Zend_Paginator(new Zend_Paginator_Adapter_Array($zixun));
            $paginator_articleinfo->setItemCountPerPage($num);
            $paginator_articleinfo->setCurrentPageNumber($page);
            $paginator_articleinfo->setCurrentPageNumber($this->_getParam('page'));
            $this->view->paginator_articleinfo = $paginator_articleinfo;
        }

        $this->view->newArticle = $zixunMapper->getAll(10);
    }

    //资讯阅读页
    public function articleAction()
    {
    	if ($this->getRequest()->getParam('aid')) {
    		$aid = strip_tags(trim($this->getRequest()->getParam('aid')));
    		if (!empty($aid)) {
    			$zixunMapper = new Application_Model_zixunMapper();
    			$zixunArr = $zixunMapper->getById($aid);
    			if ($zixunArr) {
                    $this->view->article = array(
                        'status' => 'success',
                        'author' => $zixunArr[0]['author'],//作者
                        'from' => $zixunArr[0]['source'],//来源
                        'addtime' => $zixunArr[0]['addtime'],//发布时间
                        'pv' => $zixunArr[0]['visited'],//浏览量
                        'title' => $zixunArr[0]['title'],//标题
                        'content' => $zixunArr[0]['content']//正文
                        );
                    $moduleMapper = new Application_Model_moduleMapper();
                    $this->view->modulename = $moduleMapper->getById($zixunArr[0]['module_id']);
    				$visitUpdate = $zixunMapper->visitUpdate($aid);//刷新浏览量
    			}
                $this->view->newArticle = $zixunMapper->getAll(10);
    		}
    	}
    }
}
   