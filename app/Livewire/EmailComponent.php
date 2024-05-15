<?php

namespace App\Livewire;

use App\Models\Email;
use App\Support\Facades\EmailServiceFacade;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

/**
 * Class EmailComponent
 *
 * @package App\Livewire
 */
class EmailComponent extends Component
{
    public Email $email;
    public string $tag = '';

    /**
     * Saves a new tag to the email.
     *
     * @return void
     */
    public function saveTag(): void
    {
        EmailServiceFacade::addTag($this->email, $this->tag);
        $this->tag = '';
    }

    /**
     * Redirect to index page.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function goToEmails()
    {
        return redirect()->route('emails.index');
    }

    /**
     * Renders the component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.email-component');
    }
}
