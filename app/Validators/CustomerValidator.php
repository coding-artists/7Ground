<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 29/03/2018
 * Time: 01:13
 */

namespace App\Validators;


class CustomerValidator extends AbstractValidator
{

    public function rules()
    {
        $this->rules = [
            'name'      => 'required|string|min:2',
            'email'     => 'required|string|min:2',
            'phone'     => 'string|min:2',
            'fax'       => 'string|min:2',
            'website'   => 'string',
            'active'    => 'required|sometimes',
            'taxable'    => 'required|sometimes',
            'address'   => 'required',
            'vat'       => 'required|string',
            'vat_number'=> 'required|string'
        ];

        return $this->rules;
    }
}