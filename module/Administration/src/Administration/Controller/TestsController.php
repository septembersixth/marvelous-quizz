<?php

namespace Administration\Controller;

use Application\Entity\Test;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;

class TestsController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page') ? $this->params()->fromRoute('page') : 1;
        
        $tests = $this->getEntityManager()->getRepository('Application\Entity\Test')->findByDeleted(false);
        $paginator = new Paginator(new Collection(new ArrayCollection($tests)));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(20);
        return [
            'tests' => $paginator,
        ];
    }

    public function addbisAction()
    {
        /** @var \Administration\Form\TestForm $form */
        $form = $this->getTestForm();

        if (($prg = $this->fileprg($form)) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('form');
        }

        $test = (new Test)
            ->setCreated(date_create())
            ->setHash(md5(uniqid()))
        ;
        $form->bind($test);
        $form->setData($prg);
        if ($form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($test);
            $em->flush();
            $this->flashMessenger()->addMessage('test added');
            return $this->redirect()->toRoute('administration/tests');
        }
        else {
            // Form not valid, but file uploads might be valid and uploaded
            if (empty($prg['image']['error']) && !empty($prg['image']['tmp_name'])) {
                $form->get('image')->setValue($prg['image']['tmp_name']);
            }
        }
        return compact('form');
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('formElementManager')->get('Administration\Form\CreateTestForm');
        if (($prg = $this->fileprg($form)) instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('form');
        }

        $test = (new Test)
            ->setHash(md5(uniqid()))
        ;

        $form->bind($test);
        $form->setData($prg);

        if ($form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($test);
            $em->flush();
            $this->flashMessenger()->addMessage('test added');
            return $this->redirect()->toRoute('administration/tests');
        } else {
            if (empty($prg['test']['image']['error']) && !empty($prg['test']['image']['tmp_name'])) {
                $test->setImage($prg['test']['image']);
                $form->get('test')->get('image')->setValue($test->getImage());
            }
        }

        return compact('form');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $test = $this->getEntityManager()->getRepository('Application\Entity\Test')->findOneById($id)) {
            return $this->redirect()->toRoute('administration/tests');
        }

        $form = $this->getServiceLocator()->get('formElementManager')->get('Administration\Form\CreateTestForm');
        $form->bind($test);

        if (($prg = $this->fileprg($form)) instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return [
                'form'      => $form,
                'testId'    => $test->getId(),
            ];
        }

//        var_dump($prg, $prg['test']['questions'][0]['options']);die;
        $form->setData($prg);
        if ($form->isValid()) {
            $em = $this->getEntityManager();
            $em->flush();
            $this->flashMessenger()->addMessage('test updated');
            return $this->redirect()->toRoute('administration/tests');
        } else {
            if (empty($prg['test']['image']['error']) && !empty($prg['test']['image']['tmp_name'])) {
                $test->setImage($prg['test']['image']);
                $form->get('test')->get('image')->setValue($test->getImage());
            }
        }
        return [
            'form'      => $form,
            'testId'    => $test->getId(),
        ];
    }

    /*
    public function editAction()
    {
        $form = $this->getTestForm();
        $id = (int) $this->params()->fromRoute('id', 0);

        if (! $test = $this->getEntityManager()->getRepository('Application\Entity\Test')->findOneById($id)) {
            return $this->redirect()->toRoute('administration/tests');
        }

        $form->bind($test);

        if (($prg = $this->fileprg($form)) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('id', 'form');
        }

        if ($form->isValid()) {
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage(sprintf('test (id = %d) was updated', $id));
            return $this->redirect()->toRoute('administration/tests');
        }
        else {
            if (empty($prg['image']['error'])) {
                $test->setImage($prg['image']);
                $this->getEntityManager()->flush();
                $form->get('image')->setValue($test->getImage());
            }
        }

        return compact('form');
    }
    */

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (! $id) {
            return $this->redirect()->toRoute('administration/tests');
        }

        if (! $test = $this->getEntityManager()->getRepository('Application\Entity\Test')->findOneById($id)) {
            $this->flashMessenger()->addMessage(sprintf('The test with the id %d doesn\'t exist', $id));
            return $this->redirect()->toRoute('administration/tests');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id =  (int) $request->getPost('id');
                $em = $this->getEntityManager();
                $test = $em->getRepository('Application\Entity\Test')->findOneById($id);
                $test->setDeleted(true);
                $em->flush();

                $this->flashMessenger()->addMessage(sprintf('Your test (id = %d) was deleted', $id));
                return $this->redirect()->toRoute('administration/tests');
            }
            return $this->redirect()->toRoute('administration/tests');
        }

        return compact('id', 'test');
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function getTestForm()
    {
        return $this->getServiceLocator()->get('FormElementManager')->get('Administration\Form\TestForm');
    }
} 