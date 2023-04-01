<?php

namespace ContainerEx0NzT9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_Listener_Session_JwtService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'security.listener.session.jwt' shared service.
     *
     * @return \Symfony\Component\Security\Http\EventListener\SessionStrategyListener
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/EventListener/SessionStrategyListener.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Session/SessionAuthenticationStrategyInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Session/SessionAuthenticationStrategy.php';

        return $container->privates['security.listener.session.jwt'] = new \Symfony\Component\Security\Http\EventListener\SessionStrategyListener(new \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategy('migrate', NULL));
    }
}
