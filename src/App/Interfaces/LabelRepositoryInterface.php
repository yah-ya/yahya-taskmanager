<?php

namespace Yahyya\taskmanager\App\Interfaces;

use Illuminate\Support\Collection;

interface LabelRepositoryInterface
{
    public function store(array $details):bool;
    public function list():Collection;
}
