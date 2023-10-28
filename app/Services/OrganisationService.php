<?php

declare(strict_types=1);

namespace App\Services;

use App\Organisation;
use Illuminate\Support\Facades\Mail;


use App\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Carbon\Carbon;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();

        $organisation->name = $attributes['name'];
        $organisation->trial_end =Carbon::now()->addDay(30)->toDateTimeString();;
        $organisation->owner_user_id =$attributes['owner_user_id'];
        $organisation->subscribed = $attributes['subscribed'];

        $organisation->save();

        $content = "<div>organisation Name: ". $attributes['name']."</div>
                    <div>organisation Period: ". $attributes['trial_end']."</div>
                    <div>Owner: ". $organisation->owner->name."</div>";

        $from_mail = config('mail.username');
        $to_mail = $organisation->owner->email;
        $mail_subject = "New Orgnazation Created";
        $from_mail_name ="Orgnazation Created";

        $send_mail = Mail::send(array(),array(), function($message) use($content,$from_mail,$to_mail,$mail_subject,$from_mail_name)
        {
            $message->from(trim($from_mail),trim($from_mail_name));
            
            $message->to(trim($to_mail))
                    ->subject($mail_subject)
                    ->setBody($content, 'text/html');    
        });

        
        return $organisation;
    }

    public function listAll(string $param): object 
    {
        try {
            $modelQuery = new Organisation();
            if (!empty($param))
            {
                if ($param === 'subbed')
                {
                    $modelQuery = $modelQuery
                                  ->where('subscribed', 1);
                } elseif ($param === 'trail')
                {
                    $modelQuery = $modelQuery
                        ->where('subscribed', 0);
                }
            }
            $organisations = $modelQuery->get();
        } catch (Throwable $e) {
            // report($e);
            return false;
        }

        return $organisations;
    }
}
