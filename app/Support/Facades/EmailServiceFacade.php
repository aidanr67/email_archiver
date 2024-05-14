<?php
namespace App\Support\Facades;

use App\Models\Email;
use App\Services\EmailService as Service;
use Illuminate\Support\Facades\Facade;

/**
 * Class EmailServiceFacade
 *
 * @package App\Support\Facades
 *
 * @see App\Services\EmailService
 *
 * @method static Email parseAndSaveEml(string $emlPath) : string
 */
class EmailServiceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return Service::class;
    }
}
