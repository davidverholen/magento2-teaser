<?php
/**
 * TeaserItemInterface.php
 *
 * PHP Version 5
 *
 * @category magento2
 * @package  magento2
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */

namespace DavidVerholen\Teaser\Api\Data;

/**
 * Interface TeaserItemInterface
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Api\Data
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
interface TeaserItemInterface
{
    const TEASER_ITEM_ID = 'teaser_item_id';
    const TITLE = 'title';
    const CMS_BLOCK_IDENTIFIER = 'cms_block_identifier';
    const IMAGE_PATH = 'image_path';
    const MOBILE_IMAGE_PATH = 'mobile_image_path';
    const IS_ACTIVE = 'is_active';
    const MODIFIED_DATE = 'modified_date';
    const CREATION_DATE = 'creation_date';

    /**
     * getId
     *
     * @return integer
     */
    public function getId();

    /**
     * getCmsBlockIdentifier
     *
     * @return string
     */
    public function getCmsBlockIdentifier();

    /**
     * getTitle
     *
     * @return string
     */
    public function getTitle();


    /**
     * getImagePath
     *
     * @return string
     */
    public function getImagePath();

    /**
     * getMobileImagePath
     *
     * @return string
     */
    public function getMobileImagePath();

    /**
     * getIsActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * getModifiedDate
     *
     * @return string
     */
    public function getModifiedDate();

    /**
     * getCreationDate
     *
     * @return string
     */
    public function getCreationDate();

    /**
     * setTitle
     *
     * @param string $title
     *
     * @return TeaserItemInterface
     */
    public function setTitle($title);

    /**
     * setCmsBlockIdentifier
     *
     * @param string $cmsBlockIdentifier
     *
     * @return TeaserItemInterface
     */
    public function setCmsBlockIdentifier($cmsBlockIdentifier);

    /**
     * setImagePath
     *
     * @param string $imagePath
     *
     * @return TeaserItemInterface
     */
    public function setImagePath($imagePath);

    /**
     * setMobileImagePath
     *
     * @param string $mobileImagePath
     *
     * @return TeaserItemInterface
     */
    public function setMobileImagePath($mobileImagePath);

    /**
     * setIsActive
     *
     * @param boolean $isActive
     *
     * @return TeaserItemInterface
     */
    public function setIsActive($isActive);

    /**
     * setModifiedDate
     *
     * @param string $modifiedDate
     *
     * @return TeaserItemInterface
     */
    public function setModifiedDate($modifiedDate);

    /**
     * setCreationDate
     *
     * @param string $creationDate
     *
     * @return TeaserItemInterface
     */
    public function setCreationDate($creationDate);
}
