<?php

declare(strict_types=1);

namespace App\Transformers;
use Carbon\Carbon;
use App\Organisation;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * @param Organisation $organisation
     *
     * @return array
     */

    //  protected $availableIncludes = ['user'];
    protected $defaultIncludes = [
        'owner'
    ];

    public function transform(Organisation $organisation): array
    {
        $trialEndDate = !empty($organisation->trial_end) ? Carbon::createFromFormat('Y-m-d H:i:s', $organisation->trial_end)->format('Y-m-d H:i:s') : '';
        return [
            'id' => $organisation->id,
            'name' => $organisation->name,
            'owner_user_id' => $organisation->owner_user_id,
            'trial_end' => $organisation->trial_end,
            'trial_start_timestamp' => strtotime(Carbon::createFromFormat('Y-m-d H:i:s', $organisation->created_at)->format('Y-m-d H:i:s')),
            'trial_end_timestamp' => strtotime($trialEndDate),
            'subscribed' => $organisation->subscribed,
            'created_at' => $organisation->created_at,
            'updated_at' => $organisation->updated_at,
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeOwner(Organisation $organisation)
    {
        $data = $organisation->owner;
        return $this->item($organisation->owner, new UserTransformer());
        // return $this->collection($organisation->owner, new UserTransformer());
    }
}
