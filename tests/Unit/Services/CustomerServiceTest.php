<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 2019-05-21
 * Time: 10:03
 */

namespace Tests\Unit\Services;

use App\Repository\Customer;
use App\Services\CustomerService;
use App\Services\RoleService;
use App\Services\UserService;
use Mockery;
use Tests\TestCase;

class CustomerServiceTest extends TestCase
{
    public function testShouldBeConstructed()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);

        $service = new CustomerService($mockCustomerRepository);

        $this->assertInstanceOf(CustomerService::class, $service);
    }

    public function testSaveCustomerShouldCreateCustomer()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('create')->andReturn($mockCustomerRepository);

        $service = new CustomerService($mockCustomerRepository);

        $customer = $service->save(['address' => 'test_data']);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testSaveCustomerShouldUpdateCustomer()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('findOrFail')->andReturn($mockCustomerRepository);
        $mockCustomerRepository->shouldReceive('update')->andReturn($mockCustomerRepository);

        $service = new CustomerService($mockCustomerRepository);
        $customer = $service->save(['id' => 1]);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testShouldGetCustomerCollection()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('with')->with([])->andReturn($mockCustomerRepository);
        $mockCustomerRepository->shouldReceive('get')->andReturn([$mockCustomerRepository]);

        $service = new CustomerService($mockCustomerRepository);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertIsArray($service->getAll());
    }

    public function testShouldGetCustomerObject()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('with')->with([])->andReturn($mockCustomerRepository);
        $mockCustomerRepository->shouldReceive('findOrFail')->andReturn($mockCustomerRepository);

        $service = new CustomerService($mockCustomerRepository);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertInstanceOf(Customer::class, $service->getOne(1));
    }
}