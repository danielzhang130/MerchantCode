<?php

namespace App\Commands;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseSampleCommand extends Command
{
    private const SUB_CATEGORY_MAP = [
        "Transport alternatif" => ["Transportation", "Alternative transportation"],
        "Restaurants" => ["Food", "Restaurants"],
        "Épiceries" => ["Food", "Groceries"],
        "Divertissement" => ["Leisure", null],
        "Voyage" => ["Leisure", null]
    ];
    protected static $defaultName = 'parse:sample';

    private const ARGUMENT_FILE = 'file';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Parse merchant codes from sample json array provided by desjardins')
            ->addArgument(self::ARGUMENT_FILE, InputArgument::REQUIRED);;
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $file = $input->getArgument(self::ARGUMENT_FILE);
        $handle = fopen($file, "r");
        $json = json_decode(fread($handle, filesize($file)), true);
        fclose($handle);

        $categories = [];

        foreach ($json as $key => $merchants) {
//            var_dump($key);
//            var_dump(sizeof($merchants));
            $category = self::SUB_CATEGORY_MAP[$key][0];
            $sub_category = self::SUB_CATEGORY_MAP[$key][1];

            if (!isset($categories[$category])) {
                $categories[$category] = [];
            }

            foreach ($merchants as $merchant) {
                $merchant_sub_category = $sub_category ?? $merchant['category'];

                if (!isset($categories[$category][$merchant_sub_category])) {
                    $categories[$category][$merchant_sub_category] = [];
                }
                $categories[$category][$merchant_sub_category][] = $merchant['label'];
            }
        }

        echo json_encode($categories, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return 0;
    }
}
