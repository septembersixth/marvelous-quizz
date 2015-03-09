<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Zend\Paginator\Paginator;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineModule\Paginator\Adapter\Collection;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $em;

    public function indexAction()
    {
        $page = $this->params()->fromRoute('page') ? $this->params()->fromRoute('page') : 1;

        $repo = $this->getEntityManager()->getRepository('Application\Entity\Post');
        $posts = $repo->findByDeleted(false);
        $paginator = new Paginator(new Collection(new ArrayCollection($posts)));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(5);

        return ['posts' => $paginator];
    }

    public function postAction()
    {
        $url = $this->params()->fromRoute('url');

        $repo = $this->getEntityManager()->getRepository('Application\Entity\Post');
        $post = $repo->findOneByUrl($url);
        if (! $post) {
            return $this->redirect()->toRoute('home');
        }
        return compact('post');
    }

    public function tagAction()
    {
        $page = $this->params()->fromRoute('page') ? $this->params()->fromRoute('page') : 1;
        $tagName = $this->params()->fromRoute('tagName') ? $this->params()->fromRoute('tagName') : null;
        $repo = $this->getEntityManager()->getRepository('Application\Entity\Post');

        $posts = $repo->getPostsByTagName($tagName);

        $paginator = new Paginator(new Collection(new ArrayCollection($posts)));
        $paginator
            ->setCurrentPageNumber($page)
            ->setItemCountPerPage(5);

        return (new ViewModel)
            ->setTemplate('application/index/index.phtml')
            ->setVariable('posts', $paginator)
        ;
    }

    public function getEntityManager()
    {
        if (! $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
}
