<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNewsEmails extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'send:news';  // Comando que você vai executar

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Envia as últimas notícias para os usuários cadastrados';

    /**
     * Execute o comando.
     *
     * @return void
     */
    public function handle()
    {
        // Buscar usuários e notícias não enviadas
        $users = User::all();
        $news = News::where('sent', false)->get();

        // Enviar e-mail para cada usuário
        foreach ($users as $user) {
            Mail::raw("Veja as últimas notícias:\n" . $news->pluck('title')->implode("\n"), function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Notícias do dia');
            });
        }

        // Marcar as notícias como enviadas
        $news->each->update(['sent' => true]);

        $this->info('E-mails enviados com sucesso!');
    }
}
