<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class DirectoresController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for directores
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Directores', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $directores = Directores::find($parameters);
        if (count($directores) == 0) {
            $this->flash->notice("The search did not find any directores");

            $this->dispatcher->forward([
                "controller" => "directores",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $directores,
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
     * Edits a directore
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $directore = Directores::findFirstByid($id);
            if (!$directore) {
                $this->flash->error("directore was not found");

                $this->dispatcher->forward([
                    'controller' => "directores",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $directore->id;

            $this->tag->setDefault("id", $directore->id);
            $this->tag->setDefault("num_id", $directore->num_id);
            $this->tag->setDefault("name", $directore->name);
            $this->tag->setDefault("lastname", $directore->lastname);
            $this->tag->setDefault("id_nationality", $directore->id_nationality);
            $this->tag->setDefault("date_birth", $directore->date_birth);
            
        }
    }

    /**
     * Creates a new directore
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'index'
            ]);

            return;
        }

        $directore = new Directores();
        $directore->id = $this->request->getPost("id");
        $directore->numId = $this->request->getPost("num_id");
        $directore->name = $this->request->getPost("name");
        $directore->lastname = $this->request->getPost("lastname");
        $directore->idNationality = $this->request->getPost("id_nationality");
        $directore->dateBirth = $this->request->getPost("date_birth");
        

        if (!$directore->save()) {
            foreach ($directore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("directore was created successfully");

        $this->dispatcher->forward([
            'controller' => "directores",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a directore edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $directore = Directores::findFirstByid($id);

        if (!$directore) {
            $this->flash->error("directore does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'index'
            ]);

            return;
        }

        $directore->id = $this->request->getPost("id");
        $directore->numId = $this->request->getPost("num_id");
        $directore->name = $this->request->getPost("name");
        $directore->lastname = $this->request->getPost("lastname");
        $directore->idNationality = $this->request->getPost("id_nationality");
        $directore->dateBirth = $this->request->getPost("date_birth");
        

        if (!$directore->save()) {

            foreach ($directore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'edit',
                'params' => [$directore->id]
            ]);

            return;
        }

        $this->flash->success("directore was updated successfully");

        $this->dispatcher->forward([
            'controller' => "directores",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a directore
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $directore = Directores::findFirstByid($id);
        if (!$directore) {
            $this->flash->error("directore was not found");

            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'index'
            ]);

            return;
        }

        if (!$directore->delete()) {

            foreach ($directore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "directores",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("directore was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "directores",
            'action' => "index"
        ]);
    }

}
