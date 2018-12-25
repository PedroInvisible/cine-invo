<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class GenerosController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for generos
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Generos', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $generos = Generos::find($parameters);
        if (count($generos) == 0) {
            $this->flash->notice("The search did not find any generos");

            $this->dispatcher->forward([
                "controller" => "generos",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $generos,
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
     * Edits a genero
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $genero = Generos::findFirstByid($id);
            if (!$genero) {
                $this->flash->error("genero was not found");

                $this->dispatcher->forward([
                    'controller' => "generos",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $genero->id;

            $this->tag->setDefault("id", $genero->id);
            $this->tag->setDefault("genero", $genero->genero);
            
        }
    }

    /**
     * Creates a new genero
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'index'
            ]);

            return;
        }

        $genero = new Generos();
        $genero->id = $this->request->getPost("id");
        $genero->genero = $this->request->getPost("genero");
        

        if (!$genero->save()) {
            foreach ($genero->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("genero was created successfully");

        $this->dispatcher->forward([
            'controller' => "generos",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a genero edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $genero = Generos::findFirstByid($id);

        if (!$genero) {
            $this->flash->error("genero does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'index'
            ]);

            return;
        }

        $genero->id = $this->request->getPost("id");
        $genero->genero = $this->request->getPost("genero");
        

        if (!$genero->save()) {

            foreach ($genero->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'edit',
                'params' => [$genero->id]
            ]);

            return;
        }

        $this->flash->success("genero was updated successfully");

        $this->dispatcher->forward([
            'controller' => "generos",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a genero
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $genero = Generos::findFirstByid($id);
        if (!$genero) {
            $this->flash->error("genero was not found");

            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'index'
            ]);

            return;
        }

        if (!$genero->delete()) {

            foreach ($genero->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "generos",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("genero was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "generos",
            'action' => "index"
        ]);
    }

}
