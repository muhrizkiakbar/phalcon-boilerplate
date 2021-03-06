<?php

namespace Application\Controllers;

use Application\Models\Cars;
use Phalcon\Http\Response;
use Application\Core\User;
use Phalcon\Mvc\View;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CarsController extends ControllerBase {
	public function beforeExecuteRoute($dispatcher)
    {
        // Add some local CSS resources
        $this->assets->addCss('/assets/bower_components/bootstrap/dist/css/bootstrap.min.css');
        $this->assets->addCss('/assets/bower_components/font-awesome/css/font-awesome.min.css');
        $this->assets->addCss('/assets/bower_components/Ionicons/css/ionicons.min.css');
        $this->assets->addCss('/assets/css/AdminLTE.min.css');
        $this->assets->addCss('/assets/css/skins/_all-skins.min.css');

        // And some local JavaScript resources
        $this->assets->addJs('/assets/bower_components/jquery/dist/jquery.min.js');
        $this->assets->addJs('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js');
        $this->assets->addJs('/assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js');
        $this->assets->addJs('/assets/bower_components/fastclick/lib/fastclick.js');
        $this->assets->addJs('/assets/js/adminlte.min.js');


        parent::beforeExecuteRoute($dispatcher); // TODO: Change the autogenerated stub
    }

    public function indexAction()
    {
        $numberPage =  (int) $_GET['page'];

        if ($this->request->isPost())
        {

            if ( ($this->request->getPost('brand') == "" ) && ($this->request->getPost('type') == "" ) && ( $this->request->getPost('name') == "" ) && ( $this->request->getPost('wheels') == "" ) )
            {
                $this->redirect('/');
            }
        }

        $this->view->cars= $cars = Cars::find();

        $paginator = new Paginator( [
			'data'  => $cars,
			'limit' => 10,
			'page'  => $numberPage
		] );

		$this->view->page = $paginator->getPaginate();
    }

    public function createAction() {

        $car = new Cars();
        $car->brand = $this->request->getPost('brand');
        $car->type = $this->request->getPost('type');
        $car->name = $this->request->getPost('name');
        $car->wheels = $this->request->getPost('wheels');
        if (! $car->save())
        {
            foreach ($car->getMessages() as $message )
            {
                $this->flash->error($message);
            }
            
            $this->dispatcher->forward([
                'controller' => 'cars',
                'action'     => 'index'
            ]);

            return;
        }

        $this->flash->success('Car was created sucessfully');
        $_POST = array();

        $this->dispatcher->forward([
            'controller' => 'cars',
            'action'     => 'index'
        ]);


    }
    
    public function updateAction($id)
    {
        $id = $this->dispatcher->getParam('id');

        $this->view->disable();

        $car = Cars::findFirstByid($id);
        
        if ( ! $car ) {
			return sendResponse(404,'Not Found',"Sorry, the data doesn't exist");
		}

        $car->brand = $this->request->getPut('brand');
        $car->name = $this->request->getPut('name');
        $car->type = $this->request->getPut('type');
        $car->wheels = $this->request->getPut('wheels');
        
        if ( ! $car->save() ) {
            $datamessage["error"]= [];
            foreach ($car->getMessages() as $message )
            {
                array_push($datamessage["error"],$message->getMessage());   
            }

			return sendResponse(500,'Not Modified',json_encode($datamessage));
		}

        return json_encode([$car]);
    }

    public function deleteAction($id)
    {
        $id = $this->dispatcher->getParam('id');

        $car = Cars::findFirstByid($id);
        
        if ( ! $car ) {
			return sendResponse(404,'Not Found',"Sorry, the data doesn't exist");
        }
        
        if ( ! $car->delete() ) {
            $datamessage["error"]= [];
            foreach ($car->getMessages() as $message )
            {
                array_push($datamessage["error"],$message->getMessage());   
            }

			return sendResponse(500,'Not Modified',json_encode($datamessage));
		}

        return json_encode([$car]);
    }


    protected function sendResponse($code,$codemessage,$content)
    {
        $response = new Response();
        $this->response->setContentType('application/json', 'UTF-8');
        $response->setStatusCode($code, $codemessage);
        $response->setContent($content);
        return $response->send();
    }
}

