<?php

namespace App\Livewire;

use App\Models\Email;
use App\Support\Facades\EmailServiceFacade;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Livewire\Component;

/**
 * Class EmailsComponent
 *
 * @package App\Livewire
 */
class EmailsComponent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    /**
     * Builds the Filament table.
     *
     * @param Table $table
     *
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->query(Email::query())
            ->columns([
                TextColumn::make('sender_address')
                    ->label('Sender')
                    ->searchable(),
                TextColumn::make('recipient_address')
                    ->label('Recipient')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable(),
                TagsColumn::make('tags')
                    ->label('Tags')
                    ->searchable(),
            ])
            ->actions([
                Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->action(function (Email $email) {
                        return Redirect::route('emails.show', ['email' => $email]);
                    }),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Upload Email')
                    ->using(function (array $data, EmailServiceFacade $serviceFacade): Email {
                        return $serviceFacade::parseAndSaveEml($data['eml_file']);
                    })
                ->form([
                    FileUpload::make('eml_file')
                        ->label('.eml file')
                        ->rule('mimes:eml')
                        ->required(),
                ])
                ->createAnother(false)
            ]);
    }

    /**
     * Render view.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.emails-component');
    }
}
