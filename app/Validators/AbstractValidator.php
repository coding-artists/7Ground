<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class AbstractValidator
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var bool
     */
    protected $validRequest = false;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var
     */
    protected $formValidator;

    /**
     * @param Request $request
     */
    public function validateRequest(Request $request)
    {
        $this->request = $request;

        $data = $request->all();

        if ($request->isJson()) {
            $data = json_decode($request->getContent(), true);
        }

        $this->formValidator = Validator::make($data, $this->rules(), $this->messages());
        if (!$this->formValidator->fails()) {
            $this->data = $data;
            $this->validRequest = true;
        } else {
            $this->validRequest = false;
            $this->errors = $this->formValidator->errors();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    public function messages()
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->validRequest;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getRequest()
    {
        if ($this->request instanceof Request) {
            return $this->request;
        }

        return null;
    }

    /**
     * @param $key
     * @param $message
     */
    public function addError($key, $message)
    {
        $this->errors[$key] = [$message];
    }
}