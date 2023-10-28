<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Organisation;
use App\User;
use App\Transformers\UserTransformer;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
// use Validator;
use Illuminate\Support\Facades\Validator;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;


/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(OrganisationService $service): JsonResponse
    {
        /* validate input request */
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|unique:organisations,name',
            'owner_user_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            $response['status']     = 'error';
            $response['message']    = 'Please feel all required fields!';
            $response['error_message'] = $validator->errors();
            return response()->json($response);
        }

        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($this->request->all());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    public function listAll(OrganisationService $service)
    {
        $filterData = $this->request->all();
        /* get filter data */
        $filter = !empty($filterData['filter']) ? $filterData['filter'] : 'all';
        /* get orgnasation list */
        $organisations =  $service->listAll($filter);
        /* trasform response */
        return $this
            ->transformCollection('organisation', $organisations)
            ->respond();
    }
}
