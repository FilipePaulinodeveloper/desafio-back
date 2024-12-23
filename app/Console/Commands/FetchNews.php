<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches news from the UOL RSS feed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rssFeed = 'https://rss.uol.com.br/feed/tecnologia.xml';
        $response = Http::withOptions(['verify' => false])->get($rssFeed);

        if ($response->ok()) {
            $content = $response->body();

            $content = mb_convert_encoding($content, 'UTF-8', 'auto');

            $xml = simplexml_load_string($content);

            foreach ($xml->channel->item as $item) {
                $title = (string)$item->title;
                $link = (string)$item->link;

                // Salvar notícia no banco se ainda não existir
                if (!News::where('link', $link)->exists()) {
                    News::create(['title' => $title, 'link' => $link]);
                }
            }
            $this->info('Notícias coletadas com sucesso.');
        } else {
            $this->error('Erro ao buscar o feed RSS.');
        }
    }
}
