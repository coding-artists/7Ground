<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 2019-05-20
 * Time: 17:27
 */

namespace Tests\Unit\app\Http\Controllers;


use App\Http\Controllers\Admin\CustomerController;
use App\Repository\Customer;
use App\Services\CustomerService;
use App\Validators\CustomerValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mockery;

class CustomerControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldBeConstructed()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);
        $mockValidator = Mockery::mock(CustomerValidator::class);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
    }

    public function testShouldReturnAllCustomers()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);
        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockCustomerService->shouldReceive('getAll')->andReturn([]);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->index());
    }

    public function testShouldReturnOneCustomer()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);
        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockCustomerService->shouldReceive('getOne')->andReturn([]);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->show(1));
    }

    public function testShouldStoreCustomer()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);

        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockValidator->shouldReceive('validateRequest');
        $mockValidator->shouldReceive('isValid')->andReturn(true);
        $mockValidator->shouldReceive('getData')->once()->andReturn([]);

        $mockRequest = Mockery::mock(Request::class);
        $mockCustomerService->shouldReceive('save')->once()->andReturn([]);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->store($mockRequest));
    }

    public function testStoreCustomerShouldReturnError()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);

        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockValidator->shouldReceive('validateRequest');
        $mockValidator->shouldReceive('isValid')->andReturn(false);
        $mockValidator->shouldReceive('getErrors')->once()->andReturn([]);

        $mockRequest = Mockery::mock(Request::class);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->store($mockRequest));
    }

    public function testShouldUpdateCustomer()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);

        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockValidator->shouldReceive('validateRequest');
        $mockValidator->shouldReceive('isValid')->andReturn(true);
        $mockValidator->shouldReceive('getData')->once()->andReturn([]);

        $mockRequest = Mockery::mock(Request::class);
        $mockCustomerService->shouldReceive('save')->once()->andReturn([]);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->update($mockRequest, 1));
    }

    public function testUpdateCustomerShouldReturnError()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);

        $mockValidator = Mockery::mock(CustomerValidator::class);
        $mockValidator->shouldReceive('validateRequest');
        $mockValidator->shouldReceive('isValid')->andReturn(false);
        $mockValidator->shouldReceive('getErrors')->once()->andReturn([]);

        $mockRequest = Mockery::mock(Request::class);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->update($mockRequest, 1));
    }

    public function testShouldDestroyCustomer()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerService = Mockery::mock(CustomerService::class);
        $mockCustomerService->shouldReceive('changeStatus')->andReturn($mockCustomerRepository);
        $mockValidator = Mockery::mock(CustomerValidator::class);

        $mockRequest = Mockery::mock(Request::class);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->destroy($mockRequest, 1));
    }

    public function testCustomerDestroyShouldHandleException()
    {
        $mockCustomerService = Mockery::mock(CustomerService::class);
        $mockCustomerService->shouldReceive('changeStatus')->with(1)->andThrow(new ModelNotFoundException('test'));
        $mockValidator = Mockery::mock(CustomerValidator::class);

        $mockRequest = Mockery::mock(Request::class);

        $controller = new CustomerController($mockCustomerService, $mockValidator);

        $this->assertInstanceOf(CustomerController::class, $controller);
        $this->assertInstanceOf(JsonResponse::class, $controller->destroy($mockRequest, 1));
    }
}