<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerEx0NzT9\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerEx0NzT9/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerEx0NzT9.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerEx0NzT9\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerEx0NzT9\App_KernelDevDebugContainer([
    'container.build_hash' => 'Ex0NzT9',
    'container.build_id' => '9cc00d34',
    'container.build_time' => 1680332292,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerEx0NzT9');
