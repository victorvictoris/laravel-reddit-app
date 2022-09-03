<?php

namespace Tests\Unit;

use App\Models\Thread;
use PHPUnit\Framework\TestCase;

class PublishedThreadTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $thread1 = new Thread([
            'title' => 'Thread Test1',
            'text' => 'Thread Text1',
            'subreddit_name' => 'test_subreddit_name1',
            'published_at' => '2022-09-01 21:00:00',
            'created_at' => '2022-09-01 20:00:00'
        ]);
        $thread2 = new Thread([
            'title' => 'Thread Test2',
            'text' => 'Thread Text2',
            'created_at' => '2022-09-01 23:00:00'
        ]);

        $this->assertTrue($thread1->published_at != null, 'Published');
        $this->assertNull($thread2->published_at, 'Not published');
    }
}
