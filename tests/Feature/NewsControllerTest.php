<?php

namespace Tests\Feature;

use App\Events\NewsCreated;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NewsControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected User $user;
    protected News $news;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
        $this->user = User::factory()->create();
    }

    public function testListNews()
    {
        $this->generateNews(5);

        $response = $this->get('/api/news');
        $news = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertIsArray($news);
        $this->assertCount(5, $news);
        foreach ($news as $item) {
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('content', $item);
        }
    }

    public function testListNewsWithPagination()
    {
        $this->generateNews(20);

        $response = $this->get('/api/news?page=2');
        $news = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertIsArray($news);
        $this->assertCount(5, $news);
        foreach ($news as $item) {
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('content', $item);
        }
    }

    public function testShowNews()
    {
        $news = $this->generateNews(1);
        $response = $this->get('/api/news/' . $news->id);
        $newsData = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertEquals($news->title, $newsData['title']);
        $this->assertEquals($news->content, $newsData['content']);
    }

    public function testStoreNews()
    {
        $data = [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $response = $this->postJson('/api/news', $data);

        $response->assertStatus(201)->assertJson(['success' => true]);
        $this->assertDatabaseHas('news', $data);
        Event::assertDispatched(NewsCreated::class, function ($event) use ($data) {
            return $event->news->title === $data['title'];
        });
    }

    public function testUpdateNews()
    {
        $news = $this->generateNews(1);

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ];

        $response = $this->put('/api/news/' . $news->id, $updatedData);
        $news->refresh();

        $response->assertStatus(200);
        $this->assertEquals($updatedData['title'], $news->title);
        $this->assertEquals($updatedData['content'], $news->content);
    }

    public function testDeleteNews()
    {
        $news = $this->generateNews(1);
        $response = $this->delete('/api/news/' . $news->id);
        $deletedNews = News::query()->find($news->id);

        $response->assertStatus(204);
        $this->assertNull($deletedNews);
    }

    private function generateNews(int $count) {
        $news = News::factory($count)->create(['user_id' => $this->user->id]);
        return $count === 1 ? $news->first() : $news;
    }

}
