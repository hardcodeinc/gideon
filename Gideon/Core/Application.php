<?php

namespace Gideon\Core;

use Gideon\Util\Logo;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('Gideon', '0.0.1');
    }

    public function getHelp()
    {
        return implode(Logo::get(), PHP_EOL) . parent::getHelp();
    }
}
