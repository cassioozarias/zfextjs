<?php

namespace Loja;

use Zend\Mvc\MoudeRouteListener,
    Zend\Mvc\MvcEvent,
    Zend\ModuleManager\ModuleManager;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as  SessionStorage;
    
        
use Loja\Model\CategoriaTable;
use Loja\Service\Categoria as CategoriaService;
use Loja\Service\Instrumento as InstrumentoService;
use Loja\Service\Musico as MusicoService;
use Loja\Service\User as UserService;
use LojaAdmin\Form\Instrumento as InstrumentoFrm;
use LojaAdmin\Form\Musico as MusicoFrm;


use Loja\Auth\Adapter as AuthAdapter;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ . 'Admin' => __DIR__ . '/src/' . __NAMESPACE__ . "Admin",
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function onBootstrap($e) {
        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
                    $controller = $e->getTarget();
                    $controllerClass = get_class($controller);
                    $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
                    $config = $e->getApplication()->getServiceManager()->get('config');
                    if (isset($config['module_layouts'][$moduleNamespace])) {
                        $controller->layout($config['module_layouts'][$moduleNamespace]);
                    }
                }, 98);
    }
    
    public function init(ModuleManager $moduleManager) {
         $shareEvents = $moduleManager->getEventManager()->getSharedManager();
         $shareEvents->attach("LojaAdmin", 'dispatch', function($e) {
            $auth = new AuthenticationService;
            $auth->setStorage(new SessionStorage("LojaAdmin"));
            
            $controller = $e->getTarget();
            $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
            
        if (!$auth->hasIdentity() and ($matchedRoute == "loja-admin" or $matchedRoute == "loja-admin-interna")) {
            return $controller->redirect()->toRoute('loja-admin-auth');
        }  
         }, 99);
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Loja\Model\CategoriaService' => function($service) {
                    $dbAdapter = $service->get('Zend\Db\Adapter\Adapter');
                    $categoriaTable = new CategoriaTable($dbAdapter);
                    $categoriaService = new Model\CategoriaService($categoriaTable);
                    return $categoriaService;
                },
                'Loja\Service\Categoria' => function($service) {
                    return new CategoriaService($service->get('Doctrine\ORM\EntityManager'));
                },
                 'Loja\Service\Instrumento' => function($service) {
                    return new InstrumentoService($service->get('Doctrine\ORM\EntityManager'));
                },
                  'Loja\Service\Musico' => function($service) {
                    return new MusicoService($service->get('Doctrine\ORM\EntityManager'));
                },      
                  'Loja\Service\User' => function($service) {
                    return new UserService($service->get('Doctrine\ORM\EntityManager'));
                },      
                  'LojaAdmin\Form\Instrumento' => function($service) {
                    $em = $service->get('Doctrine\ORM\EntityManager');
                    $repository = $em->getRepository('Loja\Entity\Categoria');
                    $categorias = $repository->fetchPairs();
                    return new InstrumentoFrm(null, $categorias);
                },
                  'LojaAdmin\Form\Musico' => function($service) {
                    $em = $service->get('Doctrine\ORM\EntityManager');
                    $repository = $em->getRepository('Loja\Entity\Categoria');
                    $categorias = $repository->fetchPairs();
                    return new MusicoFrm(null, $categorias);
                },
                       
                  'Loja\Auth\Adapter' => function($service) {
                    return new AuthAdapter($service->get('Doctrine\ORM\EntityManager'));
                },      
            ),
        );
    }
    public function getViewHelperConfig() {
        return array(
            'invokables' => array(
                'UserIdentity'=>new View\Helper\UserIdentity()
            )
        );
    }
}
