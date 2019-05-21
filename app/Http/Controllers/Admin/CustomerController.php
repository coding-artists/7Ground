<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 2019-05-20
 * Time: 17:02
 */

namespace App\Http\Controllers\Admin;


use App\Services\CustomerService;
use App\Validators\CustomerValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController
{
    /**
     * @var CustomerService
     */
    private $customerService;

    /**
     * @var CustomerValidator
     */
    private $customerValidator;

    /**
     * CustomerController constructor.
     * @param CustomerService $customerService
     * @param CustomerValidator $customerValidator
     */
    public function __construct(
        CustomerService $customerService,
        CustomerValidator $customerValidator
    )
    {
        $this->customerService = $customerService;
        $this->customerValidator = $customerValidator;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $customers = $this->customerService->getAll(['locations', 'calendars', 'alarms']);
        return new JsonResponse($customers);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $customers = $this->customerService->getOne($id, ['locations', 'calendars']);
        } catch(ModelNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($customers);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $this->customerService->changeStatus($id);
        } catch(ModelNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['removed' => $id], Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->customerValidator->validateRequest($request);
            if ($this->customerValidator->isValid()) {
                $customer = $this->customerService->save($this->customerValidator->getData());
                return new JsonResponse($customer, Response::HTTP_CREATED);
            }
        } catch(ModelNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->customerValidator->getErrors(), Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $this->customerValidator->validateRequest($request);
            if ($this->customerValidator->isValid()) {
                $data = $this->customerValidator->getData();
                $data['id'] = $id;

                $customer = $this->customerService->save($data);
                return new JsonResponse($customer, Response::HTTP_OK);
            }
        } catch(ModelNotFoundException $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->customerValidator->getErrors(), Response::HTTP_BAD_REQUEST);
    }

}