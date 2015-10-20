<?php
header("Content-Type:text/html; charset=UTF-8");
class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $session = new Zend_Session_Namespace('zixun');
        $this->view->session = $this->session = $session;
    	if (!isset($session->admin)) {
    		$this->_redirect("/login");
    	}
        $moduleMapper = new Application_Model_moduleMapper();
        $this->view->arrModule = $moduleMapper->findAll(0);//所有板块
    }

    public function indexAction()
    {
        $zixunMapper = new Application_Model_zixunMapper();
        $moduleMapper = new Application_Model_moduleMapper();
        $limit = 10;//获取最新资讯条数
        if ($this->session->type == 1) {
            $countAll = $zixunMapper->getAll($limit);
            $this->view->newArticle = $countAll;
        }
        else {
            $countAll = $zixunMapper->getByUid($this->session->uid,$limit);
            if ($countAll) {
                $this->view->newArticle = $countAll;
            }
        }

    }

    //分板块浏览文章
    public function moduleAction()
    {
        if($this->session->type != 1){
            $this->_redirect("/admin/myarticle");
            exit();
        }
        $mid = trim($this->_request->getParam("mid"));
        $type = trim($this->_request->getParam("type"));
        $moduleMapper = new Application_Model_moduleMapper();
        $zixunMapper = new Application_Model_zixunMapper();
        $albumMapper = new Application_Model_albumMapper();
        if (empty($mid)) {
            $mid = 1;//默认为1
        }
        $module = $moduleMapper->getModule($mid);
        if (!$module) {
            $this->_redirect("/admin/module/mid/1");
            exit();
        }
        $this->view->module_name = $module[0]['module_name'];
        $this->view->module_id = $module[0]['module_id'];
        $this->view->module_type = $type;
        if ($type == 1) {
            $album = $albumMapper->findByMid($mid);
            $num=10; $page=1;
            $paginator_articleinfo = new Zend_Paginator(new Zend_Paginator_Adapter_Array($album));
            $paginator_articleinfo->setItemCountPerPage($num);
            $paginator_articleinfo->setCurrentPageNumber($page);
            $paginator_articleinfo->setCurrentPageNumber($this->_getParam('page'));
            $this->view->paginator_articleinfo = $paginator_articleinfo;
        }else{
            $zixun = $zixunMapper->findByModule($mid);
            $num=10; $page=1;
            $paginator_articleinfo = new Zend_Paginator(new Zend_Paginator_Adapter_Array($zixun));
            $paginator_articleinfo->setItemCountPerPage($num);
            $paginator_articleinfo->setCurrentPageNumber($page);
            $paginator_articleinfo->setCurrentPageNumber($this->_getParam('page'));
            $this->view->paginator_articleinfo = $paginator_articleinfo;
        }
    }

    //发布文章/修改文章//删除
    public function writearticleAction()
    {
        $urlType = $this->_request->getParam("type");
        $moduleMapper = new Application_Model_moduleMapper();
        $zixunMapper = new Application_Model_zixunMapper();

        if ($urlType == 'add') {//添加文章
            $title = $this->_request->getParam("title");
            $source = $this->_request->getParam("source");
            $author = $this->_request->getParam("author");
            $mid = $this->_request->getParam("module_id");
            $publishtime = $this->_request->getParam("publishtime");
            $visited = $this->_request->getParam("visited");
            $article = $this->_request->getParam("article");
            $type = 'add';$aid = 0;$uid = $this->session->uid;
            if (empty($title)||empty($source)||empty($author)||empty($mid)||empty($article)||empty($type)) {
                echo "emptyError";
                exit;
            }
            if (empty($publishtime) || $this->session->type != 1) {
                $publishtime = date("Y-m-d H:i:s");
            }
            if (empty($visited) || $this->session->type != 1) {
                $visited = 0;
            }
            $article = str_replace("\"", "'", $article);
            $addArt = $zixunMapper->writeArticle($type,$aid,$uid,$author,$source,$publishtime,$visited,$article,$title,$mid);
            if ($addArt) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit;
        }

        else if ($urlType == 'edit') {//编辑文章
            $aid = $this->_request->getParam("aid");
            $title = $this->_request->getParam("title");
            $source = $this->_request->getParam("source");
            $author = $this->_request->getParam("author");
            $mid = $this->_request->getParam("module_id");
            $publishtime = $this->_request->getParam("publishtime");
            $visited = $this->_request->getParam("visited");
            $article = $this->_request->getParam("article");
            $type = 'update';$uid = '';
            if (empty($aid)||empty($title)||empty($source)||empty($author)||empty($mid)||empty($article)||empty($type)) {
                echo "emptyError";
                exit;
            }
            if (empty($publishtime) || $this->session->type != 1) {
                $publishtime = date("Y-m-d H:i:s");
            }
            if (empty($visited) || $this->session->type != 1) {
                $visited = 0;
            }
            $addArt = $zixunMapper->writeArticle($type,$aid,$uid,$author,$source,$publishtime,$visited,$article,$title,$mid);
            if ($addArt) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit;
        }

        if ($urlType == 'del') {//删除文章
            $aid = $this->_request->getParam("aid");
            if ($aid) {
                if (!is_array($aid)) {
                    $aid[] = $aid;
                }
                foreach ($aid as $key => $value) {
                    $zixunMapper = new Application_Model_zixunMapper();
                    $check = $zixunMapper->getById($value);
                    if ($check) {
                        $del = $zixunMapper->delarticle($value);
                    }
                }
                if ($del) {
                    echo "success";
                }
                else {
                    echo "error";
                }
            }
            else {
                echo "emptyError";
            }
            exit();
        }
    }

    public function writeimgAction()
    {
        $urlType = $this->_request->getParam("type");
        if ($urlType == 'del') {//删除文章
            $id = $this->_request->getParam("id");
            if ($id) {
                if (!is_array($id)) {
                    $id = array($id);
                }
                foreach ($id as $key => $value) {
                    $albumMapper = new Application_Model_albumMapper();
                    $check = $albumMapper->getById($value);
                    if ($check) {
                        $del = $albumMapper->delImg($value);
                    }
                }
                if ($del) {
                    echo "success";
                }
                else {
                    echo "error";
                }
            }
            else {
                echo "emptyError";
            }
            exit();
        }
        @$path = trim($this->_request->getParam("path"));
        @$mid = trim($this->_request->getParam("imgMid"));
        if (empty($mid) || empty($path)) {
            echo "emptyError";
            exit();
        }
        $path = "/upload/".$path;
        if (!is_numeric($mid)) {
            echo "invalid mid";exit();
        }
        $imgArr = array(
            'mid' => $mid,
            'path' => $path,
            'filetime' => time()
            );
        $albumMapper = new Application_Model_albumMapper();
        $modimg = $albumMapper->addImg($imgArr);
        if ($modimg) {
            echo "success";
        }
        else {
            echo "error";
        }
        exit();
    }

    //编辑文章
    public function editarticleAction()
    {
        $aid = trim($this->_request->getParam("aid"));
        if ($aid) {
            $zixunMapper = new Application_Model_zixunMapper();
            $oldArticle = $zixunMapper->getById($aid);
            // print_r($oldArticle);
            if ($oldArticle) {
                $this->view->oldArticle = $oldArticle;
            }
            else {
                echo "<h2>404　Page not found</h2>";
                exit;
            }
        }
        else {
            echo "<h2>404　Page not found</h2>";
            exit;
        }
    }

    //用户管理（超级管理员权限）
    public function usermanagerAction()
    {
        if ($this->session->type != 1) {
            echo "<h2>403　Forbidden</h2>";
            exit();
        }
        $userMapper = new Application_Model_userMapper();
        $urlType = $this->_request->getParam("type");
        if ($urlType == 'del') {//删除动作
            $uid = $this->_request->getParam("uid");
            if (empty($uid)) {
                echo "emptyError";
                exit();
            }
            $del = $userMapper->delUser($uid);
            if ($del) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
        elseif ($urlType == 'add') {//添加动作
            $username = trim($this->_request->getParam("username"));
            $pwd = trim($this->_request->getParam("pwd"));
            $pwd = md5($pwd);
            if (empty($username)||empty($pwd)) {
                echo "null";
                exit();
            }
            $userMapper = new Application_Model_userMapper();
            $check = $userMapper->getByName($username);
            if ($check||$username == 'online') {//检查用户名是否存在
                echo "exist";
                exit();
            }
            $adduser = $userMapper->addUser($username,$pwd);//添加用户
            if ($adduser) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
        elseif ($urlType == 'update') {
            $username = trim($this->_request->getParam("username"));
            $pwd = trim($this->_request->getParam("pwd"));
            $uid = trim($this->_request->getParam("uid"));
            $pwd = md5($pwd);
            if (empty($username)||empty($pwd)||empty($uid)) {
                echo "emptyError";
                exit();
            }
            $userMapper = new Application_Model_userMapper();
            $check1 = $userMapper->getById($uid);
            if (!$check1) {//检查uid
                echo "emptyError";
                exit();
            }
            if ($username == 'online') {//检查用户名是否存在
                echo "exist";
                exit();
            }
            $check2 = $userMapper->getByName($username);
            if ($check2) {
                $username = new Zend_Db_Expr('uname');
            }
            $edituser = $userMapper->update($uid,$username,$pwd);//添加用户
            if ($edituser) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }

        $user = $userMapper->findAll(0);
        $num=10; $page=1;
        $paginator_user = new Zend_Paginator(new Zend_Paginator_Adapter_Array($user));
        $paginator_user->setItemCountPerPage($num);
        $paginator_user->setCurrentPageNumber($page);
        $paginator_user->setCurrentPageNumber($this->_getParam('page'));
        $this->view->paginator_user = $paginator_user;
    }

    public function myarticleAction()
    {
        $zixunMapper = new Application_Model_zixunMapper();
        $zixun = $zixunMapper->getByUid($this->session->uid);
        // print_r($zixun);exit();

        $num=10; $page=1;
        $paginator_articleinfo = new Zend_Paginator(new Zend_Paginator_Adapter_Array($zixun));
        $paginator_articleinfo->setItemCountPerPage($num);
        $paginator_articleinfo->setCurrentPageNumber($page);
        $paginator_articleinfo->setCurrentPageNumber($this->_getParam('page'));
        $this->view->paginator_articleinfo = $paginator_articleinfo;
    }

    public function modifypwdAction()
    {
        $this->_helper->layout->disableLayout();
        if ($this->session->type != 1) {
            $mPwd = trim($this->_request->getParam("mPwd"));
            $cPwd = trim($this->_request->getParam("cPwd"));
            if (empty($mPwd)||empty($cPwd)) {
                echo "emptyError";
                exit();
            }
            if ($mPwd != $cPwd) {
                echo "error";
                exit();
            }
            $pwd = md5($mPwd);
            $userMapper = new Application_Model_userMapper();
            $uid = $this->session->uid;
            $check = $userMapper->getById($uid);
            if ($check) {
                $uname = new Zend_Db_Expr('uname');
                $modify = $userMapper->update($uid,$uname,$pwd);
                if ($modify) {
                    echo "success";
                }
                else {
                    echo "error";
                }
            }
            else {
                echo "error";
            }
        }
    }

    //超级管理员权限、网站基本设置
    public function basemanageAction()
    {
        $urlType = $this->_request->getParam("type");
        $moduleMapper = new Application_Model_moduleMapper();

        if ($urlType == 'editmid') {//修改大板块
            $mid = trim($this->_request->getParam("mid"));
            $name = trim($this->_request->getParam("name"));
            $title = trim($this->_request->getParam("title"));
            if (empty($mid)||empty($name)||empty($title)) {
                echo "emptyError";exit;
            }
            $info = array('name'=>$name,'title'=>$title);
            $edit = $moduleMapper->Update($mid,$info);
            if ($edit) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
        if ($urlType == 'addmid') {
            $name = trim($this->_request->getParam('name'));
            if (empty($name)) {
                echo "emptyError";
                exit();
            }
            $addArr = array('name'=>$name);
            $add = $moduleMapper->addModule($addArr);
            if ($add) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
        if ($urlType == 'delmid') {//删除大板块
            $mid = trim($this->_request->getParam("mid"));
            if (empty($mid)) {
                echo "emptyError";
                exit();
            }
            $del = $moduleMapper->delModule($mid);
            if ($del) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
        if ($urlType == 'midImg') {//修改一级板块背景
            $img = trim($this->_request->getParam("img"));
            $mid = trim($this->_request->getParam("imgMid"));
            $path = trim($this->_request->getParam("path"));
            if (empty($img)||empty($mid)||empty($path)) {
                echo "emptyError";
                exit();
            }
            $path = "/upload/".$path;
            $Midarr = array('img'=>$path);
            $modimg = $moduleMapper->Update($mid,$Midarr);
            if ($modimg) {
                echo "success";
            }
            else {
                echo "error";
            }
            exit();
        }
    }
}