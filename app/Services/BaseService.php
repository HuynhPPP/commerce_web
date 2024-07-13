<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use App\classes\Nestedsetbie;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


/**
 * Class LanguageService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    protected $languageRepository;
    protected $routerRepository;
    protected $nestedset;
    protected $controllerName;
    public function __construct(
        Nestedsetbie $nestedset,
        RouterRepository $routerRepository,
    ){
        $this->nestedset = $nestedset;
        $this->routerRepository = $routerRepository;
    }

    public function currentLanguage() 
    {
        return 1;
    }

    public function formatAlbum($request)
    {
        return ($request->input('album') && !empty($request->input('album'))) ? 
        json_encode($request->input('album')) : '';
    } 

    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    public function formatRouterPayload($model, $request, $controllerName)
    {
        $router = [
            'canonical' => $request->input('canonical'),
            'module_id' => $model->id,
            'controllers' => 
            'App\Http\Controllers\Frontend\\'.$controllerName.'Controller',
        ];
        return $router;
    }

    public function createRouter($model, $request, $controllerName)
    {
        $router = $this->formatRouterPayLoad($model, $request, $controllerName);       
        $this->routerRepository->create($router);
    }
    
    public function updateRouter($model, $request, $controllerName)
    {
        $payload = $this->formatRouterPayLoad($model, $request, $controllerName);
        $condition = [
            ['module_id', '=', $model->id],
            ['controllers', '=', 'App\Http\Controllers\Frontend\\'.$controllerName.'Controller'],
        ];
        $router = $this->routerRepository->findByCondition($condition);
        $response = $this->routerRepository->update($router->id,  $payload);
        return $response;
    }
}
