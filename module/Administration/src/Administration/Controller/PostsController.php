<?php

namespace Administration\Controller;

use Application\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection;
use Zend\Filter\File\RenameUpload;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;

class PostsController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page') ? $this->params()->fromRoute('page') : 1;

        $rep = $this->getEntityManager()->getRepository('Application\Entity\Post');
        $posts = $rep->findByDeleted(false);
        $paginator = new Paginator(new Collection(new ArrayCollection($posts)));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(5);

        return [
            'posts'             => $paginator,
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
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            $form->setData($post);
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