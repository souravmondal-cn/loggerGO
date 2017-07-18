<?php

namespace AopAnnotation;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;
use Memcache;

/**
 * Caching aspect
 */
class ApplicationCacher implements Aspect {

    private $cache = null;

    public function __construct(Memcache $cache) {
        $cache->addServer('localhost');
        $this->cache = $cache;
    }

    /**
     * 
     * @param MethodInvocation $invocation Invocation
     * @Around("@execution(AopAnnotation\Cacheable)")
     */
    public function aroundCacheable(MethodInvocation $invocation) {
        $obj = $invocation->getThis();
        $class = is_object($obj) ? get_class($obj) : $obj;
        $methodName = $class . ':' . $invocation->getMethod()->name;
        $methodArguments = $invocation->getArguments();
        $memcache_key = 'student_id_'-$methodArguments[0];
        $result = $this->cache->get($memcache_key);
        if ($result === false) {
            $result = $invocation->proceed();
            $this->cache->set($memcache_key, $result);
        }

        return $result;
    }

}
