<?php
class Template
{
      protected $file;
      protected $values = [];

      public function __construct($file)
      {
            $this->file = $file;
      }

      public function set($key, $value)
      {
            $this->values[$key] = $value;
      }

      public function output()
      {
            if (!file_exists($this->file))
            {
                  die("Erro ao carregar o template do arquivo '$this->file'");
            }
            $output = file_get_contents($this->file);

            foreach ($this->values as $key => $value) {
                  $tagToReplace = "[@$key]";
                  $output = str_replace($tagToReplace, $value, $output);
            }

            return $output;
      }
}
