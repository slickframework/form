<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input\Validator;

use Psr\Http\Message\UploadedFileInterface;
use Slick\Form\Input\File;
use Slick\Validator\ValidatorInterface;

/**
 * Valid Upload validator
 *
 * @package Slick\Form\Input\Validator
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class ValidUpload extends RequiredUpload implements ValidatorInterface
{

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * The context specified can be used in the validation process so that
     * the same value can be valid or invalid depending on that data.
     *
     * @param mixed $value
     * @param array|mixed|File $context
     *
     * @return bool
     */
    public function validates($value, $context = [])
    {
        $valid = true;
        /** @var File $input */
        $input = $context['input'];
        /** @var UploadedFileInterface $file */
        $file = $input->getValue();
        if (
            $file->getError() != UPLOAD_ERR_OK &&
            $file->getError() != UPLOAD_ERR_NO_FILE
        ) {
            $valid = false;
            $this->addMessage(
                $this->messageTemplate,
                $this->uploadErrors[$file->getError()]
            );
        }
        return $valid;
    }
}