<?php

namespace Yahyya\taskmanager\App\Repositories;

use Illuminate\Support\Collection;
use Yahyya\taskmanager\App\Interfaces\LabelRepositoryInterface;
use Yahyya\taskmanager\App\Models\Label;

class LabelRepository implements LabelRepositoryInterface
{

    public function store(array $details):bool
    {
        try {
            Label::create($details);
            return true;
        } catch (\Exception $ex){
            return false;
        }
    }

    public function list():Collection
    {
        return Label::all();
    }
}
