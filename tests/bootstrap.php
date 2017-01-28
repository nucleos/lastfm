<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$files = array_filter(array(
    __DIR__.'../../vendor/autoload.php',
    __DIR__.'../../../vendor/autoload.php',
), 'file_exists');
if (count($files) > 0) {
    require_once current($files);
}
