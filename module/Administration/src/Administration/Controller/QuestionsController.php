<?php

namespace Administration\Controller;

use Application\Entity\Question;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

class QuestionsController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $testId = $this->params('testId');
        $questions = $this->getEntityManager()
            ->getRepository('Application\Entity\Question')
            ->findBy(['deleted' => false, 'test' => $testId]);

        return compact('questions', 'testId');
    }

    public function addAction()
    {
        $testId = $this->params('testId');
        $test = $this->getEntityManager()->getRepository('Application\Entity\Test')->findOneById($testId);
        if (! $test) {
            return $this->redirect()->toRoute('administration/tests');
        }

        $form = $this->getQuestionForm();

        if (($prg = $this->prg()) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('form', 'testId');
        }

        $question = (new Question)
            ->setCreated(date_create())
            ->setTest($test)
        ;
        $form->bind($question);
        $form->setData($prg);
        if ($form->isValid()) {
            $em = $this->getEntityManager();
            $em->persist($question);
            $em->flush();
            $this->flashMessenger()->addMessage('question added');
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }

        return compact('form', 'testId');
    }

    public function deleteAction()
    {
        $questionId = (int) $this->params()->fromRoute('questionId', 0);
        $testId = (int) $this->params()->fromRoute('testId', 0);
        if (! $questionId) {
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }

        if (! $question = $this->getEntityManager()->getRepository('Application\Entity\Question')->findOneById($questionId)) {
            $this->flashMessenger()->addMessage(sprintf('The question with the id %d doesn\'t exist', $id));
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id =  (int) $request->getPost('id');
                $em = $this->getEntityManager();
                $question = $em->getRepository('Application\Entity\Question')->findOneById($id);
                $question->setDeleted(true);
                $em->flush();

                $this->flashMessenger()->addMessage(sprintf('Your question (id = %d) was deleted', $id));
                return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
            }
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }
        return compact('testId', 'questionId', 'question');
    }

    public function editAction()
    {
        $form = $this->getQuestionForm();
        $questionId = (int) $this->params()->fromRoute('questionId', 0);
        $testId = (int) $this->params()->fromRoute('testId', 0);

        if (! $question = $this->getEntityManager()->getRepository('Application\Entity\Question')->findOneById($questionId)) {
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }

        $form->bind($question);
        if (($prg = $this->prg()) instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return compact('testId', 'questionId', 'form');
        }

        $form->setData($prg);

        if ($form->isValid()) {
            $this->getEntityManager()->flush();
            $this->flashMessenger()->addMessage(sprintf('question (id = %d) was updated', $questionId));
            return $this->redirect()->toRoute('administration/questions', ['testId' => $testId]);
        }

        return compact('testId', 'questionId', 'question');

    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    public function getQuestionForm()
    {
        return $this->getServiceLocator()->get('formElementManager')->get('Administration/Form/QuestionForm');
    }
} 