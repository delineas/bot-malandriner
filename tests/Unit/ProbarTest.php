<?php


namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class Subject
{
    protected $observers = array();

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function attach(Observer $observer)
    {
        $this->observers[] = $observer;
    }

    public function doSomething()
    {
        // Do something.
        // Notify observers that we did something.
        $this->notify('something');
    }

    public function doSomethingBad()
    {
        foreach ($this->observers as $observer) {
            $observer->reportError(42, 'Something bad happened', $this);
        }
    }

    protected function notify($argument)
    {
        foreach ($this->observers as $observer) {
            $observer->update($argument);
        }
    }

    // Other methods.
}

/**
 * @method update($args)
 */
class Observer
{
    public function update($argument)
    {
        // Do something.
    }

    public function reportError($errorCode, $errorMessage, Subject $subject)
    {
        // Do something
    }

    // Other methods.
}

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testObserversAreUpdated()
    {
        $observer = $this->prophesize(Observer::class);
        //$observer->update("somethig")->willReturn('');
        $observer->update(new \Prophecy\Argument\Token\ExactValueToken('something'))->shouldBeCalledTimes(1);

        // Create a Subject object and attach the mocked
        // Observer object to it.
        $subject = new Subject('something');
        $subject->attach($observer->reveal());

        $subject->doSomething();
    }
}
