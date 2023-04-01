<?php

namespace ContainerEx0NzT9;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAuthFormService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Form\Type\AuthForm' shared autowired service.
     *
     * @return \App\Form\Type\AuthForm
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/FormTypeInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/AbstractType.php';
        include_once \dirname(__DIR__, 4).'/src/Form/Type/AuthForm.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/form/DataTransformerInterface.php';
        include_once \dirname(__DIR__, 4).'/src/Form/Transformer/RoleTransformer.php';

        return $container->privates['App\\Form\\Type\\AuthForm'] = new \App\Form\Type\AuthForm(new \App\Form\Transformer\RoleTransformer(($container->services['doctrine.orm.default_entity_manager'] ?? $container->getDoctrine_Orm_DefaultEntityManagerService())));
    }
}
