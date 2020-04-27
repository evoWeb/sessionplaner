<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb\sessionplaner.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\ViewHelpers;

class GravatarViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
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
        $this->registerArgument('size', 'integer', '[ 1 - 2048 ]');
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
        $this->tag->addAttribute('width', (int) $size);
        $this->tag->addAttribute('height', (int) $size);
        return $this->tag->render();
    }
}
