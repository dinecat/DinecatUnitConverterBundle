<?php

/**
 * This file is part of the DinecatUnitConverterBundle package.
 * @link        https://github.com/dinecat/DinecatUnitConverterBundle
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 * @copyright   2012 DineCat, http://dinecat.com/
 * @license     MIT (full text in file LICENSE or by link http://dinecat.com/license/mit)
 */

namespace Dinecat\UnitConverterBundle\Unit;

/**
 * Base class for weight unit.
 * @package     DinecatUnitConverterBundle
 * @subpackage  Unit
 */
class Weight
{

    /**
     * Weight types.
     */
    const ATTR_WEIGHT_GRAM = 0;
    const ATTR_WEIGHT_KILOGRAM = 1;
    const ATTR_WEIGHT_GRAIN = 2;
    const ATTR_WEIGHT_OUNCE = 3;
    const ATTR_WEIGHT_POUND = 4;

    /**
     * @var array   $pairs  Calculated pairs for conversion
     */
    static protected $pairs = array(
        0 => array( 1 => 0.001, 2 => 15.43235835294143, 3 => 0.0352739619495804, 4 => 0.0022046226218488 ),
        1 => array( 0 => 1000.0, 2 => 15432.35835294143, 3 => 35.27396194958041, 4 => 2.204622621848776 ),
        2 => array( 0 => 0.06479891, 1 => 0.00006479891, 3 => 0.0022857142857143, 4 => 1.428571428571429e-4 ),
        3 => array( 0 => 28.349523125, 1 => 0.028349523125, 2 => 437.5, 4 => 0.0625 ),
        4 => array( 0 => 453.59237, 1 => 0.45359237, 2 => 7000.0, 3 => 16.0 )
    );

    /**
     * @var float|null  Base value
     */
    protected $value;

    /**
     * @var integer Type of base value
     */
    protected $type;

    /**
     * Constructor.
     * @param   number|null $weight Initial weight [optional, default null]
     * @param   integer     $type   Base weight type [optional, default self::ATTR_WEIGHT_GRAM]
     * @return  Weight
     */
    public function __construct( $weight = null, $type = self::ATTR_WEIGHT_GRAM )
    {
        if ( !isset( self::$pairs[$type] ) )
        {
            throw new \InvalidArgumentException( 'Undefined weight type.' );
        }
        $this->value = is_null( $weight ) ? null : (float) $weight;
        $this->type = $type;
    }

    /**
     * Get weight value in grams (g).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 0]
     * @return  float|null  Weight value in grams
     */
    public function getInGrams( $precision = 0 )
    {
        return $this->convertUnit( self::ATTR_WEIGHT_GRAM, $precision );
    }

    /**
     * Set weight value in grams (g).
     * @param   number  $weight Weight value
     * @return  Weight
     */
    public function setInGrams( $weight )
    {
        return $this->setValue( $weight, self::ATTR_WEIGHT_GRAM );
    }

    /**
     * Get weight value in kilograms (kg).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Weight value in kilograms
     */
    public function getInKilograms( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_WEIGHT_KILOGRAM, $precision );
    }

    /**
     * Set weight value in kilograms (kg).
     * @param   number  $weight Weight value
     * @return  Weight
     */
    public function setInKilograms( $weight )
    {
        return $this->setValue( $weight, self::ATTR_WEIGHT_KILOGRAM );
    }

    /**
     * Get weight value in grains (gr).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 0]
     * @return  float|null  Weight value in grains
     */
    public function getInGrains( $precision = 0 )
    {
        return $this->convertUnit( self::ATTR_WEIGHT_GRAIN, $precision );
    }

    /**
     * Set weight value in grains (gr).
     * @param   number  $weight Weight value
     * @return  Weight
     */
    public function setInGrains( $weight )
    {
        return $this->setValue( $weight, self::ATTR_WEIGHT_GRAIN );
    }

    /**
     * Get weight value in ounces (oz).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Weight value in ounces
     */
    public function getInOunces( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_WEIGHT_OUNCE, $precision );
    }

    /**
     * Set weight value in ounces (oz).
     * @param   number  $weight Weight value
     * @return  Weight
     */
    public function setInOunces( $weight )
    {
        return $this->setValue( $weight, self::ATTR_WEIGHT_OUNCE );
    }

    /**
     * Get weight value in pounds (lb).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Weight value in pounds
     */
    public function getInPounds( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_WEIGHT_POUND, $precision );
    }

    /**
     * Set weight value in pounds (oz).
     * @param   number  $weight Weight value
     * @return  Weight
     */
    public function setInPounds( $weight )
    {
        return $this->setValue( $weight, self::ATTR_WEIGHT_POUND );
    }

    /**
     * Convert weight value to requested type
     * @param   integer     $type       Weight type (ATTR_WEIGHT_* constants)
     * @param   integer     $precision  Decimal digits for rounding [optional, default 0]
     * @return  float|null  Weight value in requested type, rounded by precision
     * @throws  \InvalidArgumentException    If weight type is incorrect
     */
    public function convertUnit( $type, $precision = 0 )
    {
        if ( is_null( $this->value ) )
        {
            return null;
        }
        if ( $this->type == $type )
        {
            return round( $this->value, $precision );
        }
        elseif ( isset( self::$pairs[$this->type][$type] ) )
        {
            return round( $this->value * self::$pairs[$this->type][$type], $precision );
        }
        throw new \InvalidArgumentException( 'Undefined weight type.' );
    }

    /**
     * Set weight value.
     * @param   number  $weight Weight value
     * @param   integer $type   Weight type (ATTR_WEIGHT_* constants)
     * @return  Weight
     * @throws  \InvalidArgumentException    If weight type is incorrect
     */
    public function setValue( $weight, $type )
    {
        if ( !isset( self::$pairs[$type] ) )
        {
            throw new \InvalidArgumentException( 'Undefined weight type.' );
        }
        $this->value = (float) $weight;
        $this->type = $type;
        return $this;
    }

}

//EOF