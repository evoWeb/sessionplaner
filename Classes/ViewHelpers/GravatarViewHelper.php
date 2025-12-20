<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class GravatarViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'img';

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('email', 'string', 'Email address', true);
        $this->registerArgument('size', 'int', '[ 1 - 2048 ]', false, 80);
        $this->registerArgument('default', 'string', '[ 404 | mm | identicon | monsterid | wavatar ]', false, 'mm');
        $this->registerArgument('rating', 'string', '[ g | pg | r | x ]', false, 'g');
    }

    public function render(): string
    {
        $email = $this->arguments['email'];
        $size = $this->arguments['size'];
        $default = $this->arguments['default'];
        $rating = $this->arguments['rating'];

        $avatarUrl = 'https://www.gravatar.com/avatar/' . md5($email)
            . '?s=' . $size
            . '&d=' . urlencode($default)
            . '&r=' . $rating;

        $this->tag->addAttribute('src', $avatarUrl);
        $this->tag->addAttribute('width', $size);
        $this->tag->addAttribute('height', $size);
        return $this->tag->render();
    }
}
