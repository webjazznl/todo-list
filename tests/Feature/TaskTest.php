<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Tasks testen
     */

    use RefreshDatabase;

    public function testTaskOverview(): void
    {
        $response = $this->get('/tasks/');

        $response->assertStatus(200);
    }

    public function testTaskCanBeCreated()
    {
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
            'start_date' => now(),
            'end_date' => now()->addDays(1),
        ]);

        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }
}
