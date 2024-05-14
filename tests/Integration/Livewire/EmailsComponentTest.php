<?php

namespace Integration\Livewire;

use App\Livewire\EmailsComponent;
use App\Models\Email;
use App\Support\Facades\EmailServiceFacade;
use Database\Seeders\SeedEmailTable;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Class EmailTest
 *
 * @package Integration/Livewire
 *
 * @coversDefaultClass \App\Livewire\EmailsComponent
 *
 * @small
 */
class EmailsComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the component renders.
     *
     * @test
     */
    public function testTableRenderedCorrectly()
    {
        $this->seed(SeedEmailTable::class);

        $component = Livewire::test(EmailsComponent::class);

        $component->assertSee('Sender');
        $component->assertSee('Recipient');
        $component->assertSee('Subject');
        $component->assertSee('Upload Email');
        $component->assertSee('View');
    }

    /**
     * Tests the create button with file param.
     *
     * @test
     */
    public function testUploadEmailAction()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('test.eml');

        EmailServiceFacade::shouldReceive('parseAndSaveEml')
            ->withArgs([$file])
            ->andReturn(Email::factory()->make());

        Livewire::test(EmailsComponent::class)
            ->setTableActionData(['eml_file' => $file])
            ->callTableAction(CreateAction::class);
    }

    /**
     * Tests the view button.
     *
     * @test
     */
    public function testViewEmailAction()
    {
        $email = Email::factory()->create();

        $component = Livewire::test(EmailsComponent::class);

        Redirect::shouldReceive('route')
            ->withAnyArgs();

        $component->callTableAction('view', $email);
    }
}
