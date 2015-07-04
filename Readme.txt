PHP: PAGEVIEWER
Please create a simple page viewer. Pages are plain text or HTML documents that are stored at a directory page or in a database (database schema included).
The coded application must search for pages by their name. The output must display a standards-compliant HTML document with page title and content. Please display execution time in milliseconds at the end of the output.

Specifications:

All plain text documents must be converted to HTML using the following rules:

Convert all URLs and emails into valid HTML links.
Convert all text lines followed one by one and surrounded with empty lines into an HTML paragraph.
Convert all paragraphs that end with a line filled by - (dash) or = (equation) into HTML header of first level.
Convert all paragraphs that start from two or more number signs into HTML headers of 2nd and other levels, depending on number of number signs.
Convert all paragraphs that start from asterisk into unordered list item. A few such paragraphs must be converted into a single unordered list with several list items.
Delivery:

Please create web application using pure PHP and MySQL without using any frameworks or libraries. Application structure must be made using OOP and MVC patterns. Please do not use global functions or global variables, use objects only.



Javascript: PUZZLE
Game applications must display the following elements:

Playing field with numbered tiles
Timer
Step counter
Basic UI controls (start/stop button and history button)
Game Specifications:

At the beginning, the tiles in playing field must be placed in correct order.
Once user presses Start button, the button must be renamed to Stop and tiles in playing field must reshuffled in random order.
Timer must indicate duration of time passed from game start in minutes and seconds .
Step counter must be increased by one when user moves any tile.
Once user presses Stop button, the tiles in playing field must be reverted to ordered state, timer dropped to 00:00 and step counter to 0. Stop button must be renamed to Start to let user start again.
Once user completed game (i.e. placed all tiles in correct order) application must stop timer and show History table with current result (time and step count) at the top of the table.
The same table must appear when user presses History button. Contents of the table must be stored in local browser storage.
Delivery:

The game must be delivered as a single HTML document with embedded CSS and JavaScript. Please, do not use images to decorate game.
