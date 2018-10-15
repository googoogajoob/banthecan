<?php

namespace apc\markdown\inline;
/**
 * Sample code
 */
trait EmojiTrait
{
    protected $sizeMarker = '>';
    protected $colorMarker = '<';

    /** @var array */
    protected $emojiMap = null;

    /**
     * @marker :
     */
    protected function parseEmoji($markdown)
    {
        if (preg_match('/^:\d*' . $this->sizeMarker .'*([\w\d-]+)' . $this->colorMarker . '*\w*:/', $markdown, $matches)) {
            return [
                [
                    'emoji',
                    [['text', trim($matches[0], " \t\n\r\0\x0B:")]],
                ],
                strlen($matches[0])
            ];
        }
        return [['text', $markdown[0]], 1];
    }

    protected function renderEmoji($block)
    {
        if ($this->emojiMap === null) {
            $this->emojiMap = require __DIR__ . '/emoji-map.php';
        }

        $name = $this->renderAbsy($block[1]);

        list($size, $emoji, $color) = $this->parseEmojiComponents($name);

        if (isset($this->emojiMap[$emoji])) {

            if ($size || $color) {
                $size .= '%';
                $emojiHtmlPrefix = '<span style="font-size: ' . $size . '; color: ' . $color . '">';
                $emojiHtmlPostfix = '</span>';
            } else {
                $emojiHtmlPrefix = '';
                $emojiHtmlPostfix = '';
            }

            $emojiCharacter = '&#x' . strtolower($this->emojiMap[$emoji]) . ';';

            $emojiHtml = $emojiHtmlPrefix . $emojiCharacter . $emojiHtmlPostfix;

            return $emojiHtml;

        } else {
            return ':' . $name . ':';
        }
    }

    protected function parseEmojiComponents($apcEmojiString)
    {
        if (strpos($apcEmojiString, $this->sizeMarker) === false) {
            $apcEmojiString = $this->sizeMarker . $apcEmojiString;
        }
        if (strpos($apcEmojiString, $this->colorMarker) === false) {
            $apcEmojiString = $apcEmojiString . $this->colorMarker;
        }

        $apcEmojiString = str_replace($this->sizeMarker,  $this->colorMarker, $apcEmojiString);
        $components = explode($this->colorMarker, $apcEmojiString);

        return $components;
    }
}