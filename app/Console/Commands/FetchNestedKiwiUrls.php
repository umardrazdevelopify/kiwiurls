<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KiwiMainUrl;
use App\Models\KiwiUrl;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class FetchNestedKiwiUrls extends Command
{
    protected $signature = 'fetch:nested-kiwi-urls';
    protected $description = 'Fetch nested URLs from kiwi_main_urls and store them in kiwi_urls';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Step 1: Fetch all main URLs that need to be processed (those with is_sync = false)
        $mainUrls = KiwiMainUrl::where('is_sync', false)->get();

        if ($mainUrls->isEmpty()) {
            $this->info('No unsynced main URLs found.');
            return;
        }

        foreach ($mainUrls as $mainUrl) {
            $this->info("Fetching nested URLs from: {$mainUrl->url}");

            // Step 2: Fetch the nested sitemap XML content
            $response = Http::get($mainUrl->url);

            if ($response->successful()) {
                // Step 3: Parse the XML response
                $xmlContent = $response->body();
                $xml = new SimpleXMLElement($xmlContent);

                // Step 4: Iterate through each <url> element and store it in kiwi_urls
                foreach ($xml->url as $url) {
                    $this->storeUrl((string) $url->loc);  // Store the <loc> URL in kiwi_urls table
                }

                // Mark the main URL as synced after processing
                $mainUrl->update(['is_sync' => true]);
            } else {
                $this->error("Failed to fetch: {$mainUrl->url}");
            }
        }

        $this->info('All nested URLs have been processed and stored.');
    }

    /**
     * Store the URL in the kiwi_urls table if not already present.
     *
     * @param string $url
     * @return void
     */
    private function storeUrl($url)
    {
        KiwiUrl::firstOrCreate([
            'url' => $url,
        ], [
            'is_sync' => false,
        ]);
    }
}
