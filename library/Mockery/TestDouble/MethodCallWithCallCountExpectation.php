<?php

namespace Mockery\TestDouble;

interface MethodCallWithCallCountExpectation 
{
    /**
     * @param mixed $returnValue
     *
     * @return void
     */
    function andReturn($returnValue);
}
