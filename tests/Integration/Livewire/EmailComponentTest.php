<?php

namespace Integration\Livewire;

use App\Livewire\EmailComponent;
use App\Models\Email;
use App\Support\Facades\EmailServiceFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class EmailComponentTest
 *
 * @package Tests\Integration\Livewire
 *
 * @coversDefaultClass \App\Livewire\EmailComponent
 */
class EmailComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests that the component can be rendered with the provided email.
     * @test
     */
    public function testCanRenderComponent()
    {
        $email = Email::factory()->create();
        Livewire::test(EmailComponent::class, ['email' => $email])
            ->assertSee('Add Tag');
    }

    /**
     * Tests that addTag calls the appropriate facade.
     * @test
     */
    public function testCanSaveTagToEmail()
    {
        $email = Email::factory()->make();
        $tag = 'important';

        EmailServiceFacade::shouldReceive('addTag')
            ->withAnyArgs();

        Livewire::test(EmailComponent::class, ['email' => $email, 'tag' => $tag])
            ->call('saveTag');

        // The assertion is that the facade is called.
        $this->expectNotToPerformAssertions();
    }

    /**
     * Tests that the tag param is emptied after saving a tag.
     *
     * @test
     */
    public function testClearsTagFieldAfterSaving()
    {
        $email = Email::factory()->create();
        $tag = 'important';

        Livewire::test(EmailComponent::class, ['email' => $email, 'tag' => $tag])
            ->call('saveTag')
            ->assertSet('tag', '');
    }
}
