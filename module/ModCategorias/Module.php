<?php

namespace SONApi;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        /** @var \Zend\EventManager\SharedEventManager $sharedEvents */
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'errorProcess'), 999);
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, array($this, 'checkAuth'), -50);
        $sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, array($this, 'postProcess'), -100);

    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function checkAuth(MvcEvent $e)
    {
        $headers = $e->getRequest()->getHeaders()->toArray();

        if (!isset($headers['X-Son-Token'])) {
            return $e->getResponse()->setStatusCode(405);
        }

        $token = $headers['X-Son-Token'];

        $uS = $e->getTarget()->getServiceLocator()->get('SONUser\Service\User');

        if (!$uS->checkAuth($token)) {
            return $e->getResponse()->setStatusCode(405);
        }
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function postProcess(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $formatter = $routeMatch->getParam('formatter', false);

        /** @var \Zend\Di\Di $di */
        $di = $e->getTarget()->getServiceLocator()->get('di');

        if ($formatter !== false) {
            if ($e->getResult() instanceof \Zend\View\Model\ViewModel) {
                if (is_array($e->getResult()->getVariables())) {
                    $vars = $e->getResult()->getVariables();
                } else {
                    $vars = null;
                }
            } else {
                $vars = $e->getResult();
            }

            /** @var PostProcessor\AbstractPostProcessor $postProcessor */
            $postProcessor = $di->get($formatter . '-pp', array(
                'response'   => $e->getResponse(),
                'vars'       => $vars,
                'serializer' => $e->getTarget()->getServiceLocator()->get('jms_serializer.serializer'),
            ));

            $postProcessor->process();

            return $postProcessor->getResponse();
        }

        return null;
    }

    /**
     * @param MvcEvent $e
     * @return null|\Zend\Http\PhpEnvironment\Response
     */
    public function errorProcess(MvcEvent $e)
    {

        $matchedRoute = $e->getRouteMatch();

        if($matchedRoute) {
            if($matchedRoute->getMatchedRouteName() == "restful") {
                /** @var \Zend\Di\Di $di */
                $di = $e->getApplication()->getServiceManager()->get('di');

                $eventParams = $e->getParams();

                /** @var array $configuration */
                $configuration = $e->getApplication()->getConfig();

                $vars = array();
                if (isset($eventParams['exception'])) {

                    /** @var \Exception $exception */
                    $exception = $eventParams['exception'];

                    if ($configuration['errors']['show_exceptions']['message']) {
                        $vars['error-message'] = $exception->getMessage();
                    }

                    if ($configuration['errors']['show_exceptions']['trace']) {
                        $vars['error-trace'] = $exception->getTrace();
                    }
                }

                if (empty($vars)) {
                    $vars['error'] = 'Something went wrong';
                }

                /** @var PostProcessor\AbstractPostProcessor $postProcessor */
                $postProcessor = $di->get(
                    $configuration['errors']['post_processor'],
                    array(
                        'vars' => $vars,
                        'response' => $e->getResponse(),
                        'serializer' => $e->getTarget()->getServiceLocator()->get('jms_serializer.serializer'))
                );

                $postProcessor->process();

                if (
                    $eventParams['error'] === \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND ||
                    $eventParams['error'] === \Zend\Mvc\Application::ERROR_ROUTER_NO_MATCH
                ) {
                    $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_501);
                } else {
                    $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_500);
                }

                $e->stopPropagation();

                return $postProcessor->getResponse();
            }
        }
    }

}
