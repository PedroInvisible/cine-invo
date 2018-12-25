<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Numericality;

class PeliculasForm extends Form
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

        $name = new Text("nombre");
        $name->setLabel("Nombre");
        $name->setFilters(['striptags', 'string']);
        $name->addValidators([
            new PresenceOf([
                'message' => 'El Nombre es Requerido'
            ])
        ]);
        $this->add($name);

        $genero = new Select('id_genero', Generos::find(), [
            'using'      => ['id_genero', 'genero'],
            'useEmpty'   => true,
            'emptyText'  => '...',
            'emptyValue' => ''
        ]);
        $genero->setLabel('Genero de Pelicula');
        $this->add($genero);

        $year = new Text("Año");
        $year->setLabel("Año");
        $year->setFilters(['date']);
        $year->addValidators([
            new PresenceOf([
                'message' => 'Por favor ingrese el Año'
            ])
        ]);
        $this->add($year);
    }
}
