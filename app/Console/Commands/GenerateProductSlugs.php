<?php

namespace App\Console\Commands;

use App\Models\MProduct;
use Illuminate\Console\Command;

class GenerateProductSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:generate-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate SEO-friendly slugs for all existing products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating slugs for existing products...');
        
        $products = MProduct::whereNull('slug')->orWhere('slug', '')->get();
        
        if ($products->isEmpty()) {
            $this->info('No products found that need slug generation.');
            return;
        }
        
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();
        
        foreach ($products as $product) {
            $slug = MProduct::generateSlug($product->sku, $product->name_service);
            $product->update(['slug' => $slug]);
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        $this->info("Successfully generated slugs for {$products->count()} products.");
    }
}
