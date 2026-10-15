<?php

namespace Tests\Feature\Api\v1;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_dapat_melihat_semua_task(): void
    {
        // arrange
        $tasks = Task::factory()->count(2)->create();
        // act
        $response = $this->getJson('/api/v1/tasks');
        // assert
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'kode',
                    'name',
                    'is_completed',
                ],
            ],
        ]);
    }

    public function test_simpan_task(): void
    {
        // arrange
        // act
        $response = $this->postJson('/api/v1/tasks', [
            'name' => 'Task 1',
            'is_completed' => false,
        ]);
        // assert
        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'kode',
                'name',
                'is_completed',
            ],
        ]);
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task 1',
            'is_completed' => false,
        ]);
    }

    public function test_ubah_task(): void
    {
        // arrange
        $task = Task::factory()->create();
        // act
        $response = $this->putJson("/api/v1/tasks/{$task->kode}", [
            'name' => 'Task 1',
            'is_completed' => false,
        ]);
        // assert
        $response->assertOk();
        $response->assertJsonFragment([
                'kode' => $task->kode,
                'name' => 'Task 1',
                'is_completed' => false,
        ]);
        $this->assertDatabaseHas('tasks', [
            'name' => 'Task 1',
            'is_completed' => false,
        ]);
    }

    public function test_hapus_task(): void
    {
        // arrange
        $task = Task::factory()->create();
        // act
        $response = $this->deleteJson("/api/v1/tasks/{$task->kode}");
        // assert
        $response->assertOk();
        $this->assertDatabaseMissing('tasks', [
            'kode' => $task->kode,
        ]);
    }
}
