<?php

namespace Solveda\Brand\Model\Config\Backend;

class CertificateFileType extends \Magento\Config\Model\Config\Backend\File
{
    /**
     * @return string[]
     */
    public function _getAllowedExtensions()
    {
        return ['png', 'jpg', 'jpeg', 'gif'];
    }
}
