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
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    public function testShouldBeConstructed()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockRoleService = Mockery::mock(RoleService::class);
        $mockUserService = Mockery::mock(UserService::class);

        $service = new CustomerService($mockCustomerRepository, $mockUserService, $mockRoleService);

        $this->assertInstanceOf(CustomerService::class, $service);
    }

    public function testSaveCustomerShouldCreateCustomer()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('create')->andReturn($mockCustomerRepository);

        $mockRoleService = Mockery::mock(RoleService::class);
        $mockUserService = Mockery::mock(UserService::class);

        $service = new CustomerService($mockCustomerRepository, $mockUserService, $mockRoleService);

        $customer = $service->save(['address' => 'test_data']);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testSaveCustomerShouldUpdateCustomer()
    {
        $mockCustomerRepository = Mockery::mock(Customer::class);
        $mockCustomerRepository->shouldReceive('findOrFail')->andReturn($mockCustomerRepository);
        $mockCustomerRepository->shouldReceive('update')->andReturn($mockCustomerRepository);

        $mockRoleService = Mockery::mock(RoleService::class);
        $mockRoleService->shouldReceive('getByKey')->andReturn('test_role_key');
        $mockUserService = Mockery::mock(UserService::class);

        $service = new CustomerService($mockCustomerRepository, $mockUserService, $mockRoleService);
        $customer = $service->save(['id' => 1]);

        $this->assertInstanceOf(CustomerService::class, $service);
        $this->assertInstanceOf(Customer::class, $customer);
    }
}