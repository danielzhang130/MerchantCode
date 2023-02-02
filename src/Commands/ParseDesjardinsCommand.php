<?php

namespace App\Commands;

use App\Model\Entry;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseDesjardinsCommand extends Command
{
    protected static $defaultName = 'parse:desjardins';

    private const ARGUMENT_FILE = 'file';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Parse merchant codes from desjardins transaction json array')
            ->addArgument(self::ARGUMENT_FILE, InputArgument::REQUIRED);
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

        $entries = [];

        foreach ($json as $item) {
            if (isset($item['categorieParentTransaction'])) {
                if (!isset($item['categorieTransaction'])) {
                    var_dump($item);
                }
                if (!isset($item['descriptionSimplifiee'])) {
                    var_dump($item);
                }

                $merchant = $item['descriptionSimplifiee'];
                if (strtolower($merchant) === 'paypal') {
                    $paypal_str = "paypal *";
                    if (str_starts_with(strtolower($item['descriptionCourte']), $paypal_str)) {
                        $pos = strpos(strtolower($item['descriptionCourte']), $paypal_str) + strlen($paypal_str);
                        $merchant = substr($item['descriptionCourte'], $pos);
                    } else {
                        var_dump($item);
                    }
                }
                $entries[] = new Entry($merchant, $item['categorieParentTransaction'], $item['categorieTransaction']);
            }
        }

        $categories = [];
        foreach ($entries as $entry) {
            if (!isset($categories[$entry->category])) {
                $categories[$entry->category] = [];
            }
            if (!isset($categories[$entry->category][$entry->sub_category])) {
                $categories[$entry->category][$entry->sub_category] = [];
            }
            if (in_array($entry->merchant, $categories[$entry->category][$entry->sub_category])) {
                continue;
            }
            $categories[$entry->category][$entry->sub_category][] = $entry->merchant;
        }

        echo json_encode($categories, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return 0;
    }
}
