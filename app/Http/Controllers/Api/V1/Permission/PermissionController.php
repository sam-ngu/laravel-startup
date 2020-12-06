<?php

namespace App\Http\Controllers\Api\V1\Permission;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    const RELATIONSHIPS = [
        'users', 'permissions',
    ];

    /**
     * Display a listing of Permission.
     * @queryParam filter array An array to filter fields. Example: [name]="john"
     * @queryParam search string String to conduct full text search. Example: John Doe
     * @queryParam page_size int Number of items to return per page. Example: 50
     * @queryParam sort string Sort results by field. Example: -name will sort results by name in descending order
     * @apiResourceCollection App\Http\Resources\PermissionResource
     * @apiResourceModel App\Models\Permission
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $pageSize = (int)$request->page_size ?? 250;
        $permissions = Permission::query();

        return PermissionResource::collection($permissions->paginate($pageSize))->response();
    }
}
