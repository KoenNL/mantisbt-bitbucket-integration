<?php

namespace Tools;

class EventHandler
{
    const HTTP_EVENT_HEADER = 'X-Event-Key';
    
    public function parseEvent($headers)
    {
        if (empty($headers[self::HTTP_EVENT_HEADER])) {
            throw new Exception('Header ' . self::HTTP_EVENT_HEADER . ' not set.');
        }
        $event = $headers[self::HTTP_EVENT_HEADER];
        if (!strpos($event, ':')) {
            throw new Exception('Invalid value ' . $event . ' for event.');
        }
        $event_properties = explode(':', $event);
        if (empty($this->event_keys[$event_properties[0]]['events'][$event_properties[1]])) {
            throw new Exception('Unknown event ' . $event);
        }
        return array(
            'event_class' => $event_properties[0],
            'event' => $event_properties[1]
        );
    }
}