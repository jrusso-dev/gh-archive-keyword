<?php


namespace App\UserInterface\Command\Data;

use App\UserInterface\Presenter\Data\ImportFromGhArchivePresenterCli;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yousign\Domain\Data\Request\ImportFromGhArchiveRequest;
use Yousign\Domain\Data\UseCase\ImportFromGhArchive;

/**
 * Class ImportCommitsFromGhArchive
 * @package App\UserInterface\Command\Data
 */
class ImportCommitsFromGhArchive extends Command
{
    /**
     * @var ImportFromGhArchive
     */
    private ImportFromGhArchive $useCase;

    protected static $defaultName = 'commit:import';

    /**
     * ImportCommitsFromGhArchive constructor.
     * @param ImportFromGhArchive $useCase
     */
    public function __construct(ImportFromGhArchive $useCase)
    {
        $this->useCase = $useCase;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Imports commits from GH Archive Website')
            ->addArgument('year', InputArgument::REQUIRED, 'Year of import')
            ->addArgument('month', InputArgument::REQUIRED, 'Month of import')
            ->addArgument('day', InputArgument::REQUIRED, 'Day of import')
            ->addArgument('replace', InputArgument::OPTIONAL, 'Replace data ?');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = time();
        $year = (int) $input->getArgument('year');
        $month = (int) $input->getArgument('month');
        $day = (int) $input->getArgument('day');
        $replaceData = $input->getArgument('replace') === 'yes';
        $request = ImportFromGhArchiveRequest::create($year, $month, $day, $replaceData);
        $presenter = new ImportFromGhArchivePresenterCli();
        $this->useCase->execute($request, $presenter);
        $response = $presenter->getResponse();
        $finish = time();
        $elapsed = $finish - $start;
        $output->writeln("<info>$response ($elapsed s)</info>");
        $output->writeln("<info></info>");
        return 0;
    }
}
