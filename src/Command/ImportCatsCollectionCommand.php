<?php

namespace App\Command;

use App\Services\CatmashHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCatsCollectionCommand extends Command
{
    protected static $defaultName = 'app:import-cats-collection';
    private $catmashHandler;

    /**
     * ImportCatsCollectionCommand constructor.
     * @param CatmashHandler $catmashHandler
     */
    public function __construct(CatmashHandler $catmashHandler)
    {
        $this->catmashHandler = $catmashHandler;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setDescription('Import new cats collection from external url');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $importation = $this->catmashHandler->importCatsFromExternalLibrary();
        if($importation["success"]) {
            $io->success(sprintf('New collection imported (%d inserted - %d updated)', $importation["inserted"], $importation["updated"]));
        } else {
            $io->error('New collection not imported');
        }


        return Command::SUCCESS;
    }
}
