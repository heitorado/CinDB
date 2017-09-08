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

$t = new Template("../App/Administracao/_template.php");
$t->set("path", "../");
$t->set("title", "CINDB TESTE");
$t->set("menu", "<li><a href='#'>dd</a></li>");
$t->set("pagTitle", "CINDB TESTE");
$t->set("content", "teste");
echo $t->output();
