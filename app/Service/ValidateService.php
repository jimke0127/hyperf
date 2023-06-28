<?php
/**
 * Created by PhpStorm.
 * User: jack(jimke127@126.com)
 * Date: 2023/6/28
 * Time: 14:26
 */

namespace App\Service;


use Hyperf\Di\Annotation\Inject;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

class ValidateService
{
    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    public function validate($data, $rule, $errcode = 43000)
    {
        $message = [];
        $validator = $this->validationFactory->make($data, $rule, $message);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return [
                'errcode' => $errcode,
                'errmsg' => $errorMessage
            ];
        }
        return [
            'errcode' => 0,
            'errmsg' => 'ok'
        ];
    }
}