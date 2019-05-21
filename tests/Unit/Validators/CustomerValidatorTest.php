<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 2019-05-21
 * Time: 11:05
 */

namespace Tests\Unit\Validators;


use App\Validators\CustomerValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mockery;
use Tests\TestCase;


class CustomerValidatorTest extends TestCase
{
    public function testShouldValidateRequest()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('isJson')->andReturn(true);
        $mockRequest->shouldReceive('all')->andReturn([]);
        $mockRequest->shouldReceive('getContent')->andReturn(json_encode($this->getMockRequestData()));

        Validator::shouldReceive('make')->andReturn(Mockery::mock(['fails' => 'false', 'errors' => []]));

        $validator = new CustomerValidator();

        $validator->validateRequest($mockRequest);
        $this->assertIsArray($validator->getData());
    }

    public function testShouldNotValidateRequest()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('isJson')->andReturn(true);
        $mockRequest->shouldReceive('all')->andReturn([]);
        $mockRequest->shouldReceive('getContent')->andReturn('{}');

        Validator::shouldReceive('make')->andReturn(Mockery::mock(['fails' => 'true', 'errors' => ['name' => 'Test message']]));

        $validator = new CustomerValidator();

        $validator->validateRequest($mockRequest);
        $this->assertEquals($validator->isValid(), false);
        $this->assertIsArray($validator->getErrors());
    }

    private function getMockRequestData()
    {
        return [
            'name'      => 'test',
            'email'     => 'test@test.com',
            'phone'     => '1234',
            'fax'       => '1234',
            'website'   => 'test.com',
            'active'    => true,
            'taxable'    => true,
            'address'   => '{"formatted_address": "Test 123"}',
            'vat'       => true,
            'vat_number'=> '67886786767'
        ];
    }
}