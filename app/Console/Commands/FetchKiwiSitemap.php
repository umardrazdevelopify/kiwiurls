<?php

namespace App\Console\Commands;

use App\Models\KiwiMainUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchKiwiSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:kiwi-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch the Kiwi sitemap and store URLs of nested sitemaps.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info("Fetching main sitemap: https://www.kiwi.com/sitemap.xml");

        $this->fetchSitemap('https://www.kiwi.com/sitemap.xml');
    }

    /**
     * Fetch the sitemap and store nested sitemaps.
     *
     * @param string $sitemapUrl
     * @return void
     */
    public function fetchSitemap($sitemapUrl)
    {
        $this->info("Fetching main sitemap: $sitemapUrl");

        // Fetch sitemap content using HTTP client
        $sitemapContent = Http::get($sitemapUrl)->body();

        // Parse XML content
        $xml = simplexml_load_string($sitemapContent);

        if (!$xml) {
            $this->error("Error parsing the sitemap at $sitemapUrl");
            return;
        }

        // Loop through the <sitemap> elements and store the URLs of nested sitemaps
        foreach ($xml->sitemap as $sitemap) {
            $url = (string) $sitemap->loc;

            // Store the URL of the nested sitemap
            $this->storeUrl($url);
        }
    }

    /**
     * Store the URL in the database.
     *
     * @param string $url
     * @return void
     */
    private function storeUrl($url)
    {
        // Check for duplicates before inserting
        KiwiMainUrl::firstOrCreate([
            'url' => $url
        ], [
            'is_sync' => false
        ]);
    }
}
