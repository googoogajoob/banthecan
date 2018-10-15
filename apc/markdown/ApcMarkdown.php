<?php
/**
 * @copyright Copyright (c) 2014 Carsten Brandt
 * @license https://github.com/cebe/markdown/blob/master/LICENSE
 * @link https://github.com/cebe/markdown#readme
 */

namespace apc\markdown;

use cebe\markdown\Markdown;

class ApcMarkdown extends Markdown
{
	use inline\EmojiTrait;
}
