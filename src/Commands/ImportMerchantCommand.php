<?php

namespace App\Commands;

use App\DB\Entity\Category;
use App\DB\Entity\Merchant;
use App\DB\Entity\SubCategory;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMerchantCommand extends Command
{
    protected static $defaultName = 'import:json';

    private const ARGUMENT_FILE = 'file';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Import merchant codes from json to database')
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

        $categoryRepository = $this->entityManager->getRepository(Category::class);
        $subCategoryRepository = $this->entityManager->getRepository(SubCategory::class);
        $merchantRepository = $this->entityManager->getRepository(Merchant::class);

        foreach ($json as $category => $subCategories) {
            $categoryEntity = $categoryRepository->findOneBy(['name' => $category]);
            if ($categoryEntity === null) {
                $categoryEntity = new Category($category);
                $this->entityManager->persist($categoryEntity);
            }

            foreach ($subCategories as $subCategory => $merchants) {
                $subCategoryEntity = $subCategoryRepository->findOneBy(['name' => $subCategory]);
                if ($subCategoryEntity === null) {
                    $subCategoryEntity = new SubCategory($subCategory, $categoryEntity);
                    $this->entityManager->persist($subCategoryEntity);
                }

                foreach ($merchants as $merchant) {
                    $merchantEntity = $merchantRepository->findOneBy(['name' => $merchant]);
                    if ($merchantEntity === null) {
                        $merchantEntity = new Merchant($merchant, $subCategoryEntity);
                        $this->entityManager->persist($merchantEntity);
                    }
                }
            }
        }
        $this->entityManager->flush();
        return 0;
    }
}
