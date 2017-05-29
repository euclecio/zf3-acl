<?php

namespace User;

use User\Controller\Factory\AuthControllerFactory;
use User\Controller\AuthController;
use User\Service\Factory\AuthenticationServiceFactory;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;

/**
 * @author Euclécio Josias Rodrigues <eucjosias@gmail.com>
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, ControllerProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $container    = $e->getApplication()->getServiceManager();

        $eventManager->attach(MvcEvent::EVENT_DISPATCH,
            function (MvcEvent $e) use ($container) {
                $match       = $e->getRouteMatch();
                $authService = $container->get(AuthenticationServiceInterface::class);
                $routeName   = $match->getMatchedRouteName();
                $em          = $container->get(\Doctrine\ORM\EntityManager::class);

                /* Get Controller and Action */
                $matchedController = $match->getParam('controller');
                $matchedAction     = $match->getParam('action');
                /* Default Role */
                $role = 'Visitante';

                /* Check if user exists, if it has authenticated and set role */
                if ($authService->hasIdentity()) {
                    $user = $em->getReference(\User\Entity\User::class, $authService->getIdentity()->getId());
                    if(is_object($user)) {
                        $role = $user->getRole()->getName();
                    } else {
                        $match->setParam('controller', AuthController::class)
                              ->setParam('action', 'logout');
                    }
                }

                /* Valid ACL */
                $acl = $container->get(\Acl\Permissions\Acl::class);
                if (!$acl->isAllowed($role, $matchedController, $matchedAction)) {
                    if ($role == 'Visitante' && $routeName != 'login') {
                        $match->setParam('controller', AuthController::class)
                              ->setParam('action', 'login');
                    } else {
                        $response = $e->getResponse();
                        /* Location to page or whatever */
                        $response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . '/404');
                        $response->setStatusCode(303);
                    }
                }

            }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . "/../config/module.config.php";
    }

    public function getServiceConfig()
    {
        return [
            'aliases' => [
                AuthenticationService::class => AuthenticationServiceInterface::class
            ],
            'factories' => [
                AuthenticationServiceInterface::class => AuthenticationServiceFactory::class
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                AuthController::class => AuthControllerFactory::class
            ]
        ];
    }
}
