<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
// require_once 'service/YNSWordRegistService.php';

class YNSWordRegistController extends BaseController
{

    public function indexAction()
    {
        if ($this->check_login() == true) {
            $err_msg = "";
            // if(isset($_SESSION['regist_msg'])){
            // 	if ($_SESSION ['regist_msg'] != ""){
            // 		$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
            // 		$_SESSION ['regist_msg'] = "";
            // 	}
            // }
            $this->form->search_page = 0;
            $this->form->search_page_row = 10;
            $this->form->search_page_order_column = 1;
            $this->form->search_page_order_dir = true;
            $this->form->name = "";
            $this->form->org_id = "";
            $this->form->org_no = "";
            // $service = new YNSWordRegistService($this->pdo);
            $this->setMenu();
            $this->smarty->assign('form', $this->form);
            $this->smarty->display('YNSWordRegist.html');
        } else {
            TransitionHelper::sendException(E002);
            return;
        }
    }
}
