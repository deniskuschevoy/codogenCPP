<?php

class OutputsProcessor
{
   protected $mTwig;
   protected $mBaseDirectory;
   protected $mGenericMappings;
   
   public function __construct( Twig_Environment &$twig, &$baseDirectory, &$genericMappings )
   {
      if ( !file_exists($baseDirectory) || !is_dir($baseDirectory) ) throw new \InvalidArgumentException("Output folder '$baseDirectory' cannot be found or is not a directory");
      if ( $genericMappings == null || !is_array($genericMappings) ) throw new \InvalidArgumentException("Generic mappings have to be a not null array");
      
      $this->mTwig = $twig;
      $this->mBaseDirectory = $baseDirectory;
      $this->mGenericMappings = $genericMappings;
   }
   
   public function GenerateOutputs( &$outputs, &$entities )
   {
      if ( $outputs === null ) throw new \InvalidArgumentException("List of outputs is null");
      if ( !is_array($outputs) ) throw new \InvalidArgumentException("Outputs must be a list");
      if ( $entities === null ) throw new \InvalidArgumentException("Entities is null");


      Logger::log("Generation of outputs is started");
      foreach ( $outputs as $k => $output )
      {
         Logger::log("Processing output \"$k\"");
         
         $output_path = $this->mBaseDirectory . DIRECTORY_SEPARATOR . $output["Path"] . DIRECTORY_SEPARATOR . $output["Name"];
         $template = $this->mGenericMappings["OutputTypes"][$output["Type"]];
         Logger::log("Output path: \"$output_path\". Template to use: \"$template\"");

         $content = $this->mTwig->render( $template, array(
            "output" => $output,
            "entities" => $entities,
            "generic_mappings" =>$this->mGenericMappings
         ) );
         
         file_put_contents( $output_path, $content );
      }
   }
}