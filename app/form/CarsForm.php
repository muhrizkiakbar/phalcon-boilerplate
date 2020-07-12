<?php
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Numericality;

class CarsForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = [])
    {
        if (!isset($options["edit"])) {
            $element = new Text("id");

            $element->setLabel("Id");

            $this->add(
                $element
            );
        } else {
            $this->add(
                new Hidden("id")
            );
        }


        $type = new Text("type");

        $type->setLabel("Type");

        $type->setFilters(
            [
                "striptags",
                "string",
            ]
        );

        $type->addValidators(
            [
                new PresenceOf(
                    [
                        "message" => "Type is required",
                    ]
                )
            ]
        );
        $this->add($type);

        $brand = new Text("brand");

        $brand->setLabel("Brand");

        $brand->setFilters(
            [
                "striptags",
                "string",
            ]
        );
        $brand->addValidators(
            [
                new PresenceOf(
                    [
                        "message" => "Brand is required",
                    ]
                )
            ]
        );
        $this->add($brand);

        $name = new Text("name");

        $name->setLabel("Name");
        $name->setFilters(
            [
                "striptags",
                "string",
            ]
        );
        $name->addValidators(
            [
                new PresenceOf(
                    [
                        "message" => "Name is required",
                    ]
                )
            ]
        );

        $this->add($name);



        $type = new Select(
            "profilesId",
            ProductTypes::find(),
            [
                "using"      => [
                    "id",
                    "name",
                ],
                "useEmpty"   => true,
                "emptyText"  => "...",
                "emptyValue" => "",
            ]
        );

        $this->add($type);



        $wheels = new Text("wheels");

        $wheels->setLabel("Wheels");

        $wheels->setFilters(
            [
                "integer",
            ]
        );

        $wheels->addValidators(
            [
                new PresenceOf(
                    [
                        "message" => "Wheels is required",
                    ]
                ),
                new Numericality(
                    [
                        "message" => "Wheels is required",
                    ]
                ),
            ]
        );

        $this->add($wheels);
    }
}