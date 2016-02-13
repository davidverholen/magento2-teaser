<?php
/**
 * TeaserGroupInterface.php
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
 * Interface TeaserGroupInterface
 *
 * @category magento2
 * @package  DavidVerholen\Teaser\Api\Data
 * @author   David Verholen <david@verholen.com>
 * @license  http://opensource.org/licenses/OSL-3.0 OSL-3.0
 * @link     http://github.com/davidverholen
 */
interface TeaserGroupInterface
{
    const TEASER_GROUP_ID = 'teaser_group_id';
    const TITLE = 'title';
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
     * getTitle
     *
     * @return string
     */
    public function getTitle();

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
     * @return TeaserGroupInterface
     */
    public function setTitle($title);

    /**
     * setIsActive
     *
     * @param boolean $isActive
     *
     * @return TeaserGroupInterface
     */
    public function setIsActive($isActive);

    /**
     * setModifiedDate
     *
     * @param string $modifiedDate
     *
     * @return TeaserGroupInterface
     */
    public function setModifiedDate($modifiedDate);

    /**
     * setCreationDate
     *
     * @param string $creationDate
     *
     * @return TeaserGroupInterface
     */
    public function setCreationDate($creationDate);
}
