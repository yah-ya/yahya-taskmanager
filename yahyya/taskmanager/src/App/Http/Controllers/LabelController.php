<?php

namespace Yahyya\taskmanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yahyya\taskmanager\App\Http\Requests\StoreLabel;
use Yahyya\taskmanager\App\Http\Resources\LabelCollection;
use Yahyya\taskmanager\App\Models\Label;

class LabelController extends Controller
{
    public function list(): LabelCollection
    {
        return new LabelCollection(Label::all());
    }

    public function store(StoreLabel $req): bool
    {
        try {
            Label::create($req->validated());
            return true;
        } catch (\Exception $ex){
            return false;
        }
    }
}
