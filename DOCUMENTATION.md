##Overview##
Cindy is a fork of [Stacey](http://staceyapp.com/), a framework used for
building simple dynamic html websites. Cindy, much like Stacey, is a
flat-file cms.

> A flat-file cms is a content management system that stores its content in
files and folders instead of a database (like a traditional cms). While a
database-based cms queries the database to retrieve content, a flat-file cms
reads data from a simple file and folder structure.

There are a few advantages to using a flat-file cms over a
traditional cms (say, like [Wordpress](https://wordpress.com/)).

1. **Speed** &mdash; by eliminating the need to connect to a database to
retrieve content, flat-file websites can be loaded extremely quickly
2. **Simple** &mdash; there's no need to "install" or "configure" anything
(it's simply a matter of uploading a few files)
3. **Secure** &mdash; since there is no database, you won't have to worry about
hackers stealing your database (and possibly other data in other databases or
tables)

While Stacey currently uses [YAML](http://www.yaml.org/) and their
impementation of the [TWIG](http://twig.sensiolabs.org/) templating language,
Cindy aims to keep the simplicity of  Stacey 2.3.0.

Cindy's purpose is to:

1. Separate the textual content & assets from your html, and to
2. Keep any non-semantic, "php-style" logic out of your templates
(unlike certain cms's)

This is managed via both the ``/content`` and ``/templates`` folders.

Included is a simple portfolio-style template, to provide an idea of
how the system works and what you can do with Cindy. But don't let that mislead
you &mdash; Cindy is flexible enough to build sites of a significant level of
complexity.

And if you cant't? Feel free to suggest a feature!

###Deployment###
Since Cindy is a flat-file cms, this means that it is posssible to quickly and
easily build and deploy sites. Additionally, as php hosting is the commonplace,
Cindy-based sites can be set up cost-effectively and on virtually any
standard hosting package.


###Caching###
Since file i.o. doesn't scale well for larger sites with more traffic,
Cindy's solution involves a combination of file-based caching and e-tag headers
to ensure that pages are loaded as quickly as possible. Cindy's caching system
will rebuild the cache whenever your content has been updated.


##Creating Pages##
Every folder within the ``/content`` directory containing a ``.txt`` file will
generate a separate page.

In order to create a new page, create a new folder in ``/content`` with a
``.txt`` file within it. The name of the ``.txt`` file will determine what
template is used to render the page.

ie. the ``.txt`` file, ``index.txt`` will use the ``index`` template located in
the ``/templates`` folder. Likewise, a file named ``page.txt`` will use the
``page`` template.

Pages are listed in reverse-numeric order, and can be ordered using a numbered
prefix before the page name (``10.``, ``9.``, ``8.``, etc.). The url used to
access that page is the folder name (without the number and dot).

ie. an ordered folder named: ``1.project-name`` will be accessed via
``http://yourdomain.com/projects/project-name``.



##Content Editing##
The ``_shared.txt`` file is stored within the ``/content`` directory. Any
variables stored here become ``@variables`` that can be accessed from any page
of your site.

``_shared.txt``
(the contents of ``_shared.txt``):

    name: ``Name``
    -
    profession: ``Graphic Designer``
    -
    email: ``hi@yourdomain.com``

Modifying these values will change the contents of ``@name``, ``@profession``,
and ``@email``.


###Text file encoding###
It's recommended that ``.txt`` files are saved using UTF-8 encoding. Not
only does this ensure that strange characters are not parsed (that could
possibly break Cindy's functionality), but this allows you to use
[special characters](http://en.wikipedia.org/wiki/Special_characters) and
[double-byte characters](http://en.wikipedia.org/wiki/Double_Byte_Character_Set).

You can read more about [text files](http://en.wikipedia.org/wiki/Text_file) &
[UTF-8 encoding](http://en.wikipedia.org/wiki/UTF-8) on
[Wikipedia](http://www.wikipedia.org/).


###Editing content###
Each folder that to be rendered as a page must have a ``.txt`` file inside
it (even if this text file is empty). The ``.txt`` file name should match up a
template file in the ``/templates`` folder, as this is how Cindy knows which
template to use for each page.


###How @variables are created###

1. Your browser visits a page. For exaxmple, let's say the url is
``http://yourdomain.com/?/about/``. If you have clean-urls enabled, it'll
redirect to ``http://yourdomain.com/about/``
2. Cindy then reads the content file stored in ``/content/3.about``. In this
case, ``/content/3.about/content.txt``.

        title: About Title
        -
        content:
        Lorem ipsum.
3. Two variables are created from the keys & value pairs within the ``.txt``
file: ``@title`` & ``@content``. These will be available for use within your
templates. (In addition, any variables already defined in your ``_shared.txt``
file are also available for use within the templates.)
4. Cindy finds the matching template file (the template with the same name as
the ``.txt`` file), in this case,
``/templates/content.html``
    So this template code:
        <div id="main">
          <h1>@title</h1>
          @content
        </div>
      transforms into this HTML:
        <div id="main">
          <h1>About Title</h1>
          <p>Lorem ipsum.</p>
        </div>

Notice how regardless of the presence of a line-break after the key declaration,
(``content``, and ``title``), the variable's contents are set the same way.

ie.

    title: This is a title!
    -

produces exactly the same results as:

    title:
    This is a title!
    -

Alright, cool.


###Content file format###
The key-value pairs all follow a standard format: each ``key`` is followed by a
colon (``:``), then its ``value``, a line-break (``"\r\n"`` for you RegEx geeks),
with a hyphen (``-``) to close the value.

    key: value
    -

The keys match up with ``@variable`` markers in the template files, which get
replaced with the contents of the value. You can create as many of your own
keys as needed.


####Keys####
A key (the ``@variable`` name) may **only** contain the following characters:
``abcdefghijklmnopqrstuvwxyz0123456789_``

Essentially, this implies only lowercase Latin alphanumeric characters and
underscores are allowed. Or, if you prefer the RegEx, anything which can be
matched by the following regular expression
([RegEx](http://en.wikipedia.org/wiki/Regular_expression)): ``/[a-z0-9_]+?:/``

Here's a sample ``content.txt`` file:

    title: The Test Project 1
    -
    date: 2009, Jun—
    -
    content:
    Lorem ipsum dolor...


####Separating Keys & Values####
Each value should be followed by a line containing only a hyphen character.
Even though the parser is somewhat forgiving of any accidental whitespace
(tabs or spaces), this is no excuse to get sloppy. Unexpected results may occur
if you've missed a hyphen.

The hyphen is optional on the last key/value pair, much like the optional
semicolon in css.

    title:  The Test Project 1
    -
    date: ...

####Empty Values####
If you want one of the values to be empty, just leave a space after the colon.

    title:
    -
    date: ...


####@path####
Additionally, the ``@path`` variable is exposed to your content files, which is
useful for linking to assets within the current folder. It will return the
relative path to the containing folder of the current page.

ie. using the ``@path`` variable on the page
``http://yourdomain.com/content/4.projects/10.project-1`` will return
``../content/4.projects/10.project-1``


####@bypass_cache####
In order to bypass the caching system for a specific page, you can add
``@bypass_cache: true`` to the text file. Any requests to this page will no
longer be cached by Stacey.

Note: This does not affect the caching done by web spiders and robots. That
depends on whether these robots obey your settings in ``robots.txt``.

You may find ``@bypass_cache`` useful for pages using randomized variables or
PHP code.


###Markdown###
Any values containing one or more newline characters (line-breaks) will be
parsed as [Markdown](http://daringfireball.net/projects/markdown/).

Within the following example, the string ``@title`` will come through as
plain text, as it has not been defined as a ``@variable`` in the text file.
However, the data stored in ``@content`` will be parsed as Markdown, since it
has been defined.

This content file:

    date: 2009, Jun—
    -
    content:
    # Title
    Lorem ipsum.

And this template file:

    [...]
    <h1>@title</h1>
    <h2>@date</h2>
    <div id="container">
      @content
    </div>
    [...]

will write to the following variables:

    @date => 2009, Jun—

    @content => <h1>Title</h1> <p>Lorem ipsum.</p>

And output the following:

    <h1>@title</h1>
    <h2>2009, Jun—</h2>
    <div id="container">
      <h1>Title</h1>
      <p>Lorem ipsum.</p>
    </div>

Since Markdown ignores HTML tags, if you prefer, you can choose to use HTML
markup instead of Markdown. The previous key-value pairs could just as easily be
written as:

    date: 2009, Jun—
    -
    content:
    <h1>Title</h1>
    <p>Lorem ipsum.</p>

It's your call.


####Markdown References####
Cindy implements Michel Fortin's
[PHP Markdown Extra](http://michelf.com/projects/php-markdown/extra/) project,
which is a PHP-specific version of Markdown. It also adds some of its own
functionality, so you may choose to refer to its documentation as well as John
Gruber's original "vanilla" Markdown.

* [Markdown Documentation](http://daringfireball.net/projects/markdown/syntax/)
* [PHP Markdown Extra Documentation](http://michelf.com/projects/php-markdown/extra/)


###JavaScript Injects###
Cindy also provides the means of easily referencing JavaScript files from
within your content files. There are two ways to do so:


####inject_head####
An ``inject_head`` block allows you to reference a JavaScript file,
automatically inserting a ``<script></script>`` element linked to the file
specified within your content file. Using ``inject_head`` will prepend the
``<script>`` tags before the closing ``</head>`` tag.

A ``.txt`` file containing:

    [...]
    inject_head "@path/foobar.js"
    [...]

becomes the HTML:

    [...]
      <script src="../content/3.about/foobar.js"></script>
    </head>
    <body>
    [...]

This creates a reference to the ``foobar.js`` file in the same folder as
``@path`` (``/content/3.about``).


####inject_body####
A ``inject_body`` block allows you to reference a JavaScript file using
``<script></script>`` from within your ``.txt`` files. Using ``inject_body``
will prepend the ``<script>`` tag(s) before the closing ``</body>`` tag.

A ``.txt`` file containing:

    [...]
    inject_body "@path/foobar.js"
    [...]

becomes the HTML:

    [...]
      <script src="../content/3.about/foobar.js"></script>
    </body>
    </html>
    [...]

This creates a reference to the ``foobar.js`` file in the same folder as the
``@path`` location (``../content/3.about``).


##Editing Templates##
Cindy templates use a mix of standard html markup tags, simple dynamic
@variables, and partial blocks to help create your final pages.

A typical template will look something like this:

    [...]
    </head>
    <body>
    <h1 class="col three">
      @name
      <strong>@profession</strong>
    </h1>
    <em class="col three">@email</em>
    <hr>
    :navigation
    <div id="content" class="col eight">
      :category_lists
    </div>
    <hr>
    <p class="col five">&copy; Copyright @name @current_year</p>
    [...]

All of the templates are stored within the ``/templates`` folder.

Partial templates sit within ``/templates/partials``: these are used for looping
through collections of assets (such as the images within a folder or sets
of navigation items).


####Template assignment####
As mentioned before, templates are assigned to pages based off the name of the
``.txt`` file within the page's folder. If no template matches are found, Cindy
will return an error.

ie. if the ``/content/2.contact-me/`` folder's .txt file is named
``contact-page.txt``, it will look for a corresponding template within the
``/templates`` folder, looking for one named ``contact-page.html``. If it
doesn't find that file, it displays an error.


####Template types####
It's probably worth noting that templates do not have to be ``.html`` files.
Cindy is able to recognize and serve the correct headers for templates with the
following extensions: ``.html``, ``.json``, ``.xml``, ``.atom``, ``.rss``,
``.rdf`` and ``.txt``


###Public folder###
If you have clean urls enabled, any files (and folders) within the ``/public``
folder will still be served from the root of your website.

ie. ``/public/docs/css/screen.css`` will be accessible from
``http://yourdomain.com/docs/css/screen.css``.

The public folder is generally where you store your CSS, JavaScript and any
other assets used within the templates.


###Language Constructs###
For all your Cindy templating needs, you have access to three language
constructs: ``get`` blocks, ``foreach`` loops, and boolean ``if`` statements.


####get####
Temporarily shift contexts to that of a specific page.

    get "/url" do
      # do stuff
    end

####foreach####
Do something for each element in a ``$collection``

    foreach $collection do
      # do stuff
    endforeach

####if####
If the booleann expression evaluates true, then do something

    if @variable do
      # do stuff
    endif

Note that you can create an ``else`` statement by negating the previous
statement

    if @variable do
      # do stuff
    endif

    if !@variable do
      # do else stuff
    endif

###Variable Context###
Once you are in a ``foreach`` loop, the variable context changes to the current
object being referenced by the loop.

The ``get`` block allows you to temporarily shift to the context of a specific
page.

    get "/projects/project-1" do
      <p>@page_name</p>
    end

This changes the context from the current page to the ``/projects/project-1``
page. Now, ``$children`` is filled with the children of the
``/projects/project-1`` page, ``@page_name`` is set equal the value of
``@title`` defined in the ``content.txt`` file, and so forth.

So, if you wanted to only list children of the ``/projects`` folder that don't
contain any children of their own, you could construct the following partial:

    <ul>
      get "/projects" do
        foreach $children do
          if !$children do
            <li><a href="@url">@page_name</a></li>
          endif
        endforeach
      end
    </ul>


###Limiting foreach loops###
Sometimes, you only need to loop through a few elements, instead of every
single element in a ``$collection``. Foreach loops can act like for loops, by
setting the start and position ($collection[``start``:``limit``]). The
collection is looped through from the provided ``start`` until the ``limit``.

The ``start`` and ``limit`` are both optional parameters. You could specify
``$collection[:2]`` to only list the first two items, or ``$collection[2:]`` to
list all items except the first two, or both, as the next example demonstrates.

The following partial starts at the third item in the ``$children`` collection,
and lists the next 2 items (the third and fourth item):

    <ol id="navigation">
      foreach $children[2:2] do
        <li><a href="@url">@page_name</a></li>
      endforeach
    </ol>


###Nested foreach loops###
``foreach`` loops can also be nested within themselves, allowing you to
traverse through multiple levels of objects.

This can be used to generate a simple navigation menu.

    <ol id="navigation">
      foreach $root do
        <li><a href="@url">@page_name</a>
          if $children do
            <ol>
              foreach $children do
                <li><a href="@url">@page_name</a>
              endforeach
            </ol>
          endif
        </li>
      endforeach
    </ol>


##Assets##
In addition to any images or videos, Cindy will also place any assets it
recognizes in their own collections.

    $pdf: ['pdf-file.pdf' => Asset]

    $mp3: ['mp3-file-1.mp3' => Asset,
           'mp3-file-2.mp3' => Asset]

    $html: ['youtube-embed.html' => HTML]

    $doc: ['word-document.doc' => Asset]

    $jpg: ['01.jpg' => Image]

Each of these are a collection that can be looped over within your templates or
partials, in the same way as a ``$images`` or ``$video`` collection.

ie. To loop over all the ``$mp3`` files:

    foreach $mp3 do
      # do mp3 stuff (maybe an audio player?)
    endforeach

For known asset types, Cindy can also construct specific ``@variables``

###Images###
Cindy recognizes the following image extensions (.jpg, .jpeg, .gif, .png) and
will place these image files into their respective asset collections.


####@name####
The name of the current image, after converting the filename into sentence-text
format
(ie. 1.vacation-photo.jpg becomes Vacation photo)


####@file_name####
The filename of the current file.
(ie. 1.vacation-photo.jpg)


####@url####
The relative path to this file from the current page.


####@small####
The relative path to a file with the same name & filetype of the current file,
with an _sml suffix (if such a file exists).
(ie. photo.jpg would have an ``@small`` var of photo_sml.jpg)


####@large####
The relative path to a file with the same name & filetype of the current file,
with an _lge suffix (if such a file exists).
(ie. photo.jpg would have an @large var of photo_lge.jpg)


####@width####
The width of the current image.
(ie. 1024)


####@height####
The height of the current image.
(ie. 768)

####@orientation####
The current image's orientation.
(either 'portrait', 'landscape' or 'square')


####@height####
The height of the current image.
(ie. 768)


###Video###
Cindy will put any video files with the following extensions
(.mov, .mp4, .m4v, .swf) into their respective asset collections


####@name####
The name of the current video, created by converting the filename into
sentence-text format
(ie. 1.best-movie-ever.mov becomes Best movie ever)


####@file_name####
The filename of the current file.


####@url####
The relative path to this file from the current page


####@width####
The width of the current video (pulled from the name of the file)
(ie. ``@width``, on the filename "best-movie-ever-300x150.mov", returns 300)


####@height####
The height of the current video (pulled from the name of the file).
(ie. ``@height``, on the filename "best-movie-ever-300x150.mov", returns 150)


###HTML###
Cindy will put any html files (.html, .htm) into their respective collections


####@name####
The name of the current file, created by converting the filename into
sentence-text format
(ie. 1.my-cat-videos.html becomes My cat videos)


####@file_name####
The filename of the current file


####@url####
The relative path to this file from the current page


####@content####
The contents of the html file (as raw html)


##Variable Types##
###@variables##
There are 2 types of **@variables**. The first type are automatically generated
for each page within the site.


####@root_path####

Outputs the relative path from the current page to the root of the site
(ie. in ``/projects/project-name/@root_path`` will contain ``../../``)


####@thumb####

Outputs the relative url to the thumbnail for the current page, if a thumb file
(.gif, .jpg or .png) exists.
(ie. ``../projects/thumb.jpg``)


####@url####

Outputs the relative path to this page from the current page
(ie. ``../../projects/project-1``)


####@permalink####

Outputs the absolute url path of the current page
(ie. ``projects/project-1``)


####@slug####

Outputs the slug of the current page
(ie. ``project-1``)


####@is_current####

Returns true if ``@permalink`` matches the server's request uri

ie.

    if @permalink do
      # do stuff
    endif


####@is_first####

Returns true if the current page is first in its collection

ie.

    foreach $children do
      if @is_first do
        # do stuff
      endif
    endforeach


####@is_last####

Returns true if the current page is last in its collection

ie.

    foreach $children do
      if @is_last do
        # do stuff
      endif
    endforeach


####@page_name####

Outputs the name of the current page, by converting the page's slug into
Title Case text
(ie. ``test-project-1`` becomes ``Test Project 1``).


####@siblings_count####

Outputs the amount of siblings, relative to the current page
(ie. ``12``)


####@children_count####

The number of children, relative to the current page
(ie. ``12``)


####@index####

The position of the current page in the collection it is in
(usually relative to its siblings)
(ie. ``5``)


####@current_year####

Outputs the current year
(ie. ``2014``)


####@domain_name####

Outputs the domain name of the current site
(ie. ``yoursite.com``)


####@base_url####

Outputs the domain name & folder path cindy is running from
(ie. ``yoursite.com/cindy``)


####@site_updated####

Outputs the date the *site* was last edited in the
[RFC 3339](http://tools.ietf.org/html/rfc3339) format
(ie. ``2014-10-25T17:34:23+11:00``)


####@updated####

Output the date the *current* page was last edited in the
[RFC 3339](http://tools.ietf.org/html/rfc3339) format
(ie. ``2014-10-25T17:34:23+11:00``)


####@stacey_version####

Output the version of cindy you are running
(ie. ``0.1``)


###Text-file Variables###
The other type of @variables can be called from your ``.txt`` files, and have
been discussed before.


####@path####

Outputs the full file system path to the current page.
(ie. ``/content/3.about``)


####@bypass_cache####

If set, Cindy's file-caching will be disabled for this page only.

ie. ``@bypass_cache: true``


You can also create custom named collections of assets, by prepending an
underscore before the folder name. These collections can be referred to by
``$foldername``.
(ie. for the ``_solutions`` folder, Cindy creates the collection $solutions)


###$collections###
Cindy provides collections of related pages and assets, which can be looped over
from within the templates, using a foreach loop.

These are the included ``$collections``

####$root####

Lists each top-level page within `/content`


####$children####

Lists any child pages relative to the current page


####$parents####

Lists the full ancestor tree relative to the current page


####$parent####

Lists the direct ancestor relative to the current page


####$siblings####

Lists any pages sitting at the same level as the current page. This collection
**does not** include the current page


####$siblings_and_self####

Lists any pages sitting at the same level as the current page. This collection
includes the current page.


####$next_sibling####

Constructs a reference to the next page sitting at the same level as the
current page (in reverse-numeric order).


####$previous_sibling####

Constructs a reference to the previous page sitting at the same level as the
current page (in reverse-numeric order).


###:partials###
When portions of your templates are shared between pages (headers, footers),
it's useful to create partials. Partials are a way to include markup from
within the ``/templates/partials`` directory (ie. ``:navigation``) into your
template.

As you might immediately see, partials make updating shared code much easier.

The folder structure within ``/templates/partials`` is flattened, so you can
place your partial files within whatever subfolders make sense to you. However,
this also means you can't have two templates with the same name, even if they're
within different folders, or have different file extensions.

In order to reference a partial, use a ``:`` followed by the filename of the
partial template.

ie. `:images` will include the ``/templates/partials/assets/images.html``
partial

If you're still confused, think about it as includes/requires in PHP
(``include``, ``require``, ``include_once``, ``require_once``)

As with templates, partials do not need to be .html files. Cindy will recognise
the following formats:
``.htm``, `.html`, `.json`, `.xml`, `.atom`, `.rss`, `.rdf` & `.txt`


####Nested partials####
Partial references can also be nested within other partials. For example, a
``:media`` partial could contain:

``/templates/partials/assets/media.html``

    if $images do
      :images
    endif

    if $video do
      :video
    endif

where ``:images`` & ``:video`` are references to other partial files
(``/templates/partials/assets/images.html`` & ``/templates/partials/assets/video.html``)


###JSON###
Cindy automatically compresses and strips any trailing commas from JSON
templates.
