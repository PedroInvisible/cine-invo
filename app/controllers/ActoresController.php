<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ActoresController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for actores
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Actores', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $actores = Actores::find($parameters);
        if (count($actores) == 0) {
            $this->flash->notice("The search did not find any actores");

            $this->dispatcher->forward([
                "controller" => "actores",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $actores,
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
     * Edits a actore
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $actore = Actores::findFirstByid($id);
            if (!$actore) {
                $this->flash->error("actore was not found");

                $this->dispatcher->forward([
                    'controller' => "actores",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $actore->id;

            $this->tag->setDefault("id", $actore->id);
            $this->tag->setDefault("num_id", $actore->num_id);
            $this->tag->setDefault("name", $actore->name);
            $this->tag->setDefault("lastname", $actore->lastname);
            $this->tag->setDefault("id_nationality", $actore->id_nationality);
            $this->tag->setDefault("date_birth", $actore->date_birth);
            
        }
    }

    /**
     * Creates a new actore
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'index'
            ]);

            return;
        }

        $actore = new Actores();
        $actore->id = $this->request->getPost("id");
        $actore->numId = $this->request->getPost("num_id");
        $actore->name = $this->request->getPost("name");
        $actore->lastname = $this->request->getPost("lastname");
        $actore->idNationality = $this->request->getPost("id_nationality");
        $actore->dateBirth = $this->request->getPost("date_birth");
        

        if (!$actore->save()) {
            foreach ($actore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("actore was created successfully");

        $this->dispatcher->forward([
            'controller' => "actores",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a actore edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $actore = Actores::findFirstByid($id);

        if (!$actore) {
            $this->flash->error("actore does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'index'
            ]);

            return;
        }

        $actore->id = $this->request->getPost("id");
        $actore->numId = $this->request->getPost("num_id");
        $actore->name = $this->request->getPost("name");
        $actore->lastname = $this->request->getPost("lastname");
        $actore->idNationality = $this->request->getPost("id_nationality");
        $actore->dateBirth = $this->request->getPost("date_birth");
        

        if (!$actore->save()) {

            foreach ($actore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'edit',
                'params' => [$actore->id]
            ]);

            return;
        }

        $this->flash->success("actore was updated successfully");

        $this->dispatcher->forward([
            'controller' => "actores",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a actore
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $actore = Actores::findFirstByid($id);
        if (!$actore) {
            $this->flash->error("actore was not found");

            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'index'
            ]);

            return;
        }

        if (!$actore->delete()) {

            foreach ($actore->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "actores",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("actore was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "actores",
            'action' => "index"
        ]);
    }

}
