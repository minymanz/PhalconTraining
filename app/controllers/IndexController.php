<?php

namespace Application\Controllers;

use Application\Core\User;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Model;

class IndexController extends ControllerBase {
	public function beforeExecuteRoute($dispatcher)
    {
        parent::beforeExecuteRoute($dispatcher); // TODO: Change the autogenerated stub
    }

    public function helloWorldAction() {
		$this->view->disable();
		echo "Hello World";
    }
    
    public function formAction() {
        
        $this->view->getContent();
    }

    public function updateformAction() {
        //this->view->disable();
        $custid = $this->dispatcher->getParam('custid');
        $query = "SELECT CUSTID AS customerID, CUSTNAME AS customerName, CUSTEMAIL AS customerEmail, CUSTPHONE as customerPhone  FROM CUSTOMER WHERE CUSTID='".$custid."'";
        $data = $this->db->query($query);
        $data->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        $result=$data->fetchAll();

        $this->view->setVar('update', $result);
    }
    
    public function createAction() {
        $this->view->disable();

        $custid = $this->request->getPost('custid');
        $custname = $this->request->getPost('custname');
        $custemail = $this->request->getPost('custemail');
        $custphone = $this->request->getPost('custphone');

        try
        {
            $query = "INSERT INTO CUSTOMER (CUSTID, CUSTNAME, CUSTEMAIL, CUSTPHONE) VALUES ('".$custid."','".$custname."','".$custemail."','".$custphone."')";
            $this->db->query($query);
            $this->response->redirect('/read');
        }
        catch(\PDOException $e){
               $this->response->redirect('/form');  
        }
		
    }
    
    public function readAction()
    {

        //$this->view->disable();
        $query = "SELECT CUSTID AS customerID, CUSTNAME AS customerName, CUSTEMAIL AS customerEmail, CUSTPHONE as customerPhone FROM CUSTOMER";
        $data = $this->db->query($query);
        $data->setFetchMode(\Phalcon\Db::FETCH_ASSOC);
        $result=$data->fetchAll();

        $this->view->setVar('read', $result);
    }

    public function updateAction() {
        $this->view->disable();

        $custid = $this->request->getPost('custid');
        $custname = $this->request->getPost('custname');
        $custemail = $this->request->getPost('custemail');
        $custphone = $this->request->getPost('custphone');

		$query = "UPDATE CUSTOMER SET CUSTNAME='".$custname."',CUSTEMAIL='".$custemail."',CUSTPHONE='".$custphone."' WHERE CUSTID='".$custid."'";
        $this->db->query($query);
        $this->response->redirect('/read');
    }

    public function deleteAction() {
        $this->view->disable();
        $custid = $this->dispatcher->getParam('custid');
		$query = "DELETE FROM CUSTOMER WHERE CUSTID='".$custid."'";
        $this->db->query($query);
        $this->response->redirect('/read');
    }
}

