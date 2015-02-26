<?php

namespace Administration\Controller;

use Application\Entity\Post;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Zend\Mvc\Controller\AbstractActionController;

class PostsController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $providers = $this->getEntityManager()->getRepository('Application\Entity\Post');
        return [
            'providers'         => $providers->findByDeleted(false),
            'flashMessages'     => $this->flashMessenger()->getMessages(),
        ];
    }

    public function addAction()
    {
        /** @var \Administration\Form\PostForm $form */
        $form = $this->getPostForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Post;
            $form->bind($post);
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $post->setCreated(date_create());
                $em = $this->getEntityManager();
                $em->persist($post);
                $em->flush();

                $this->flashMessenger()->addMessage('Your post was added');
                return $this->redirect()->toRoute('administration/posts');
            }
        }
        return [ 'form' => $form ];
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('administration/posts');
        }

        if (! $post = $this->getEntityManager()->getRepository('Application\Entity\Post')->findOneById($id)) {
            return $this->redirect()->toRoute('administration/posts');
        }

        /** @var \Administration\Form\PostForm $form */
        $form = $this->getPostForm();

        $form->bind($post);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getEntityManager()->flush();

                $this->flashMessenger()->addMessage(sprintf('Your post (id = %d) was updated', $id));
                return $this->redirect()->toRoute('administration/posts');
            }
        }

        return compact('id', 'form');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('administration/posts');
        }

        if (! $post = $this->getEntityManager()->getRepository('Application\Entity\Post')->findOneById($id)) {
            $this->flashMessenger()->addMessage(sprintf('The post with the id %d doesn\'t exist', $id));
            return $this->redirect()->toRoute('administration/posts');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id =  (int) $request->getPost('id');
                $em = $this->getEntityManager();
                $post = $em->getRepository('Application\Entity\Post')->findOneById($id);
                $post->setDeleted(true);
                $post->setUpdated(date_create());
                $em->flush();

                $this->flashMessenger()->addMessage(sprintf('Your post (id = %d) was deleted', $id));
                return $this->redirect()->toRoute('administration/posts');
            }
            return $this->redirect()->toRoute('administration/posts');
        }

        return compact('id', 'post');
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function getPostForm()
    {
        $form = $this->getServiceLocator()->get('FormElementManager')->get('Administration\Form\PostForm');
        return $form;
    }
}