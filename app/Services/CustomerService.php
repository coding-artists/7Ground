<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 26/03/2018
 * Time: 13:54
 */

namespace App\Services;


use App\Interfaces\ServiceInterface;
use App\Repository\Customer;

class CustomerService implements ServiceInterface
{
    /**
     * @var Customer
     */
    private $customerRepository;

    /**
     * CustomerService constructor.
     * @param Customer $customerRepository
     */
    public function __construct(
        Customer $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param array $data
     * @return Customer
     */
    public function save(array $data)
    {
        if (isset($data['address'])) {
            $data['address'] = stripcslashes($data['address']);
        }

        $data['active'] = isset($data['active']);
        $data['taxable'] = isset($data['taxable']);

        if (isset($data['id'])) {
            $customer = $this->customerRepository->findOrFail($data['id']);
            $customer->update($data);
        } else {
            $customer = $this->customerRepository->create($data);
        }

        return $customer;
    }

    /**
     * @param array $children
     * @return Customer[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $children = [])
    {
        return $this->customerRepository->with($children)->get();
    }

    /**
     * @param $id
     * @param array $children
     * @return Customer|Customer[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getOne($id, array $children = [])
    {
        return $this->customerRepository->with($children)->findOrFail($id);
    }

    /**
     * @param $id
     * @return Customer
     */
    public function changeStatus($id)
    {
        $customer = $this->customerRepository->findOrFail($id);
        $customer->active = !$customer->active;
        $customer->save();
        return $customer;
    }

    /**
     * @return integer
     */
    public function count()
    {
        return $this->customerRepository->count();
    }

    /**
     * @param $customerId
     * @return Customer
     */
    public function delete($customerId)
    {
        $customer = $this->findOrFail($customerId);
        $customer->deleted = true;
        $customer->save();

        return $customer;
    }

}
