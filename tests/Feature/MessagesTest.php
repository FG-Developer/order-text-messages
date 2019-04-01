<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MessagesTest extends TestCase
{
    /**
     * Get messages list of other statuses.
     *
     * @return void
     */
    public function testMessagesForOtherStatuses()
    {
        $response = $this->get('/api/messages');

        $response->assertStatus(200);
    }

    /**
     * Get messages list of other statuses with search query.
     *
     * @return void
     */
    public function testMessagesForOtherStatusesWithSearch()
    {
        $response = $this->get('/api/messages?=Burger');

        $response->assertStatus(200);
    }

    /**
     * Get messages list of other statuses with search query in 2 char.
     *
     * @return void
     */
    public function testMessagesForOtherStatusesWithSearchInTwoChar()
    {
        $response = $this->get('/api/messages?=Bu');

        $response->assertStatus(422);
    }

    /**
     * Get messages list of sent messeages.
     *
     * @return void
     */
    public function testSentMessages()
    {
        $response = $this->get('/api/last-sent-messages');

        $response->assertStatus(200);
    }
}
