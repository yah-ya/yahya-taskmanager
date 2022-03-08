<?php

namespace Yahyya\taskmanager\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Yahyya\taskmanager\App\Http\Requests\StoreLabel;
use Yahyya\taskmanager\App\Http\Resources\LabelCollection;
use Yahyya\taskmanager\App\Interfaces\LabelRepositoryInterface;
use Yahyya\taskmanager\App\Models\Label;

class LabelController extends Controller
{
    private LabelRepositoryInterface $repo;
    public function __construct(LabelRepositoryInterface $labelRepository)
    {
        $this->repo = $labelRepository;
    }

    public function list(): LabelCollection
    {
        return new LabelCollection($this->repo->list());
    }

    public function store(StoreLabel $req): \Illuminate\Http\JsonResponse
    {
        $details = $req->validated();
        return response()->json(
            [
                'res'=>$this->repo->store($details)
            ]
        );
    }
}
