<?php
/**
 * Created by PhpStorm.
 * User: aevangelista
 * Date: 2019-05-20
 * Time: 17:36
 */

namespace App\Interfaces;


interface ServiceInterface
{
    public function save(array $data);
    public function getOne($id, array $children);
    public function getAll(array $children);
    public function delete($id);
}