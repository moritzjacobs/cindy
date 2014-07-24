# Cindy 0.1b

based on [Stacey 2.3.0](http://staceyapp.com) by Anthony Kolber

# About Cindy

Cindy is a fork of Anthony Kolber's micro-CMS Stacey. Until now, Stacey's release versions depended on content in simple .txt files and a simple template language. With Stacey version 3 this is going to change, pursuing to use [YAML](http://www.yaml.org/) and [TWIG](http://twig.sensiolabs.org/) instead.

Cindy tries to maintain the principles of Stacey 2.3 and aspires to add functionality without breaking template and content compatibility to Stacey < 3.

Up until now we recommend using Stacey 2.3, you can get it at http://staceyapp.com


## Not a coder?
You can still help: we're collecting [[Ideas for additional functionality]].


## Overview
Stacey 2.3.0 takes content from `.txt` files, image files and implied directory structure and generates a website.
It is a no-database, dynamic website generator.

If you look in the `/content` and `/templates` folders, you should get the general idea of how it all works.

Cindy is a fork of Stacey without the YAML and Twig-Templating, trying to improve on old Stacey principles.


## Installation

Copy to server, `chmod 777 app/_cache`.

If you want clean urls, `mv htaccess .htaccess`

## Copyright/License

Cindy: Copyright © 2014 Moritz Jacobs. See `LICENSE` for details.

Stacey: Copyright © 2009 Anthony Kolber. See `LICENSE` for details.

Except PHP Markdown Extra which is (c) Michel Fortin (see `/app/parsers/markdown-parser.inc.php` for details) and
JSON.minify which is (c) Kyle Simpson (see 'app/parsers/json-minifier.inc.php' for details).
