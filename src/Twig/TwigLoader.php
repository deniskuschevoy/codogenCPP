<?php

require_once '/../../lib/Twig/Autoloader.php';
include "HelpersExtension.php";

class TwigLoader
{
   public static function Load( &$iTemplatesPath )
   {
      if ( $iTemplatesPath == null ) throw new \InvalidArgumentException("Empty templates path given");
      if ( !is_array($iTemplatesPath) ) $iTemplatesPath = array (iTemplatesPath);

      foreach ( $iTemplatesPath as $path )
         if ( !file_exists($path) || !is_dir($path) ) throw new \InvalidArgumentException("Templates Folder '$path' cannot be found or is not a directory");
      
      Logger::log("Loading TWIG");
      Twig_Autoloader::register();
      $loader = new Twig_Loader_Filesystem($iTemplatesPath);
      if ( $loader == null ) throw new \RuntimeException("Cannot create Twig loader");
      $twig = new Twig_Environment($loader);
      if ( $twig == null ) throw new \RuntimeException("Cannot create Twig engine");
      
      Logger::log("TWIG Engine created. Adding extensions");
      $twig->addFilter('var_dump', new Twig_Filter_Function('var_dump'));
      $filter = new Twig_SimpleFilter('unpackString', function ($text) {
            $temp = substr(strpbrk($text, '::'),2);
            if (!empty($temp)) $text = $temp;
            $firstSymbol = mb_strtolower(substr($text,0,1));
            return $firstSymbol . substr($text, 1);
      });
      $twig->addFilter($filter);
      $twig->addExtension( new HelpersExtension() );
      
      Logger::log("TWIG Engine loaded successfully");
      return $twig;
   }

   private function unpackString($text)
   {
     
   }
}