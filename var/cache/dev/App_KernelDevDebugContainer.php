<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerHkVVEok\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerHkVVEok/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerHkVVEok.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerHkVVEok\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerHkVVEok\App_KernelDevDebugContainer([
    'container.build_hash' => 'HkVVEok',
    'container.build_id' => 'd3aa1cde',
    'container.build_time' => 1743762564,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerHkVVEok');
