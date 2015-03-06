<?php

namespace Application\Service\Navigation;

use Zend\Navigation\Service\AbstractNavigationFactory;

class FrontNavigationFactory extends AbstractNavigationFactory
{

    public function getName()
    {
        return 'front';
    }
}