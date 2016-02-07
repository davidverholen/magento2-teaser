<?php
/**
 * ImageUploader.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Controller;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\DataObject;
use Magento\Framework\File\Uploader;
use Magento\Framework\File\UploaderFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;

/**
 * Class ImageUploader
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Controller
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
class ImageUploader extends DataObject
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var UploaderFactory
     */
    protected $uploaderFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * FileUploader constructor.
     *
     * @param Filesystem      $filesystem
     * @param UploaderFactory $uploaderFactory
     * @param LoggerInterface $logger
     * @param array           $data
     */
    public function __construct(
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        LoggerInterface $logger,
        array $data = []
    ) {
        parent::__construct($data);
        $this->filesystem = $filesystem;
        $this->uploaderFactory = $uploaderFactory;
        $this->logger = $logger;
    }

    /**
     * @param AbstractModel $model
     * @param               $fieldSet
     * @param               $field
     * @param               $path
     *
     * @param array         $allowedExtensions
     *
     * @return AbstractModel
     */
    public function upload(
        AbstractModel $model,
        $fieldSet,
        $field,
        $path,
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png']
    ) {
        if (empty($_FILES) || !isset($_FILES[$fieldSet]['name'][$field])) {
            return $model;
        }

        $value = $_FILES[$fieldSet]['name'][$field];

        if (is_array($value) && empty($value['name'])) {
            $model->setData($field, '');
            return $model;
        }

        $path = $this->filesystem
            ->getDirectoryRead(DirectoryList::MEDIA)
            ->getAbsolutePath($path);

        try {
            /** @var $uploader Uploader */
            $uploader = $this->uploaderFactory->create(['fileId' => [
                'tmp_name' => $_FILES['general']['tmp_name']['image_path'],
                'name' => $_FILES['general']['name']['image_path']
            ]]);
            $uploader->setAllowedExtensions($allowedExtensions);
            $uploader->setAllowRenameFiles(true);
            $result = $uploader->save($path);

            $model->setData($field, $result['file']);
        } catch (\Exception $e) {
            if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                $this->logger->critical($e);
            }
        }

        return $model;
    }
}
