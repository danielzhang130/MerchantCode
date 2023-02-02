<?php

namespace App\Commands;

use App\Utils\MerchantSearch;
use App\Utils\TreeTransformer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchMerchantCommand extends Command
{
    protected static $defaultName = 'search:merchant';

    private const ARGUMENT_KEYWORD = 'keyword';

    private MerchantSearch $merchantSearch;
    private TreeTransformer $treeTransformer;

    public function __construct(MerchantSearch $merchantSearch, TreeTransformer $treeTransformer)
    {
        parent::__construct();
        $this->merchantSearch = $merchantSearch;
        $this->treeTransformer = $treeTransformer;
    }

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Search merchant with provided keyword')
            ->addArgument(self::ARGUMENT_KEYWORD, InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->treeTransformer->toTree($this->merchantSearch->search($input->getArgument(self::ARGUMENT_KEYWORD)));
        return 0;
    }
}
