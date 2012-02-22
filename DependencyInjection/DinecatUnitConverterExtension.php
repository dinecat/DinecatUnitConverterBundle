<?php

/**
 * This file is part of the DinecatUnitConverterBundle package.
 * @link        https://github.com/dinecat/DinecatUnitConverterBundle
 * @author      Nicolay N. Zyk <relo.san@gmail.com>
 * @copyright   2012 DineCat, http://dinecat.com/
 * @license     MIT (full text in file LICENSE or by link http://dinecat.com/license/mit)
 */

namespace Dinecat\UnitConverterBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\Config\FileLocator;

/**
 * Class for load and manage bundle configuration.
 * @package     DinecatUnitConverterBundle
 * @subpackage  DependencyInjection
 */
class DinecatUnitConverterExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load( array $configs, ContainerBuilder $container )
    {
        $loader = new XmlFileLoader( $container, new FileLocator( __DIR__ . '/../Resources/config' ) );
        $loader->load( 'services.xml' );
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'dinecat_unit_converter';
    }

}

//EOF