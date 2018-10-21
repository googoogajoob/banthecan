<?php
use apc\markdown\Markdown;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
$this->title = 'APC Markdown Help';
?>
<div class="site-markdown-help">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><strong>Ban the Can</strong> offers the use of Markdown and Emojis with certain fields.
        At the moment this includes the description and protocol fields in Tickets and the Description field in Tasks.</p>

    <strong>APC Markdown</strong> is derived from the Yii standard <a target="_blank" href="https://github.com/cebe/markdown">Cebe Markdown</a> using
    the default flavor <a target = "_blank" href="https://daringfireball.net/projects/markdown/syntax">Daring Fireball</a>.<br>
    <h3>This basis is extended with two features:</h3>
    <ul>
        <li>The Use of Emojis</li>
        <li>A specialized set of <strong>APC-Emojis</strong> for frequent and convenient use within Ban-The-Can</li>
    </ul>
    </p>

    <h2>What is Markdown?</h2>
    <p>Markdown is simplified way of including formatting options to texts. By using certain <em>markdown formatting options</em>
        placed within standard texts, the text can be transformed when it is displayed to include a variety of enhancements.
        With the use of markdown the readability and aestethic qualities of a text can be greatly improved.
    </p>
    <h2>General Markdown</h2>
    <p><small><em>This is a subset of all the posibillities. For a full list see <a target = "_blank" href="https://daringfireball.net/projects/markdown/syntax">Daring Fireball</a></em></small></p>
    <table>
        <tr>
            <th>Markdown</th>
            <th>Result</th>
            <th>Usage</th>
        </tr>
        <tr>
            <td>#</td>
            <td><h1>Heading Level One</h1></td>
            <td>Place a <strong>#</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>##</td>
            <td><h2>Heading Level Two</h2></td>
            <td>Place a <strong>##</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>###</td>
            <td><h3>Heading Level Three</h3></td>
            <td>Place a <strong>##</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>####</td>
            <td><h4>Heading Level Four</h4></td>
            <td>Place a <strong>####</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>#####</td>
            <td><h5>Heading Level Five</h5></td>
            <td>Place a <strong>#####</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>######</td>
            <td><h6>Heading Level Six</h6></td>
            <td>Place a <strong>######</strong> at the start of any line of text</td>
        </tr>
        <tr>
            <td>- List Item One<br>- List Item Two</td>
            <td><ul><li>List Item One</li><li>List Item Two</li></ul></td>
            <td>Place a <strong>-</strong> at the start of any line of text to create a list item</td>
        </tr>
        <tr>
            <td>- List Item One<br>&nbsp;&nbsp;&nbsp;- Indented List Item Two</td>
            <td><ul><li>List Item One<ul><li>List Item Two</li></ul></li></ul></td>
            <td>Indent the <strong>-</strong> at the start of any line of text to create an indented list item</td>
        </tr>
        <tr>
            <td>&lt;http://example.com&gt;</td>
            <td><a href="http://example.com/">http://example.com/</a></td>
            <td>Link with URL as text</td>
        </tr>
        <tr>
            <td>[This link](http://example.net/) has no title attribute.</td>
            <td><a href="http://example.net/">This link</a> has no title attribute.</td>
            <td></td>
        </tr>
        <tr>
            <td>This is [an example](http://example.com/ "Title") inline link</td>
            <td>This is <a href="http://example.com/" title="Title"> an example</a> inline link.</td>
            <td></td>
        </tr>
        <tr>
            <td>*emphasis*</td>
            <td><em>emphasis</em></td>
            <td></td>
        </tr>
        <tr>
            <td>**strong**</td>
            <td><strong>strong</strong></td>
            <td></td>
        </tr>
    </table>

    <h2>Allgemeione Emoji Gebrauch</h2>
    <p><small><em>Any Emoji character can be displayed by typing the Emoji code as an HTML Code in the text.
                See <a target = "_blank" href="https://unicode.org/emoji/charts/full-emoji-list.html">Emoji List</a> for a list of Emoji Characters.
                In Addition Emoji-Codes are recognized by the Markdown processor, so that one must only insert the code between two <strong>:</strong> symbols
            </em></small></p>
    <table>
        <tr>
            <th>Markdown</th>
            <th>Result</th>
            <th>Usage</th>
        </tr>
        <tr>
            <td>&amp;#x1f609;</td>
            <td>&#x1f609;</td>
            <td>Direct use of the UTF Emoji Code</td>
        </tr>
        <tr>
            <td>:wink:</td>
            <td><?php echo Markdown::process(':wink:'); ?></td>
            <td>Using the Emoji Code</td>
        </tr>
        <tr>
            <td>:wink&lt;red:</td>
            <td><?php echo Markdown::process(':wink<red:'); ?></td>
            <td>Add a color adjustment</td>
        </tr>
        <tr>
            <td>:200&gt;wink:</td>
            <td><?php echo Markdown::process(':200>wink:'); ?></td>
            <td>Add a font size adjustment</td>
        </tr>
        <tr>
            <td>:300&gt;wink&lt;green:</td>
            <td><?php echo Markdown::process(':300>wink<green:'); ?></td>
            <td>Add a font size and color adjustment</td>
        </tr>
        <tr>
            <td>:250&gt;church&lt;blue:</td>
            <td><?php echo Markdown::process(':250>church<blue:'); ?></td>
            <td>Another example</td>
        </tr>
    </table>
    <h2>APC Emoji Usage</h2>
    <p><small><em>APC Markdown has defined additional Emoji Codes which can be used.
                The results of these codes could be achieved through other means as described above.
                They have been included for the sake of convenience</em></small></p>

    <table>
        <tr>
            <th>Markdown</th>
            <th>Result</th>
            <th>Usage</th>
        </tr>
        <tr>
            <td>:apc-checkmark:</td>
            <td><?php echo Markdown::process(':apc-checkmark:'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>:apc-x:</td>
            <td><?php echo Markdown::process(':apc-x:'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>:apc-smiley:</td>
            <td><?php echo Markdown::process(':apc-smiley:'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>:apc-worried:</td>
            <td><?php echo Markdown::process(':apc-worried:'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>:apc-thumbsup:</td>
            <td><?php echo Markdown::process(':apc-thumbsup:'); ?></td>
            <td></td>
        </tr>
        <tr>
            <td>:apc-thumbsdown:</td>
            <td><?php echo Markdown::process(':apc-thumbsdown:'); ?></td>
            <td></td>
        </tr>
    </table>
</div>
