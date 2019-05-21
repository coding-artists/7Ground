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
    public function save();
    public function getOne();
    public function getAll();
    public function delete();
}