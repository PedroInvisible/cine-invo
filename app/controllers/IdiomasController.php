<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class IdiomasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for idiomas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Idiomas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id";

        $idiomas = Idiomas::find($parameters);
        if (count($idiomas) == 0) {
            $this->flash->notice("The search did not find any idiomas");

            $this->dispatcher->forward([
                "controller" => "idiomas",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $idiomas,
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
     * Edits a idioma
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {

            $idioma = Idiomas::findFirstByid($id);
            if (!$idioma) {
                $this->flash->error("idioma was not found");

                $this->dispatcher->forward([
                    'controller' => "idiomas",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $idioma->id;

            $this->tag->setDefault("id", $idioma->id);
            $this->tag->setDefault("idioma", $idioma->idioma);
            
        }
    }

    /**
     * Creates a new idioma
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'index'
            ]);

            return;
        }

        $idioma = new Idiomas();
        $idioma->id = $this->request->getPost("id");
        $idioma->idioma = $this->request->getPost("idioma");
        

        if (!$idioma->save()) {
            foreach ($idioma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("idioma was created successfully");

        $this->dispatcher->forward([
            'controller' => "idiomas",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a idioma edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $idioma = Idiomas::findFirstByid($id);

        if (!$idioma) {
            $this->flash->error("idioma does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'index'
            ]);

            return;
        }

        $idioma->id = $this->request->getPost("id");
        $idioma->idioma = $this->request->getPost("idioma");
        

        if (!$idioma->save()) {

            foreach ($idioma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'edit',
                'params' => [$idioma->id]
            ]);

            return;
        }

        $this->flash->success("idioma was updated successfully");

        $this->dispatcher->forward([
            'controller' => "idiomas",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a idioma
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $idioma = Idiomas::findFirstByid($id);
        if (!$idioma) {
            $this->flash->error("idioma was not found");

            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'index'
            ]);

            return;
        }

        if (!$idioma->delete()) {

            foreach ($idioma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "idiomas",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("idioma was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "idiomas",
            'action' => "index"
        ]);
    }

}
