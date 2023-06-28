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

    /**
     * 数据验证
     * author:jack
     * date:2023/6/28 14:50
     * @param $data 验证的数据
     * @param $rule 验证规则
     * @param int $errcode 错误码
     * @param bool $custom 是否自定义错误说明
     * @return array
     */
    public function validate($data, $rule, $errcode = 43000, $custom = false)
    {
        $message = $custom ? $this->messages() : [];
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

    /**
     * 自定义错误说明
     * author:jack(jimke127@126.com)
     * date:2023/6/28 14:47
     * @return string[]
     */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.',
            'between' => 'The :attribute value :input is not between :min - :max.',
            'in' => 'The :attribute must be one of the following types: :values',
        ];
    }
}