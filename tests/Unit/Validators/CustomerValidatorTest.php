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
        $mockRequest->shouldReceive('getContent')->andReturn('{}');

        Validator::shouldReceive('make')->andReturn(Mockery::mock(['fails' => 'false', 'errors' => []]));

        $validator = new CustomerValidator();

        $validator->validateRequest($mockRequest);
    }

    public function testShouldNotValidateRequest()
    {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('isJson')->andReturn(true);
        $mockRequest->shouldReceive('all')->andReturn([]);
        $mockRequest->shouldReceive('getContent')->andReturn('{}');

        Validator::shouldReceive('make')->andReturn(Mockery::mock(['fails' => 'true', 'errors' => ['error' => 'true']]));

        $validator = new CustomerValidator();

        $validator->validateRequest($mockRequest);
    }
}