<?php

namespace Integration\Livewire;

use App\Livewire\Emails;
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
 * @covers App\Livewire\Emails
 *
 * @small
 */
class EmailTest extends TestCase
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

        $component = Livewire::test(Emails::class);

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

        Livewire::test(Emails::class)
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

        $component = Livewire::test(Emails::class);

        Redirect::shouldReceive('route')
            ->withArgs(['emails.show', ['email' => $email]]);

        $component->callTableAction('view', $email);
    }
}
