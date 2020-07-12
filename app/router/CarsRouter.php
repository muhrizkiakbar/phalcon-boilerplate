<?php


namespace Application\Router;

use Phalcon\Mvc\Router\Group;

class CarsRouter extends Group
{
    public function initialize()
    {
        $this->setPaths([
            'namespaces' => 'Application\\Controllers',
            'controller'=>'cars'
        ]);

        $this->addGet(
            '/cars',
            [
                'action' => 'index'
            ]
        );
        $this->addPost(
            '/cars',
            [
                'action' => 'create'
            ]
        );

        $this->addPut(
            '/cars/{id}',
            [
                'action' => 'update',
                'id'     => 1
            ]
        );


        $this->addDelete(
            '/cars/{id}',
            [
                'action' => 'delete',
                'id'     => 1
            ]
        );
    }
}