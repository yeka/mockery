<?php

namespace Mockery\TestDouble;

use Mockery\TestDouble\Stub;

class StubTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function smoke_test()
    {
        $stub = new StubImpl;
        $stub->stub('foo')->toReturn(123);
        $stub->stub('bar')->with(123)->toReturn(123);
        $stub->stub('baz');
    }

    /** @test */
    public function it_throws_for_unknown_method_calls()
    {
        $stub = new StubImpl;

        $this->setExpectedException("Exception");
        $stub->foo();
    }

    /** @test */
    public function it_allows_us_to_ignore_all_calls()
    {
        $stub = new StubImpl;
        $stub->shouldIgnoreMissing();
        $stub->foo();
    }
}

class StubImpl implements Stub
{
    private $shouldIgnoreMissing = false;

    /**
     * @param  string   $method   The method to stub
     * @return StubMethod
     */
    public function stub($method)
    {
        $stubMethod = new StubMethodImpl();

        $this->stubMethods[] = $stubMethod;

        return $stubMethod;
    }

    /**
     * @return void
     */
    public function shouldIgnoreMissing()
    {
        $this->shouldIgnoreMissing = true;
    }

    public function __call($methodName, $args)
    {
        if ($this->shouldIgnoreMissing) {
            return;
        }

        throw new \Exception("Method not found");
    }
}

class StubMethodImpl implements StubMethod
{
    /**
     * @param mixed $arg     The first expected argument
     * @param mixed $arg,... The subsequent expected arguments
     *
     * @return StubMethodWithArguments
     */
    public function with($arg/*, $arg2..., $arg3...*/)
    {
        return $this;
    }

    /**
     * @param array $args The expected arguments
     *
     * @return StubMethodWithArguments
     */
    public function withArgs(array $args)
    {
        return $this;
    }

    /**
     * @return StubMethodWithArguments
     */
    public function withNoArgs()
    {
        return $this;
    }

    /**
     * @return StubMethodWithArguments
     */
    public function withAnyArgs()
    {
        return $this;
    }

    /**
     * @void
     */
    public function toReturn($value)
    {
    }
}

