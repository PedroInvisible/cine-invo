<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeliculasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for peliculas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peliculas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $peliculas = Peliculas::find($parameters);
        if (count($peliculas) == 0) {
            $this->flash->notice("The search did not find any peliculas");

            $this->dispatcher->forward([
                "controller" => "peliculas",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $peliculas,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a pelicula
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $pelicula = Peliculas::findFirstByid($id);
            if (!$pelicula) {
                $this->flash->error("pelicula was not found");

                $this->dispatcher->forward([
                    'controller' => "peliculas",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $pelicula->id;

            $this->tag->setDefault("id", $pelicula->id);
            $this->tag->setDefault("nombre", $pelicula->nombre);
            $this->tag->setDefault("id_genero", $pelicula->id_genero);
            $this->tag->setDefault("year", $pelicula->year);
            $this->tag->setDefault("id_idioma", $pelicula->id_idioma);
            
        }
    }

    /**
     * Creates a new pelicula
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        $pelicula = new Peliculas();
        $pelicula->id = $this->request->getPost("id");
        $pelicula->nombre = $this->request->getPost("nombre");
        $pelicula->idGenero = $this->request->getPost("id_genero");
        $pelicula->year = $this->request->getPost("year");
        $pelicula->idIdioma = $this->request->getPost("id_idioma");
        

        if (!$pelicula->save()) {
            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("pelicula was created successfully");

        $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a pelicula edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $pelicula = Peliculas::findFirstByid($id);

        if (!$pelicula) {
            $this->flash->error("pelicula does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        $pelicula->id = $this->request->getPost("id");
        $pelicula->nombre = $this->request->getPost("nombre");
        $pelicula->idGenero = $this->request->getPost("id_genero");
        $pelicula->year = $this->request->getPost("year");
        $pelicula->idIdioma = $this->request->getPost("id_idioma");
        

        if (!$pelicula->save()) {

            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'edit',
                'params' => [$pelicula->id]
            ]);

            return;
        }

        $this->flash->success("pelicula was updated successfully");

        $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a pelicula
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $pelicula = Peliculas::findFirstByid($id);
        if (!$pelicula) {
            $this->flash->error("pelicula was not found");

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        if (!$pelicula->delete()) {

            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("pelicula was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => "index"
        ]);
    }

}
