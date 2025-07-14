<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Genera el sitemap.xml para SEO';

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/shop'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'));

        foreach (Category::all() as $category) {
            $sitemap->add(Url::create(route('categories.show', $category)));
        }
        foreach (Product::all() as $product) {
            $sitemap->add(Url::create(route('products.show', $product)));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
        $this->info('Sitemap generado correctamente.');
    }
}
