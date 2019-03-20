<?php

namespace App\Console\Commands;

use App\Lib\Entity\ManageMenu;
use App\Lib\Entity\ManagePower;
use Illuminate\Console\Command;

class InitMenu extends Command
{

    const WHITE_ARR = ['DefaultController', 'LoginController','UploadController'];

    protected $signature = 'init_admin_menu';

    protected $description = '初始化后台菜单';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        echo "crate menu start... \n";

        $controllerPath = app_path('Http/Controllers/Admin');
        $allClass = $this->getAllClass($controllerPath);
        foreach ($allClass as $classDir) {
            $namespace = trim(substr($classDir, strlen($controllerPath) + 1));
            //echo $namespace;
            $this->createMenuOrPower($namespace);
        }
        echo "crate menu end... \n";
    }

    public function getAllClass($path)
    {
        static $data = [];
        $dir = opendir($path);
        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                    $this->getAllClass($path . DIRECTORY_SEPARATOR . $file);
                } else {
                    $fileName = substr($file, 0, strrpos($file, '.'));
                    if (!in_array($fileName, self::WHITE_ARR)) {
                        $data[] = $path . DIRECTORY_SEPARATOR . $fileName . "\n";

                    }
                }

            }
        }
        closedir($dir);
        return $data;
    }

    private function createMenuOrPower($className)
    {
        $namespace = '\App\Http\Controllers\Admin\\' . $className;
        //$namespace = '\App\Http\Controllers\Admin\Member\HandleController' ;
        $obj = new $namespace();
        $class = new \ReflectionClass($obj);

        $methods = $class->getMethods();
        //$classNames = $class->getShortName();
        $route = substr($className, 0, strlen($className) - 10);
        $route = str_replace('\\', '/', $route);

        foreach ($methods as $method) {
            if ($method->isPublic() && $method->class == 'App\Http\Controllers\Admin\\' . $className) {
                $doc = $method->getDocComment();
                if ($doc) {
                    $result = $this->parseDoc($doc);
                    $path = '/admin/' . strtolower($route) . '/' . $method->name;
                    $httpMethod = $this->getRequestMethod($method->name);
                    $result['method'] = !empty($result['method']) ? $result['method'] : $httpMethod;

                    if (!$meauid = ManageMenu::checkPath($result['power'])) {
                        //判断父级是否存在
                        if ($result['level'] == 2) {
                            $parent = substr($result['power'], 0, strpos($result['power'], '|'));
                        } else if ($result['level'] == 3) {
                            $parent = substr($result['power'], 0, strpos($result['power'], '@'));
                        }
                        if (!$parentId = ManageMenu::checkPath($parent)) {
                            $parentId = \App\Lib\Model\Rbac\Power\Service::addMenu([
                                'power' => $parent,
                                'level' => 1,
                                'sort' => $result['sort']
                            ]);

                        }
                        $result['parent_id'] = $parentId;
                        $meauid = \App\Lib\Model\Rbac\Power\Service::addMenu($result);
                    }

                    if ($meauid && !ManagePower::checkPath($path)) {
                        \App\Lib\Model\Rbac\Power\Service::addPower($path, $result['method'], $meauid, $result['level']);
                    }
                }
            }
        }

    }

    private function getRequestMethod($method)
    {
        switch ($method) {
            case 'index':
                return 'GET';
                break;
            case 'create':
                return 'GET';
                break;
            case 'edit':
                return 'GET';
                break;
            case 'store':
                return 'POST';
                break;
            case 'update':
                return 'PUT';
                break;
            case 'destroy':
                return 'DELETE';
                break;
            case 'show':
                return 'GET';
                break;
            default:
                return '';
                break;
        }
    }


    private function parseDoc($doc)
    {
        $result = preg_replace('/\n|\s*/', '', $doc);
        $result = preg_replace('/\/\*\*\*|\*\//', '', $result);

        $arr = explode('*', $result);

        $power = preg_replace('/^@power/', '', $arr[0]);
        $level = strpos($power, '@') ? 3 : 2;

        if (count($arr) > 1) {
            if (preg_match('/^@rank/', $arr[1])) {
                $sort = preg_replace('/^@rank/', '', $arr[1]);
                $sort = (int)$sort;
            } elseif (preg_match('/^@method/', $arr[1])) {
                $method = preg_replace('/^@method/', '', $arr[1]);
            }
        }
        return [
            'power' => $power,
            'level' => $level,
            'sort' => isset($sort) ? $sort : 0,
            'method' => isset($method) ? $method : ''
        ];
    }
}
