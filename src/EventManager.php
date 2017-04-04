<?php

namespace srayner\em;

use Psr\EventManager\EventManagerInterface;

class EventManager implements EventManagerInterface
{
    protected $listeners = [];
    
    /**
     * Attaches a listener to an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @param int $priority the priority at which the $callback executed
     * @return bool true on success false on failure
     */
    public function attach($event, $callback, $priority = 0)
    {
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }
        $this->listeners[$event]['callback'] = $callback;
        $this->listeners[$event]['priority'] = $priority;
    }

    /**
     * Detaches a listener from an event
     *
     * @param string $event the event to attach too
     * @param callable $callback a callable function
     * @return bool true on success false on failure
     */
    public function detach($event, $callback)
    {
        if (isset($this->listeners[$event])) {
            foreach($this->listeners[$event] as $key => $listener)
            {
                if ($listener['callback'] == $callback) {
                    unset($this->listeners[$event][$key]);
                }
            }
        }
    }

    /**
     * Clear all listeners for a given event
     *
     * @param  string $event
     * @return void
     */
    public function clearListeners($event)
    {
        unset($this->listeners($event));
    }

    /**
     * Trigger an event
     *
     * Can accept an EventInterface or will create one if not passed
     *
     * @param  string|EventInterface $event
     * @param  object|string $target
     * @param  array|object $argv
     * @return mixed
     */
    public function trigger($event, $target = null, $argv = array())
    {
        if (isset($this->listeners[$event])) {
            foreach ($this->listseners[$event] as $listner) {
                $listner['callback']($target, $argv);
            }
        }
    }
}
