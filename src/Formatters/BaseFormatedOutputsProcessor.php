<?php

include "/../Utils/OutputsProcessor.php";

class BaseFormatedOutputsProcessor extends OutputsProcessor
{  
   protected $FORMATTER_PATH = "src/Formats/defaults.cfg";

   public function GenerateOutputs( &$outputs, &$entities )
   {
      parent::GenerateOutputs( $outputs, $entities );
      ////////////////////////////
      foreach ( $outputs as $k => $output )
      {
         Logger::log("Formating output \"$k\"");
         
         $output_path = $this->mBaseDirectory . DIRECTORY_SEPARATOR . $output["Path"] . DIRECTORY_SEPARATOR . $output["Name"];

         Logger::log("Format path is " . $this->FORMATTER_PATH);
         exec('uncrustify.exe -c '  . $this->FORMATTER_PATH . ' --no-backup ' . $output_path);
      }
   }
}