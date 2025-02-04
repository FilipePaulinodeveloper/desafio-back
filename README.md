# SOBRE O DESAFIO para a vaga Desenvolvedor Full Stack #

# Objetivo #
* Utilizar da API Backend para o frontend https://bitbucket.org/einov/desafiovuejs/ e fazer os ajustes no CRUD de usuário.
* E no Backend criar uma rotina diária que colete as notícias da UOL (https://rss.uol.com.br/feed/tecnologia.xml) e mande para
  todos os usuários cadastrados por e-mail. Nenhum usuário pode receber a mesma notícia duplicada.

Backend API

Instalação: 1. Clone o repositório: git clone <url_do_repositorio> cd <nome_do_diretorio> 
2. Instale as dependências do Composer: composer install 
3. Configure as variáveis de ambiente no arquivo .env: - Certifique-se de configurar o serviço de envio de e-mails, por exemplo, com o Mailtrap: MAIL_MAILER=smtp MAIL_HOST=mailpit MAIL_PORT=1025 MAIL_USERNAME=null MAIL_PASSWORD=null MAIL_ENCRYPTION=null MAIL_FROM_ADDRESS="hello@example.com" MAIL_FROM_NAME="${APP_NAME}" 4. Execute as migrações do banco de dados (caso necessário): php artisan migrate

Endpoints da API: Criação de Usuário: • Método: POST • URL: http://127.0.0.1:8000/api/user • Descrição: Cria um novo usuário.

Listar Usuários: • Método: GET • URL: http://127.0.0.1:8000/api/users • Descrição: Retorna a lista de todos os usuários.

Exibir um Usuário: • Método: GET • URL: http://127.0.0.1:8000/api/user/{id} • Descrição: Exibe os detalhes de um usuário específico.

Atualizar Usuário: • Método: PUT • URL: http://127.0.0.1:8000/api/user/{id} • Descrição: Atualiza os dados de um usuário específico.

Deletar Usuário: • Método: DELETE • URL: http://127.0.0.1:8000/api/user/{id} • Descrição: Deleta um usuário específico.

Envio de E-mails: O envio de e-mails é feito através de um comando programado. 1. Para executar o envio de e-mails automaticamente, execute o seguinte comando, que está agendado para rodar todos os dias às 7h da manhã: php artisan schedule:work 2. Para testar imediatamente o envio de e-mails, descomente as seguintes linhas no arquivo app/Console/Kernel.php: // $schedule->command('fetch:news')->everyMinute(); // $schedule->job(SendNewsEmail::class)->everyMinute(); e execute o comando: php artisan schedule:run
