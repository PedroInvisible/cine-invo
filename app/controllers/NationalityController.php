<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class NationalityController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for nationality
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Nationality', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $nationality = Nationality::find($parameters);
        if (count($nationality) == 0) {
            $this->flash->notice("The search did not find any nationality");

            $this->dispatcher->forward([
                "controller" => "nationality",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $nationality,
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
     * Edits a nationality
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $nationality = Nationality::findFirstByid($id);
            if (!$nationality) {
                $this->flash->error("nationality was not found");

                $this->dispatcher->forward([
                    'controller' => "nationality",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $nationality->id;

            $this->tag->setDefault("id", $nationality->id);
            $this->tag->setDefault("nationality", $nationality->nationality);
            
        }
    }

    /**
     * Creates a new nationality
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'index'
            ]);

            return;
        }

        $nationality = new Nationality();
        $nationality->id = $this->request->getPost("id");
        $nationality->nationality = $this->request->getPost("nationality");
        

        if (!$nationality->save()) {
            foreach ($nationality->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("nationality was created successfully");

        $this->dispatcher->forward([
            'controller' => "nationality",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a nationality edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $nationality = Nationality::findFirstByid($id);

        if (!$nationality) {
            $this->flash->error("nationality does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'index'
            ]);

            return;
        }

        $nationality->id = $this->request->getPost("id");
        $nationality->nationality = $this->request->getPost("nationality");
        

        if (!$nationality->save()) {

            foreach ($nationality->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'edit',
                'params' => [$nationality->id]
            ]);

            return;
        }

        $this->flash->success("nationality was updated successfully");

        $this->dispatcher->forward([
            'controller' => "nationality",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a nationality
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $nationality = Nationality::findFirstByid($id);
        if (!$nationality) {
            $this->flash->error("nationality was not found");

            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'index'
            ]);

            return;
        }

        if (!$nationality->delete()) {

            foreach ($nationality->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "nationality",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("nationality was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "nationality",
            'action' => "index"
        ]);
    }

}
