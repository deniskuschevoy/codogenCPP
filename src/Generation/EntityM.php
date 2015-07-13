<?php

include "EntityTypeM.php";
include "NamespaceM.php";
include "VisibilityM.php";
include "VariableM.php";
include "MethodM.php";

class EntityM
{
   protected $mType = null;
   protected $mNamespace = null;
   protected $mName = null;
   protected $mVisibility = null;
   protected $mIsAbstract = null;
   protected $mParents = null;
   protected $mVariables = null;
   protected $mMethods = null;
   protected $mIsConstant = null;
   protected $mTypeParametrs = null;
   
   static public function create( &$iDataArray )
   {
   	self::validateDescriptionArray( $iDataArray, true, true, true, true, true, true, true, true, true );

      $type = new EntityTypeM ( $iDataArray['Type'] );
      $namespace = new NamespaceM ( $iDataArray['Namespace'] );
      $name = $iDataArray['Name'];
      $visibility = new VisibilityM ( $iDataArray['Visibility'] );
      $isAbstract = $iDataArray['IsAbstract'] ? true : false;
      $parents = $iDataArray['Parents'];
      $variables = VariableM::createAsEntityVariables( $iDataArray['Variables'] );
      $methods = MethodM::createAsEntityMethods( $type, $iDataArray['Methods'] );
      $isConstant = $iDataArray['IsConstant'] ? true : false;
      $typeParametrs = VariableM::createAsTypeParametrs($iDataArray['TypeParameters']);
      
   	return new EntityM( $type, $namespace, $name, $visibility, $isAbstract, $parents, $variables, $methods, $isConstant, $typeParametrs );
   }
   
   static private function validateDescriptionArray(
      &$iDataArray, $iValidateType, $iValidateNamespace, $iValidateName, $iValidateVisibility, $iValidateIsAbstract,
      $iValidateParents, $iValidateVariables, $iValidateMethods, $iValidateIsConstant )
   {
   	if ( $iDataArray == null ) throw new \InvalidArgumentException("Entity description is null");
   	if ( !is_array($iDataArray) ) throw new \InvalidArgumentException("Entity description is not array");

      if ( $iValidateType && (!key_exists('Type', $iDataArray)) ) throw new \InvalidArgumentException("Entity type is not defined");
      if ( $iValidateNamespace && (!key_exists('Namespace', $iDataArray)) ) throw new \InvalidArgumentException("Entity namespace is not defined");
      if ( $iValidateName && (!key_exists('Name', $iDataArray)) ) throw new \InvalidArgumentException("Entity name is not defined");
      if ( $iValidateVisibility && (!key_exists('Visibility', $iDataArray)) ) throw new \InvalidArgumentException("Entity visibility is not defined");
      if ( $iValidateIsAbstract && (!key_exists('IsAbstract', $iDataArray)) ) throw new \InvalidArgumentException("Entity is abstract value is not defined");
      if ( $iValidateIsConstant && (!key_exists('IsConstant', $iDataArray)) ) throw new \InvalidArgumentException("Entity is constant value is not defined");
      if ( $iValidateParents && (!key_exists('Parents', $iDataArray)) ) throw new \InvalidArgumentException("Entity parents are not defined");
      if ( $iValidateParents && (!is_array($iDataArray["Parents"])) ) throw new \InvalidArgumentException("Entity parents is not an array");
      if ( $iValidateParents && (!key_exists('Interfaces', $iDataArray["Parents"])) ) throw new \InvalidArgumentException("Entity parent interfaces entities are not defined");
      if ( $iValidateParents && (!is_array($iDataArray["Parents"]["Interfaces"])) ) throw new \InvalidArgumentException("Entity parent interfaces is not an array");
      if ( $iValidateParents && (!key_exists('Logic', $iDataArray["Parents"])) ) throw new \InvalidArgumentException("Entity parent logic entities are not defined");
      if ( $iValidateParents && (!is_array($iDataArray["Parents"]["Logic"])) ) throw new \InvalidArgumentException("Entity parent logic is not an array");
      if ( $iValidateVariables && (!key_exists('Variables', $iDataArray)) ) throw new \InvalidArgumentException("Entity variables are not defined");
      if ( $iValidateMethods && (!key_exists('Methods', $iDataArray)) ) throw new \InvalidArgumentException("Entity methods are not defined");
   }
   
   protected function __construct( EntityTypeM $iType, $iNamespace, $iName, VisibilityM $iVisibility, $iIsAbstract, $iParents, $iVariables, $iMethods, $iConstant, $iTypeParametrs )
   {
      $this->mVisibility = $iVisibility;
      $this->mType = $iType;
      $this->mNamespace = $iNamespace;
      $this->mName = $iName;
      $this->mVisibility = $iVisibility;
      $this->mIsAbstract = $iIsAbstract;
      $this->mParents = $iParents;
      $this->mVariables = $iVariables;
      $this->mMethods = $iMethods;
      $this->mIsConstant = $iConstant;
      $this->mTypeParametrs = $iTypeParametrs;
   }

   public function getType()
   {
      return $this->mType;
   }
   
   public function getNamespace()
   {
      return $this->mNamespace;
   }
   
   public function getName()
   {
      return $this->mName;
   }
   
   public function getVisibility()
   {
      return $this->mVisibility;
   }
   
   public function getParents()
   {
      return $this->mParents;
   }
   
   public function getVariables()
   {
      return $this->mVariables;
   }
   
   public function getMethods()
   {
      return $this->mMethods;
   }
   
   public function getIsAbstract()
   {
      return $this->mIsAbstract;
   }

   public function getIsConstant()
   {
      return $this->mIsConstant;
   }

   public function getTypeParametrs()
   {
      return $this->mTypeParametrs;
   }

   public function getIsGeneric()
   {
      return count($this->mTypeParametrs) > 0;
   }
}