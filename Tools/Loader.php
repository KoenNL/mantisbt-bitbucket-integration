<?php

namespace Tools;

class Loader
{

    public function load($event)
    {
        $namespace = $this->eventClassNameToNamespace($event);

        if (!class_exists($namespace)) {
            throw new Exception('Unable to load ' . $namespace . '. Class does not exist.');
        }

        return new $namespace;
    }
    
    public function parseEvent($event, $parser, $data)
    {
        $event_method = $this->eventNameToParseEvent($event);
        
        if (!method_exists($parser, $event_method)) {
            throw new Exception('Unable to run parser ' . $event_method . '. Method does not exist.');
        }
        
        return $parser->$event_method($data);
    }
    
    private function eventClassNameToNamespace($event)
    {
        return 'Event\\' . str_replace(' ', '', ucwords($event['event_class']));
    }
    
    private function eventNameToParseEvent($event)
    {
        return 'parse' . str_replace(' ', '', ucwords($event['event']));
    }
}
