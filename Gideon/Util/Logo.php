<?php

namespace Gideon\Util;

use Symfony\Component\Console\Output\OutputInterface;

class Logo
{
    public static function get()
    {
        return [
            '<info>',
            ' ______ _____ ______  _______  _____  __   _',
            '|  ____   |   |     \ |______ |     | | \  |',
            '|_____| __|__ |_____/ |______ |_____| |  \_|',
            '</info>',
            '',
        ];
    }

    public static function write(OutputInterface $output)
    {
        $output->writeln(static::get());
    }
}
