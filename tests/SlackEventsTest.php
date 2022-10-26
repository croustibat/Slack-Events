<?php

namespace Lisennk\LaravelSlackEvents\Tests;

use Orchestra\Testbench\TestCase;
use Lisennk\LaravelSlackEvents\Tests\Traits\EventRequestDataTrait;
use \Lisennk\LaravelSlackEvents\EventCreator;
use \Lisennk\LaravelSlackEvents\Events\ReactionAdded;
use \Lisennk\LaravelSlackEvents\Events\ChannelCreated;
use Lisennk\LaravelSlackEvents\Events\WorkflowStepExecute;
use \Illuminate\Http\Request;

/**
 * Tests EventCreator
 */
class SlackEventsTest extends TestCase
{
    use EventRequestDataTrait;

    /**
     * Test for proper event class from event type creation
     */
    public function testShouldCreateReactionAdded()
    {
        $events = new EventCreator();

        $event = $events->make('reaction_added');
        $this->assertInstanceOf(ReactionAdded::class, $event);
    }

    /**
     * Test for proper event class from event type creation
     */
    public function testShouldCreateChannelCreated()
    {
        $events = new EventCreator();

        $event = $events->make('channel_created');
        $this->assertInstanceOf(ChannelCreated::class, $event);
    }

    /**
     * Test for proper event class from event type creation
     */
    public function testShouldCreateWorkflowStepExecute()
    {
        $events = new EventCreator();

        $event = $events->make('workflow_step_execute');
        $this->assertInstanceOf(WorkflowStepExecute::class, $event);
    }

    /**
     * Test for parameters passing from array
     */
    public function testSetFromArray()
    {
        $data = array_merge($this->eventRequestData, [
            'token' => 'some-custom-token'
        ]);

        $events = new EventCreator();
        $event = $events->make($this->eventRequestData['event']['type']);
        $event->setFromArray($data);

        $this->assertEquals($data['token'], $event->token);
        $this->assertEquals($data['event'], $event->event);
    }

    /**
     * Test for parameters passing from http request
     */
    public function testSetFromRequest()
    {
        $data = array_merge($this->eventRequestData, [
            'token' => 'some-custom-token'
        ]);

        $request = new Request;
        $request->replace($data);

        $events = new EventCreator();
        $event = $events->make($this->eventRequestData['event']['type']);
        $event->setFromRequest($request);

        $this->assertEquals($data['token'], $event->token);
        $this->assertEquals($data['event'], $event->event);
    }
}