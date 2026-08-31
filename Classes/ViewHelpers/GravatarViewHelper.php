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
        $email = is_string($this->arguments['email']) ? $this->arguments['email'] : '';
        $size = is_numeric($this->arguments['size']) ? (int)$this->arguments['size'] : 80;
        // Fluid casts an empty size to 0, which must not render a 1 pixel image
        $size = $size < 1 ? 80 : min(2048, $size);
        $default = is_string($this->arguments['default']) ? $this->arguments['default'] : 'mm';
        $rating = is_string($this->arguments['rating']) ? $this->arguments['rating'] : 'g';

        // gravatar hashes the trimmed and lowercased address
        $hash = md5(strtolower(trim($email)));
        $retinaSize = min(2048, $size * 2);

        $this->tag->addAttribute('src', $this->buildAvatarUrl($hash, $size, $default, $rating));
        if ($retinaSize > $size) {
            $this->tag->addAttribute(
                'srcset',
                $this->buildAvatarUrl($hash, $size, $default, $rating) . ' 1x, '
                . $this->buildAvatarUrl($hash, $retinaSize, $default, $rating) . ' 2x'
            );
        }
        $this->tag->addAttribute('width', (string)$size);
        $this->tag->addAttribute('height', (string)$size);
        return $this->tag->render();
    }

    protected function buildAvatarUrl(string $hash, int $size, string $default, string $rating): string
    {
        return 'https://www.gravatar.com/avatar/' . $hash
            . '?s=' . $size
            . '&d=' . urlencode($default)
            . '&r=' . $rating;
    }
}
