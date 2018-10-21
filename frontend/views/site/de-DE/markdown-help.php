<?php
use apc\markdown\Markdown;
use yii\bootstrap\Html;

/* @var $this yii\web\View */
$this->title = 'APC Markdown Hilfe';
?>
<div class="site-markdown-help">
<h1><?= Html::encode($this->title) ?></h1>

<p><strong>Ban the Can</strong> bietet den Gebrauch von Markdown und Emojis innerhalb gewissen Datenbereiche.
    Im Moment sind das, die Beschreibung und Ptotokoll Felder bei Tickets und die Bescreibung bei Aufgaben.</p>

    <strong>APC Markdown</strong> stammt aus dem Standard bei Yiim, was <a target="_blank" href="https://github.com/cebe/markdown">Cebe Markdown</a> verwendet.
    Das "default flavor" ist <a target = "_blank" href="https://daringfireball.net/projects/markdown/syntax">Daring Fireball</a>.<br>
    <h3>Der Standard wird duch zwei Möglichkeiten ergänzt:</h3>
    <ul>
        <li>Die Verwendung von Emojis</li>
        <li>Die zusätzliche Möglichkeit <strong>APC-Emojis</strong> zu verwenden. Weil so was in Ban-The-Can oft verwendet wird, dient dies
            der Bequemlichkeit</li>
    </ul>
</p>

<h2>Was ist Markdown?</h2>
    <p>Markdown ist eine vereinfachte Weise Texte zu formatieren. Wenn <em>markdown formatting options</em> in Standard Texte vorkommen,
        wird der Text mit Anwendung der Format-Optionen angezeigt. Mit Markdown kann mann die Lesbarkeit und 
        ästhetische Qualität eines Texts deutlich verbessern.
    </p>
<h2>Allgemeiner Markdown</h2>
    <p><small><em>Dies ist eine Teilmenge aller Möglichkeiten. Alle Möglichkeiten findet man bei <a target = "_blank" href="https://daringfireball.net/projects/markdown/syntax">Daring Fireball</a></em></small></p>
    <table>
        <tr>
            <th>Markdown</th>
            <th>Ergebnis</th>
            <th>Gebrauch</th>
        </tr>
        <tr>
            <td>#</td>
            <td><h1>Überschrift Ebene Eins</h1></td>
            <td>Place a <strong>#</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>##</td>
            <td><h2>Überschrift Ebene Zwei</h2></td>
            <td>Place a <strong>##</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>###</td>
            <td><h3>Überschrift Ebene Drei</h3></td>
            <td>Place a <strong>##</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>####</td>
            <td><h4>Überschrift Ebene Vier</h4></td>
            <td>Place a <strong>####</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>#####</td>
            <td><h5>Überschrift Ebene Fünf</h5></td>
            <td>Place a <strong>#####</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>######</td>
            <td><h6>Überschrift Ebene Sechs</h6></td>
            <td>Place a <strong>######</strong> am Anfang einer Textzeile</td>
        </tr>
        <tr>
            <td>- List Item Eins<br>- List Item Zwei</td>
            <td><ul><li>List Item Eins</li><li>List Item Zwei</li></ul></td>
            <td>Place a <strong>-</strong> am Anfang einer Textzeile, um eine Listitem darzustellen</td>
        </tr>
        <tr>
            <td>- List Item Eins<br>&nbsp;&nbsp;&nbsp;- Indented List Item Two</td>
            <td><ul><li>List Item Eins<ul><li>List Item Zwei</li></ul></li></ul></td>
            <td>Indent the <strong>-</strong> am Anfang einer Textzeile, um eine Listitem eingerückt darzustellen</td>
        </tr>
        <tr>
            <td>&lt;http://example.com&gt;</td>
            <td><a href="http://example.com/">http://example.com/</a></td>
            <td>Link mit URL als Text</td>
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

<h2>General Emoji Usage</h2>
    <p><small><em>Ein Emoji Charaker can dargestellt werden, indem man das Emoji code im als HTML Zeichen im Text eingibt.
                Siehe <a target = "_blank" href="https://unicode.org/emoji/charts/full-emoji-list.html">Emoji Liste</a> für eine a Liste aller Emoji Zeichen.
                Emoji-Codes werden auch vom Markdown erkannt, so dass ein Code-Name zwischen zwie <strong>:</strong> Zeichen reicht, um das Emoji darzustellen
            </em></small></p>
<table>
    <tr>
        <th>Markdown</th>
        <th>Ergebnis</th>
        <th>Gebrauch</th>
    </tr>
    <tr>
        <td>&amp;#x1f609;</td>
        <td>&#x1f609;</td>
        <td>Gebrauch des UTF Emoji Codes</td>
    </tr>
    <tr>
        <td>:wink:</td>
        <td><?php echo Markdown::process(':wink:'); ?></td>
        <td>Gebrauch des Emoji Namens</td>
    </tr>
    <tr>
        <td>:wink&lt;red:</td>
        <td><?php echo Markdown::process(':wink<red:'); ?></td>
        <td>Änderung der Farbe</td>
    </tr>
    <tr>
        <td>:200&gt;wink:</td>
        <td><?php echo Markdown::process(':200>wink:'); ?></td>
        <td>Änderung der Größe</td>
    </tr>
    <tr>
        <td>:300&gt;wink&lt;green:</td>
        <td><?php echo Markdown::process(':300>wink<green:'); ?></td>
        <td>Änderung der Farbe und Größe</td>
    </tr>
    <tr>
        <td>:250&gt;church&lt;blue:</td>
        <td><?php echo Markdown::process(':250>church<blue:'); ?></td>
        <td>Ein weiteres Beispiel</td>
    </tr>
</table>
<h2>APC Emoji Gebrauch</h2>
    <p><small><em>APC Markdown definiert weitere Emoji Codes, die zu Verfügung stehen.
            Das Ergebnis solcher Codes könnte anderswie erreicht werden, wie oben beschrieben.
            Sie sind da, um die Verbraucherfreuundlichkeit zu erhöhen.</em></small></p>

    <table>
        <tr>
            <th>Markdown</th>
            <th>Ergebnis</th>
            <th>Gebrauch</th>
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
