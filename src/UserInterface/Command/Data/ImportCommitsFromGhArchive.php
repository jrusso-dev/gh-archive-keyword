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
            ->addArgument('year', InputArgument::REQUIRED, 'Year ?')
            ->addArgument('month', InputArgument::REQUIRED, 'Month ?')
            ->addArgument('day', InputArgument::REQUIRED, 'Day ?');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = (int) $input->getArgument('year');
        $month = (int) $input->getArgument('month');
        $day = (int) $input->getArgument('day');
        $request = ImportFromGhArchiveRequest::create($year, $month, $day);
        $presenter = new ImportFromGhArchivePresenterCli();
        $this->useCase->execute($request, $presenter);
        $response = $presenter->getResponse();
        $output->writeln("<info>$response</info>");
        return 0;
    }
}
