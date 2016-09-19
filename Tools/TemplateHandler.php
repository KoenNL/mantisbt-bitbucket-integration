<?php

namespace Tools;

class TemplateHandler
{
    
    private $template;
    private $data = array();
    
    public function setTemplate($template)
    {
        $this->template = $template;
        
        return $this;
    }
    
    public function setData(array $data)
    {
        $this->data = $data;
        
        return $this;
    }
    
    public function processTemplate()
    {
        if (!$this->checkParameters()) {
            throw new Exception('Not all the required values were set in ' . __METHOD__);
        }
        
        $placeholder = array();
        
        preg_match_all('/{{([^}]*)}}/', $this->template, $placeholders);
        
        $result = $this->template;
        
        foreach ($placeholders as $placeholder) {
            if (isset($this->data[trim($placeholder)])) {
                $result = str_replace('{{' . $placeholder . '}}', $this->data[trim($placeholder)], $result);
            }
        }
        
        return $result;
    }
    
}