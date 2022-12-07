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

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('email', 'string', 'Email address', true);
        $this->registerArgument('size', 'int', '[ 1 - 2048 ]');
        $this->registerArgument('default', 'string', '[ 404 | mm | identicon | monsterid | wavatar ]');
        $this->registerArgument('rating', 'string', '[ g | pg | r | x ]');
    }

    public function render(): string
    {
        $defaultSize = 80;
        $defaultDefault = 'mm';
        $defaultRating = 'g';
        $email = $this->arguments['email'];
        $size = ($this->arguments['size'] ?? $defaultSize) ?: $defaultSize;
        $default = ($this->arguments['default'] ?? $defaultDefault) ?: $defaultDefault;
        $rating = ($this->arguments['rating'] ?? $defaultRating) ?: $defaultRating;

        $avatarUrl = 'https://www.gravatar.com/avatar/' . md5($email)
            . '?s=' . $size
            . '&d=' . urlencode($default)
            . '&r=' . $rating;

        $this->tag->addAttribute('src', $avatarUrl);
        $this->tag->addAttribute('width', (int)$size);
        $this->tag->addAttribute('height', (int)$size);
        return $this->tag->render();
    }
}
