<?php

namespace AopAnnotation;

use Go\Aop\Aspect;
use Go\Aop\Intercept\FieldAccess;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Pointcut;
use Go\Lang\Annotation\AfterThrowing;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class ApplicationLogger implements Aspect {

    protected $logger;

    public function __construct() {
        $this->logger = new Logger('info');
        $this->logger->pushHandler(new StreamHandler(LOG_FILE));
    }

    /**
     * Method that will be called before real method
     *
     * @param MethodInvocation $invocation Invocation
     * @Before("execution(public Application\*->*(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation) {
        $obj = $invocation->getThis();
        $className = is_object($obj) ? get_class($obj) : $obj;
        $methodType = $invocation->getMethod()->isStatic() ? '::' : '->';
        $methodName = $invocation->getMethod()->getName();
        $methodArguments = json_encode($invocation->getArguments());
        $this->logger->info('Calling Before '.$className.$methodType.$methodName.' with Arguments - '.$methodArguments);
    }

    /**
     * Method that will be called after real method
     *
     * @param MethodInvocation $invocation Invocation
     * @After("execution(public **->*(*))")
     */
    public function afterMethodExecution(MethodInvocation $invocation) {
        $obj = $invocation->getThis();
        $className = is_object($obj) ? get_class($obj) : $obj;
        $methodType = $invocation->getMethod()->isStatic() ? '::' : '->';
        $methodName = $invocation->getMethod()->getName();
        $output = json_encode($invocation->proceed());
        $this->logger->warning('Calling After '.$className.$methodType.$methodName.' Returned results - '.$output);
    }

}
