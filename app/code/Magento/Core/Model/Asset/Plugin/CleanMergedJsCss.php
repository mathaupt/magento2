<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magento\Core\Model\Asset\Plugin;

class CleanMergedJsCss
{
    /**
     * @var \Magento\Core\Helper\File\Storage\Database
     */
    protected $database;

    /**
     * @var \Magento\App\Filesystem
     */
    protected $filesystem;

    /**
     * @param \Magento\Core\Helper\File\Storage\Database $database
     * @param \Magento\App\Filesystem $filesystem
     */
    public function __construct(
        \Magento\Core\Helper\File\Storage\Database $database,
        \Magento\App\Filesystem $filesystem
    ) {
        $this->database = $database;
        $this->filesystem = $filesystem;
    }

    /**
     * Clean files in database on cleaning merged assets
     *
     * @param \Magento\View\Asset\MergeService $subject
     * @param callable $proceed
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundCleanMergedJsCss(
        \Magento\View\Asset\MergeService $subject,
        \Closure $proceed
    ) {
        $proceed();

        /** @var \Magento\Filesystem\Directory\ReadInterface $pubCacheDirectory */
        $pubCacheDirectory = $this->filesystem->getDirectoryRead(\Magento\App\Filesystem::PUB_VIEW_CACHE_DIR);
        $mergedDir = $pubCacheDirectory->getAbsolutePath() . '/' . \Magento\View\Asset\Merged::PUBLIC_MERGE_DIR;
        $this->database->deleteFolder($mergedDir);
    }
}
