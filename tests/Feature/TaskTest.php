<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Mail\TaskMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    /**
     * Tasks testen
     */

    // Database reset bij elke test
    use RefreshDatabase;

    public function testTaskOverview(): void
    {
        $response = $this->get('/tasks/');

        $response->assertStatus(200);
    }

    public function testTaskCanBeCreated()
    {

        $this->post('/tasks', [
            'title' => 'Test Task',
            'start_date' => now(),
            'end_date' => now()->addDays(1),
        ]);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    public function test_command_sends_emails_for_expired_tasks()
    {
        // Do not send mails during test
        Mail::fake();

        // Test data
        $oneDayAgo = date('Y-m-d', strtotime(now()->subDays(1)));
        $toDay = date('Y-m-d', strtotime(now()));

        //When we are past the end date, then mail the task
        $validTask = Task::create([
            'title' => 'Valid Task',
            'end_date' => $oneDayAgo, // Task expired yesterday
            'completed' => false, // Not completed
        ]);
        // When we are before the end date, do not mail
        $endDate = date('Y-m-d', strtotime(now()->addDays(1)));
        $invalidTask1 = Task::create([
            'title' => 'Not Expired Task',
            'end_date' => $endDate, // Not expired
            'completed' => false,
        ]);
        // Completed tasks that expired should not be mailed
        $invalidTask2 = Task::create([
            'title' => 'Expired Completed Task',
            'end_date' => $oneDayAgo, // Expired
            'completed' => true, // Already completed
        ]);

        // Tasks should not be mailed when they end today
        $invalidTask3 = Task::create([
            'title' => 'Expired Completed Task',
            'end_date' => $toDay, // Not Expired
            'completed' => false, // Already completed
        ]);

        //Run the command
        $this->artisan('app:send-overdue-task-emails')
            ->expectsOutput("Email sent for task: {$validTask->title}")
            ->assertExitCode(0);

        //Assert email was sent for the valid task
        Mail::assertSent(TaskMail::class, function ($mail) use ($validTask) {
            return $mail->task->id === $validTask->id;
        });

        // Assert emails were not sent for invalid tasks
        Mail::assertNotSent(TaskMail::class, function ($mail) use ($invalidTask1, $invalidTask2, $invalidTask3) {
            return $mail->task->id === $invalidTask1->id
                || $mail->task->id === $invalidTask2->id
                || $mail->task->id === $invalidTask3->id;
        });
    }
}
