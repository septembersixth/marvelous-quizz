<?php

namespace Administration\View\Helper;

use Application\Entity\Tag;
use Zend\View\Helper\AbstractHelper;

class TagType extends AbstractHelper
{
    public function __invoke($type)
    {
        switch($type) {

            case Tag::TYPE_ONE:
                return 'difficulty';

            case Tag::TYPE_TWO:
                return 'Type';
        }
    }
} 