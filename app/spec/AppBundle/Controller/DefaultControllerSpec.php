<?php

namespace spec\AppBundle\Controller;

use PhpSpec\ObjectBehavior;
use AppBundle\Controller\DefaultController;

class DefaultControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DefaultController::class);
    }
}
