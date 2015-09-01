<?php

namespace soullified\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class soullifiedUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}


}

