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
 * Base class for length unit.
 * @package     DinecatUnitConverterBundle
 * @subpackage  Unit
 */
class Length
{

    /**
     * Length types.
     */
    const ATTR_SIZE_MILLIMETRE = 0;
    const ATTR_SIZE_METRE = 1;
    const ATTR_SIZE_INCH = 2;
    const ATTR_SIZE_FOOT = 3;
    const ATTR_SIZE_YARD = 4;

    /**
     * @var array   $pairs  Calculated pairs for conversion
     */
    static protected $pairs = array(
        0 => array( 1 => 0.001, 2 => 0.0393700787401575, 3 => 0.0032808398950131, 4 => 0.0010936132983377 ),
        1 => array( 0 => 1000.0, 2 => 39.37007874015748, 3 => 3.280839895013123, 4 => 1.093613298337708 ),
        2 => array( 0 => 25.4, 1 => 0.0254, 3 => 0.0833333333333333, 4 => 0.0277777777777778 ),
        3 => array( 0 => 304.8, 1 => 0.3048, 2 => 12.0, 4 => 0.3333333333333333 ),
        4 => array( 0 => 914.4, 1 => 0.9144, 2 => 36.0, 3 => 3.0 )
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
     * @param   number|null $length Initial length [optional, default null]
     * @param   integer     $type   Base weight type [optional, default self::ATTR_SIZE_MILLIMETRE]
     * @return  Length
     */
    public function __construct( $length = null, $type = self::ATTR_SIZE_MILLIMETRE )
    {
        if ( !isset( self::$pairs[$type] ) )
        {
            throw new \InvalidArgumentException( 'Undefined length type.' );
        }
        $this->value = is_null( $length ) ? null : (float) $length;
        $this->type = $type;
    }

    /**
     * Get length value in millimetres (mm).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 0]
     * @return  float|null  Length value in millimetres
     */
    public function getInMillimetres( $precision = 0 )
    {
        return $this->convertUnit( self::ATTR_SIZE_MILLIMETRE, $precision );
    }

    /**
     * Set length value in millimetres (mm).
     * @param   number  $length Length value
     * @return  Length
     */
    public function setInMillimetres( $length )
    {
        return $this->setValue( $length, self::ATTR_SIZE_MILLIMETRE );
    }

    /**
     * Get length value in metres (mm).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Length value in metres
     */
    public function getInMetres( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_SIZE_METRE, $precision );
    }

    /**
     * Set length value in metres (mm).
     * @param   number  $length Length value
     * @return  Length
     */
    public function setInMetres( $length )
    {
        return $this->setValue( $length, self::ATTR_SIZE_METRE );
    }

    /**
     * Get length value in inches (in).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Length value in inches
     */
    public function getInInches( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_SIZE_INCH, $precision );
    }

    /**
     * Set length value in inches (in).
     * @param   number  $length Length value
     * @return  Length
     */
    public function setInInches( $length )
    {
        return $this->setValue( $length, self::ATTR_SIZE_INCH );
    }

    /**
     * Get length value in foots (ft).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Length value in foots
     */
    public function getInFoots( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_SIZE_FOOT, $precision );
    }

    /**
     * Set length value in foots (ft).
     * @param   number  $length Length value
     * @return  Length
     */
    public function setInFoots( $length )
    {
        return $this->setValue( $length, self::ATTR_SIZE_FOOT );
    }

    /**
     * Get length value in yards (yd).
     * @param   integer     $precision  Decimal digits for rounding [optional, default 2]
     * @return  float|null  Length value in yards
     */
    public function getInYards( $precision = 2 )
    {
        return $this->convertUnit( self::ATTR_SIZE_YARD, $precision );
    }

    /**
     * Set length value in yards (yd).
     * @param   number  $length Length value
     * @return  Length
     */
    public function setInYards( $length )
    {
        return $this->setValue( $length, self::ATTR_SIZE_YARD );
    }

    /**
     * Convert length value to requested type
     * @param   integer     $type       Length type (ATTR_SIZE_* constants)
     * @param   integer     $precision  Decimal digits for rounding [optional, default 0]
     * @return  float|null  Length value in requested type, rounded by precision
     * @throws  \InvalidArgumentException    If length type is incorrect
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
        throw new \InvalidArgumentException( 'Undefined length type.' );
    }

    /**
     * Set length value.
     * @param   number  $length Length value
     * @param   integer $type   Length type (ATTR_SIZE_* constants)
     * @return  Length
     * @throws  \InvalidArgumentException    If length type is incorrect
     */
    public function setValue( $length, $type )
    {
        if ( !isset( self::$pairs[$type] ) )
        {
            throw new \InvalidArgumentException( 'Undefined length type.' );
        }
        $this->value = (float) $length;
        $this->type = $type;
        return $this;
    }

}

//EOF