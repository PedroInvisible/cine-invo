<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class ActoresForm extends Form
{
    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array())
    {
        if (!isset($options['edit'])) {
            $element = new Text("id");
            $this->add($element->setLabel("Id"));
        } else {
            $this->add(new Hidden("id"));
        }

        $num_id = new Text("num_id");
        $num_id->setLabel("Numero de Identicacion");
        $num_id->setFilters(['int']);
        $num_id->addValidators([
            new PresenceOf([
                'message' => 'El numero de Identificacion es un campo Requerido'
            ])
        ]);
        $this->add($num_id);

        $lastname = new Text("lastname");
        $lastname->setLabel("Apellido");
        $lastname->setFilters(['striptags', 'string']);
        $lastname->addValidators([
            new PresenceOf([
                'message' => 'El Apellido es un campo Requerido'
            ])
        ]);
        $this->add($lastname);

        $id_nationality = new Select('id', Nationality::find(), [
            'using'      => ['id', 'nationality'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $id_nationality->setLabel('Nacionalidad');
        $this->add($id_nationality);

        $price = new Text("price");
        $price->setLabel("Price");
        $price->setFilters(['float']);
        $price->addValidators([
            new PresenceOf([
                'message' => 'Price is required'
            ]),
            new Numericality([
                'message' => 'Price is required'
            ])
        ]);
        $this->add($price);
    }
}
