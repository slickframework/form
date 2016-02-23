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
use Slick\Validator\AbstractValidator;
use Slick\Validator\ValidatorInterface;

/**
 * Required Upload validator
 *
 * @package Slick\Form\Input\Validator
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class RequiredUpload extends AbstractValidator implements ValidatorInterface
{

    /**
     * Error messages
     * @var string[]
     */
    protected $uploadErrors = [
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload. ',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_FORM_SIZE  => 'Uploaded file exceeds the HTML form MAX_FILE_SIZE.',
        UPLOAD_ERR_INI_SIZE   => 'Uploaded file exceeds the php.ini upload_max_filesize.',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    ];

    /**
     * @var array Error messages templates
     */
    protected $messageTemplate = 'Required upload fail: %s';


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
        if ($file->getError() == UPLOAD_ERR_NO_FILE) {
            $valid = false;
            $this->addMessage(
                $this->messageTemplate,
                $this->uploadErrors[$file->getError()]
            );
        }
        return $valid;
    }
}