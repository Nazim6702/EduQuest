<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerSxWxDyM\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerSxWxDyM/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerSxWxDyM.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerSxWxDyM\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerSxWxDyM\App_KernelDevDebugContainer([
    'container.build_hash' => 'SxWxDyM',
    'container.build_id' => 'af827a23',
    'container.build_time' => 1743605326,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerSxWxDyM');
