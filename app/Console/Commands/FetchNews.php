<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNews extends Command
{


    public function __construct( private News $news)
    {
        parent::__construct();
    }

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
        $linkNews = 'https://rss.uol.com.br/feed/tecnologia.xml';
        $newsResponse = $this->getResponse($linkNews);

        if ($newsResponse->ok()) {
            $content = $newsResponse->body();

            $content = mb_convert_encoding($content, 'UTF-8', 'auto');

            $xml = simplexml_load_string($content);

            foreach ($xml->channel->item as $item) {

                $infoNews = $this->getNewsInfor($item);

                $this->saveNewsIfNotExists($infoNews);

            }
            $this->info('Notícias coletadas com sucesso.');
        } else {
            $this->error('Erro ao buscar o feed RSS.');
        }
    }

    private function getResponse($linkNews)
    {
        return Http::withOptions(['verify' => false])->get($linkNews);
    }

    private function getNewsInfor($item){
        $title = (string)$item->title;
        $link = (string)$item->link;

        return ['title' => $title, 'link' => $link];
    }

    private function saveNewsIfNotExists($infoNews)
    {

        if (!$this->news->where('link', $infoNews['link'])->exists()) {

            $this->news->create(['title' => $infoNews['title'], 'link' => $infoNews['link']]);
        }
    }
}
