<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendNewsEmail; // Certifique-se de que a Job está corretamente referenciada

class SendNews extends Command
{
    /**
     * O nome e assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'send:news';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Envia as últimas notícias por e-mail para os usuários cadastrados';

    /**
     * Execute o comando.
     *
     * @return int
     */
    public function handle()
    {
        // Disparar a Job para envio de e-mails
        SendNewsEmail::dispatch(); // Job que realiza o envio
        $this->info('Job de envio de notícias enfileirada com sucesso!');

        return 0;
    }
}
