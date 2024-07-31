<?php

namespace App\Services;

use App\Services\Interfaces\GenerateServiceInterface;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

/**
 * Class GenerateService
 * @package App\Services
 */
class GenerateService extends BaseService implements GenerateServiceInterface
{
    protected $generateRepository;
    public function __construct(
        GenerateRepository $generateRepository,
       
    ){
        $this->generateRepository = $generateRepository;
    }

    public function paginate($request) 
    {
       
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->integer('publish');
        $perpage = $request->integer('perpage');
        $generates = $this->generateRepository->pagination(
                $this->paginateSelect(), 
                $condition, 
                $perpage, 
                ['path' => 'generate/index'],
        );
        
        return $generates;
    }

    private function paginateSelect()
    {
        return [
            'id', 
            'name', 
            'schema',
        ];
    }

    public function create($request) {
        DB::beginTransaction();
        try {
            // $database = $this->makeDatabase($request); -->done
            // $controller = $this->makeController($request); --> done
            // $model = $this->makeModel($request); --> done
            $this->makeRepository($request); 

            // $this->makeService($request);
            // $this->makeProvider();
            // $this->makeRequest();
            // $this->makeView();
            // $this->makeRoute();
            // $this->makeRule();
            // $this->makeLang();

            // $payload = $request->except(['_token','send']);
            // $payload['user_id'] = Auth::id();
            // $generate = $this->generateRepository->create($payload);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    private function makeDatabase($request)
    { // Tạo cơ sở dữ liệu, tạo file migration
        try {
            $payload = $request->only('schema', 'name', 'module_type');
            $tableName = $this->converModelNameToTableName($payload['name']).'s';
            $migrationFileName = date('Y_m_d_His').'_create_'.$tableName.'_table.php';
            $migrationPath = database_path('migrations/'.$migrationFileName);
            $migrationTemplate = $this->createMigrationFile($payload);;
            FILE::put($migrationPath, $migrationTemplate);
    
            if($payload['module_type'] !== 3){
                $foreignKey = $this->converModelNameToTableName($payload['name']).'_id';
                $pivotTableName = $this->converModelNameToTableName($payload['name']).'_language';
                $pivotSchema = $this->pivotSchema($tableName, $foreignKey, $pivotTableName);
                $migrationPivotTemplate = $this->createMigrationFile([
                    'schema' => $pivotSchema,
                    'name' => $pivotTableName,
                ]);
                $migrationPivotFileName = date('Y_m_d_His', time() + 10).'_create_'.$pivotTableName.'_table.php';
                $migrationPivotPath = database_path('migrations/'.$migrationPivotFileName);
    
                FILE::put($migrationPivotPath, $migrationPivotTemplate);
            }
    
            ARTISAN::call('migrate');
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }


    }

    private function pivotSchema($tableName = '', $foreignKey = '', $pivot = '')
    {
        $pivotSchema = <<<SCHEMA
        Schema::create('{$pivot}', function (Blueprint \$table) {
            \$table->unsignedBigInteger('{$foreignKey}');
            \$table->unsignedBigInteger('language_id');
            \$table->foreign('{$foreignKey}')->references('id')->
            on('{$tableName}')->onDelete('cascade');
            \$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            \$table->string('name');
            \$table->text('description');
            \$table->longText('content');
            \$table->string('meta_title');
            \$table->string('meta_keyword');
            \$table->text('meta_description');
        });
SCHEMA;
        return $pivotSchema;
    }

    private function createMigrationFile($payload)
    {
        
        $migrationTemplate = <<<MIGRATION
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {$payload['schema']}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$this->converModelNameToTableName($payload['name'])}');
    }
};

MIGRATION;
    return $migrationTemplate;
    }

    private function converModelNameToTableName($name)
    {
        $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
        return $temp;
    }

    private function makeController($request)
    {
        $payload = $request->only('name', 'module_type');

        switch ($payload['module_type']) {
            case 1:
                $this->createTemplateController($payload['name'], 'TemplateCatalogueController');
                break;
            
            case 2:
                $this->createTemplateController($payload['name'], 'TemplateController');
                break;
            default:
            $this->createSingleController();
                
        }
    }

    private function createTemplateController($name, $contrlletFile)
    {
        try {
            $controllerName = $name.'Controller.php';
            $templateControllerPath = base_path('app/Templates/'.$contrlletFile.'.php');
            $controllerContent = file_get_contents($templateControllerPath);
    
            $replace = [
                'ModuleTemplate' => $name,
                'moduleTemplate' => lcfirst($name),
                'foreignKey' => $this->converModelNameToTableName($name).'_id',
                'tableName' => $this->converModelNameToTableName($name).'s',
                'moduleView' => str_replace('_','.',$this->converModelNameToTableName($name)),
            ];

            foreach($replace as $key => $val){
                $controllerContent = str_replace('{'.$key.'}', $replace[$key], $controllerContent);
            }
    
            $controllerPath = base_path('app/Http/Controllers/Backend/'.$controllerName);
            FILE::put($controllerPath, $controllerContent);
            die();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }


    private function createSingleController()
    {

    }

    private function makeModel($request)
    {
        try {
            if($request->input('module_type') == 1){
                $this->createModelTemplate($request);
            }else{
                echo 1;
            }


            return true;
        }catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();die();
            return false;
        }
    }

    private function createModelTemplate($request)
    {
        $modelName = $request->input('name').'.php';
        $templateModelPath = base_path('app/Templates/TemplateCatalogueModel.php');

        $modelContent = file_get_contents($templateModelPath);

        $module = $this->converModelNameToTableName($request->input('name'));
        $extractModule = explode('_',$module);
        $replace = [
            'ModuleTemplate' => $request->input('name'),
            'foreignKey' => $module.'_id',
            'tableName' => $module.'s',
            'relation' => $extractModule[0],
            'pivotModel' => $request->input('name').'Language',
            'relationPivot' => $module.'_'.$extractModule[0],
            'pivotTable' => $module.'_language',
            'module' => $module,
            'relationModel' => ucfirst($extractModule[0]),
        ];

        foreach($replace as $key => $val){
            $modelContent = str_replace('{'.$key.'}', $replace[$key], $modelContent);
        }

        $modulePath = base_path('app/Models/'.$modelName);
        FILE::put($modulePath, $modelContent);
        die();
    }

    private function makeRepository($request)
    {
        try {
            $name = $request->input('name');
            $module = $this->converModelNameToTableName($name);
            $moduleExtract = explode('_', $module);
            $repository = $this->initializeServiceLayer('Repository', 'Repositories', $request);
            $replace = [
                'Module' => $name,
            ];
            $repositoryInterfaceContent = $repository['interface']['layerInterfaceContent'];
            $repositoryInterfaceContent = str_replace('{Module}', $replace['Module'], 
            $repositoryInterfaceContent);

            
            $replaceRepository = [
                'Module' => $name,
                'tableName' => $module.'s',
                'pivotTableName' => $module.'_'.$moduleExtract[0],
                'foreignKey' => $module.'_id',
            ];

            $repositoryContent = $repository['service']['layerContent'];
            foreach ($replaceRepository as $key => $val) {
                $repositoryContent = str_replace('{'.$key.'}', $replaceRepository[$key], $repositoryContent);
            }
            File::put($repository['interface']['layerInterfacePath'], $repositoryInterfaceContent);
            File::put($repository['service']['layerPathPut'], $repositoryContent);

            die();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function makeService($request)
    {
        try {
            // $this->initializeServiceLayer($request);
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function initializeServiceLayer($layer = '', $folder = '', $request)
    {
        $name = $request->input('name');
        $option = [
            $layer.'Name' => $name.$layer,
            $layer.'InterfaceName' => $name.$layer.'Interface',
        ];
        $layerInterfaceRead = base_path('app/Templates/Template'.$layer.'Interface.php');
        $layerInterfaceContent = file_get_contents($layerInterfaceRead);
        $layerInterfacePath = base_path('app/'.$folder.'/Interfaces/'.$option[$layer.'InterfaceName'].'.php');
        
        $layerPathRead = base_path('app/Templates/Template'.$layer.'.php');
        $layerContent = file_get_contents($layerPathRead);
        $layerPathPut = base_path('app/'.$folder.'/'.$option[$layer.'Name'].'.php');
        
        return [
            'interface' => [
                'layerInterfaceContent' => $layerInterfaceContent,
                'layerInterfacePath' => $layerInterfacePath,
            ],
            'service' => [
                'layerContent' => $layerContent,
                'layerPathPut' => $layerPathPut,
            ],
            
        ];
            
    }

    

    public function update($id, $request) {
        DB::beginTransaction();
        try {
           
            $payload = $request->except(['_token','send']);
            $generate = $this->generateRepository->update($id, $payload);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $generate = $this->generateRepository->forceDelete($id);
            DB::commit();
            return true;
        }catch (\Exception $e) {
            DB::rollback();
            // echo $e->getMessage();die();
            return false;
        }
    }
    
}
