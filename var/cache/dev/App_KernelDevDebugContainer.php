<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerEyELIfD\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerEyELIfD/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerEyELIfD.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerEyELIfD\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerEyELIfD\App_KernelDevDebugContainer([
    'container.build_hash' => 'EyELIfD',
    'container.build_id' => 'cbfb15d8',
    'container.build_time' => 1743762296,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerEyELIfD');
