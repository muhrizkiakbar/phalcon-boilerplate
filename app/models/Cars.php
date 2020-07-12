<?php

namespace Application\Models;
use InvalidArgumentException;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

use Phalcon\Mvc\Model;


class Cars extends Model {

    public function initialize()
    {
        $this->setSource('cars');
    }

    public function notSaved()
    {
        $this->_errorMessages = array();

        $validator = new Validation();

        $validator->add(
            'type',
            new PresenceOf(
                [
                    "message" => "Type is required.",
                ]
            )
        );

        $validator->add(
            'name',
            new PresenceOf(
                [
                    "message" => "Name is required.",
                ]
            )
        );

        $validator->add(
            'brand',
            new PresenceOf(
                [
                    "message" => "Brand is required.",
                ]
            )
        );


        $validator->add(
            'wheels',
            new PresenceOf(
                [
                    "message" => "Wheels is required.",
                ]
                )
        );

        $validator->add(
            'wheels',
            new Numericality(
                [
                    "message" => "Wheels is numeric.",
                ]
                )
        );

        return $this->validate($validator);
    }

    protected $id;
    protected $name;
    protected $brand;
    protected $type;
    protected $wheels;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name=$name;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setBrand($brand)
    {
        $this->brand=$brand;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type=$type;
    }

    public function getWheels()
    {
        return $this->wheels;
    }

    public function setWheels($wheels)
    {
        $this->wheels=$wheels;
    }
}