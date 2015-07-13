<?php

class ScriptParameters
{
   private $mConfigurationFilename;
   private $mOutputDirectory;
   private $mCommonTemplatesDirectory;
   private $mSpecificTemplatesDirectory;
   private $mMappingFilename;
   
   public function __construct( $iScriptBasePath, $iConfigurationFilename, $iOutputDirectory, $iSpecificTemplatesDirectory, $iMappingConfiguration )
   {
      if ( !$iConfigurationFilename ) throw new \InvalidArgumentException("Configuration name cannot be empty");
      if ( !file_exists($iConfigurationFilename) || filesize ($iConfigurationFilename) == 0 ) throw new \InvalidArgumentException("Configuration '$iConfigurationFilename' cannot be found or empty");
      
      $path_parts = pathinfo($iConfigurationFilename);
      if ( strtolower($path_parts['extension']) != "yml") throw new \InvalidArgumentException("Configuration filename extension shall be 'yml'");

      if ( !$iSpecificTemplatesDirectory ) throw new \InvalidArgumentException("Templates Folder cannot be empty");
      if ( !file_exists($iSpecificTemplatesDirectory) || !is_dir($iSpecificTemplatesDirectory) ) throw new \InvalidArgumentException("Templates Folder '$iSpecificTemplatesDirectory' cannot be found or is not a directory");
      

      if ( !$iMappingConfiguration ) throw new \InvalidArgumentException("Mapping name cannot be empty");
      if ( !file_exists($iMappingConfiguration) ) throw new \InvalidArgumentException("Configuration '$iMappingConfiguration' cannot be found");
      if ( filesize ($iMappingConfiguration) == 0) throw new \InvalidArgumentException("Configuration '$iMappingConfiguration' cannot be empty");

      $path_parts = pathinfo($iMappingConfiguration);
      if ( strtolower($path_parts['extension']) != "yml") throw new \InvalidArgumentException("Mapping filename extension shall be 'yml'");


      $this->mConfigurationFilename = $iConfigurationFilename;
      $this->mOutputDirectory = $iOutputDirectory;
      
      $this->mCommonTemplatesDirectory = $iScriptBasePath . '\templates';
      $this->mSpecificTemplatesDirectory = $iSpecificTemplatesDirectory;
      $this->mMappingFilename = $iMappingConfiguration;
   }
   
   public function getConfigurationFilename()
   {
      return $this->mConfigurationFilename;
   }
   
   public function getOutputDirectory()
   {
      return $this->mOutputDirectory;
   }
   
   public function getCommonTemplatesDirectory()
   {
      return $this->mCommonTemplatesDirectory;
   }
   
   public function getSpecificTemplatesDirectory()
   {
      return $this->mSpecificTemplatesDirectory;
   }
   
   public function getTemplatesDirectories()
   {
      return array( $this->getCommonTemplatesDirectory(), $this->getSpecificTemplatesDirectory() );
   }

   public function getMappingFilename()
   {
      return $this->mMappingFilename;
   }
   
   public static function fromArgv( $iScriptBasePath )
   {
      $shortopts  = "";
      $longopts  = array(
         "config:",
         "output:",
         "templates:",
         "mapping:"
      );

      $opts = getopt($shortopts,$longopts);
      
      if ( !isset($opts["config"]) || $opts["config"] == null )
         throw new \InvalidArgumentException("Parameter 'config' is required to specify data configuration. Use '--config=<value>' format");
      if ( !isset($opts["output"]) || $opts["output"] == null )
         throw new \InvalidArgumentException("Parameter 'output' is required to specify output folder. Use '--output=<value>' format");
      if ( !isset($opts["templates"]) || $opts["templates"] == null )
         throw new \InvalidArgumentException("Parameter 'templates' is required to specify path of specific templates. Use '--templates=<value>' format");
      if ( !isset($opts["mapping"]) || $opts["mapping"] == null )
         throw new \InvalidArgumentException("Parameter 'mapping' is required to specify path of mapping. Use '--mapping=<value>' format");
      
      $sp = new ScriptParameters( $iScriptBasePath, $opts["config"], $opts["output"], $opts["templates"], $opts["mapping"] );
      Logger::log("Read following parameters from command line: configuration file name - \"" . $sp->getConfigurationFilename() . "\". output filename - \"" . $sp->getOutputDirectory() . "\". mapping filename - \"".$sp->getMappingFilename()."\"");
      
      return $sp;
   }
   
   
}