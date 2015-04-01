<?php

namespace Application\Form;

use Zend\Form\View\Helper\Form;

class Subscribe extends Form
{
    public function init($name = 'subscribe')
    {
        $this->setName($name);

        $this
            ->add([
                'name'  => 'id',
                'type'  => 'Hidden',
            ])
        ;
    }
} 