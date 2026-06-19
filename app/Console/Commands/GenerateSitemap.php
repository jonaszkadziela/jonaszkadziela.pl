<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\Post;
use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap files and store them in /public folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Sitemap::create()
            ->add($this->buildIndex(Document::get(), public_path('sitemap_documents.xml')))
            ->add($this->buildIndex(Post::published()->get(), public_path('sitemap_posts.xml')))
            ->add($this->buildIndex(Project::get(), public_path('sitemap_projects.xml')))
            ->add(Url::create('/')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(1))
            ->add(Url::create('/blog')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create('/contact')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create('/cv')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create('/documents')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create('/portfolio')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create('/privacy')->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->writeToFile(public_path('sitemap.xml'));
    }

    private function buildIndex(Collection $models, string $path): string
    {
        Sitemap::create()
            ->add($models)
            ->writeToFile($path);

        return basename($path);
    }
}
