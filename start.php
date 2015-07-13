<?php

include "/src/Utils/Logger.php";
include "/src/Utils/ScriptParameters.php";
include "/src/Loader.php";
include "/src/Twig/TwigLoader.php";
include "/src/Formatters/CPPFormatedOutputsProcessor.php";

Logger::log("=== Generator started ===");

$ScriptParameters = ScriptParameters::fromArgv( __DIR__ );

// Getting mapping configuration array from configuration file
$mappingsConfiguration = Loader::LoadData($ScriptParameters->getMappingFilename(), Loader::TYPE_MAPPING);

// Getting interface configuration array from configuration file
$classesConfiguration = Loader::LoadData( $ScriptParameters->getConfigurationFilename(), Loader::TYPE_CLASSES );

// Preparing templating engine
$Twig = TwigLoader::Load( $ScriptParameters->getTemplatesDirectories());

// Preparing generator processor
$OProcessor = new CPPFormatedOutputsProcessor( $Twig, $ScriptParameters->getOutputDirectory(), $mappingsConfiguration->GetGenericMappings() );

// Generating outputs
$OProcessor->GenerateOutputs( $mappingsConfiguration->GetOutputs(), $classesConfiguration->GetEntities() );

Logger::log("=== Generator finished ===");