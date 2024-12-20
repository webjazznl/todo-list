<?php

namespace App\Console\Commands;

use App\Mail\TaskMail;
use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendOverdueTaskEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-overdue-task-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send overdue tasks by e-mail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Haal taken op die verlopen zijn en niet zijn afgevinkt, kijken alleen naar datum, niet tijd.
        $tasks = Task::where('end_date', '<', date('Y-m-d'))
            ->where('completed', false)
            ->get();
        foreach ($tasks as $task) {
            Mail::to(env('MAIL_RECIPIENT'))->send(new TaskMail($task));
            $this->info("Email sent for task: {$task->title}");
        }


        // foreach ($tasks as $task) {
        //     // Verstuur een e-mail
        //     Mail::raw(
        //         "Task '{$task->title}' is overdue! Please complete it as soon as possible.",
        //         function ($message) use ($task) {
        //             $message->to($task->email) // Zorg ervoor dat er een 'email' kolom is
        //                 ->subject('Overdue Task Notification');
        //         }
        //     );


        //     $this->info("Email sent for task: {$task->title}");
        // }
    }
}
