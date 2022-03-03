<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:export_products',
    description: 'Export your products - app:export_products [format]',
)]
class ExportProductsCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('format', InputArgument::REQUIRED, 'FORMAT');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('format');

        if ($arg1) {
            if ($arg1 == 'csv')
            {
                $io->info('Export du fichier csv en cours...');

                $fp = fopen('csv_exports/products/export-'.date("dmYHi").'.csv', 'w');

                $repo = $this->entityManager->getRepository("App:Product");
                $products = $repo->findAll();

                $count = 0;
                $total = count($products);

                foreach ($products as $product) {
                    if(is_object($product) )
                        $data = [];
                        $data[] = $product->getId();
                        $data[] = $product->getName();
                        $data[] = $product->getDescription();
                        $data[] = $product->getPrice();
                        $data[] = $product->getSlug();
                        $data[] = $product->getCreatedAt()->format('d/m/Y');
                        fputcsv($fp, $data);
                        $count++;
                        $io->text('['.$count.'/'.$total.'] : '.$product->getName());
                }
                
                $io->success('L\'export csv a été éffectué.');
                $io->info('/csv_exports/products/export-'.date("dmYHi").'.csv');
                return Command::SUCCESS;
            }
            else
                $io->error('Please, enter a good format.');
        }

        return Command::FAILURE;
    }
}
