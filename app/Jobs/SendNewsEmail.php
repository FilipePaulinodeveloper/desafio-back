<?php

namespace App\Jobs;

use App\Models\News;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::all();
        $news = News::where('sent', false)->get();

        foreach ($users as $user) {
            // Criar a mensagem com título e link das notícias
            $messageContent = "Veja as últimas notícias:\n\n";
            foreach ($news as $item) {
                $messageContent .= "- {$item->title}\n";
                $messageContent .= "  Link: {$item->link}\n\n";
            }

            Mail::send('emails.news-email', ['news' => $news], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Notícias do dia');
            });
        }

        // Marcar as notícias como enviadas
        $news->each->update(['sent' => true]);
    }
}
