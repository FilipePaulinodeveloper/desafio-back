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
            Mail::raw("Veja as últimas notícias:\n" . $news->pluck('title')->implode("\n"), function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Notícias do dia');
            });
        }

        $news->each->update(['sent' => true]);
    }
}
