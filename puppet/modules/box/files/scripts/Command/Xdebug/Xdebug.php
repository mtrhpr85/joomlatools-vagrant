<?php
namespace Command\Xdebug;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Xdebug extends Command
{
    protected $_ini_files = array('xdebug.ini', 'zzz_xdebug.ini');

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (\Helper\System::getEngine() === 'hhvm')
        {
            $output->writeln("<comment>[warning]</comment> Engine is set to <info>hhvm</info>. No changes will be made.");
            $output->writeln("<comment>[warning]</comment> Switch back to the Zend engine if you want to use Xdebug");

            exit();
        }
    }

    protected function _getConfigFiles($basenames = array())
    {
        $inis  = array();
        $paths = array('/etc/php5/mods-available/');

        $installs = glob('/opt/php/php-*/etc/conf.d', GLOB_ONLYDIR);
        $installs = array_unique(array_filter($installs));

        $paths = array_merge($paths, $installs);

        foreach($paths as $path)
        {
            foreach($basenames as $basename)
            {
                $fullpath = $path . '/' . $basename;
                if(file_exists($fullpath)) {
                    $inis[] = $fullpath;
                }
            }
        }

        return $inis;
    }
}