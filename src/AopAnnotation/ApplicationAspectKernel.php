<?php

namespace AopAnnotation;

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;
use Memcache;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel {

    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container) {
        $container->registerAspect(new ApplicationLogger());
        $container->registerAspect(new ApplicationCacher(new Memcache()));
    }

}
