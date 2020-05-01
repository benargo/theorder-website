<?php

namespace App\Repositories\Interfaces;

interface ItemRepositoryInterface
{
    public function all();

    public function find($id, array $options = []);

    public function withMedia();
}
