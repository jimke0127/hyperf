<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/19
 * Time: 14:50
 */

namespace App\Annotation;


use Doctrine\Common\Annotations\Annotation\Target;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 * Class PreAuthorization
 * @package App\Annotation
 */
class PreAuthorization extends AbstractAnnotation
{
    /**
     * 权限标识
     * @var string
     */
    public string $value;

    public function __construct($value="")
    {
        parent::__construct($value);
        $this->bindMainProperty("value", $value);
    }
}