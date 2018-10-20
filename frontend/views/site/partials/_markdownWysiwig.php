<?php

use apc\markdown\Markdown;
/* @var $inputId string */

?>
<div class="markdown-wysiwig-container">
    <div class="col-sm-offset-2 col-sm-6 bg-info markdown-wysiwig">
        <?php
            $iconList = [
                ':apc-checkmark:',
                ':apc-x:',
                ':apc-smiley:',
                ':apc-worried:',
                ':apc-thumbsup:',
                ':apc-thumbsdown:',
            ];

            $outputList = [];
            foreach ($iconList as $emojiCode) {
                $outputHtml = Markdown::process($emojiCode);
                $anchorTag = '<a onclick=' . "\"wysiwigEdit('$inputId', '$emojiCode');\"" . '>';
                $outputHtml = str_replace('<p>', $anchorTag, $outputHtml);
                $outputHtml = str_replace('</p>', '</a>', $outputHtml);
                $outputList[] = $outputHtml;
            }
            echo implode('', $outputList);
        ?>
        <span id="markdown-wysiwig-help-icon" class="glyphicon glyphicon-question-sign pull-right text-primary"></span>
    </div>
</div>

<div class="clearfix"></div>