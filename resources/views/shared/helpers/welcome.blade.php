Welcome to Canvas! I'm your first post demonstrating Markdown integration. Don't delete me, I'm very helpful! If you do delete me though, I can be recovered. Just grab me from:

```
resources/views/shared/helpers/welcome.blade.php
```

<div class="section-divider"></div>

## The Basics
---

Before I tell you about all the extra syntaxes and capabilities you have available to you, I'll introduce you to the basics of standard markdown. If you already know markdown, and want to jump straight to learning about the fancier things I can do, feel free to skip this section. Lets jump right in!

Markdown is a plain text formatting syntax created by John Gruber, aiming to provide a easy-to-read and feasible markup. The original Markdown syntax specification can be found [here](http://daringfireball.net/projects/markdown/syntax).

<div class="section-divider"></div>

## Typography
---

# Header 1
## Header 2
### Header 3
#### Header 4
##### Header 5
###### Header 6

**Strong**: `**Strong**` or `__Strong__` (Command-B)
*Emphasize*: `*Emphasize*` or `_Emphasize_`[^emphasize] (Command-I)

### Links and Email
#### Inline
Just put angle brackets around an email and it becomes clickable: <uranusjr@gmail.com>
`<uranusjr@gmail.com>`

Same thing with urls: <http://macdown.uranusjr.com>
` <http://macdown.uranusjr.com>`

Perhaps you want to some link text like this: [Macdown Website](http://macdown.uranusjr.com "Title")
`[Macdown Website](http://macdown.uranusjr.com "Title")` (The title is optional)

#### Reference style
Sometimes it looks too messy to include big long urls inline, or you want to keep all your urls together.

Make [a link][arbitrary_id] `[a link][arbitrary_id]` then on it's own line anywhere else in the file:
`[arbitrary_id]: http://macdown.uranusjr.com "Title"`

If the link text itself would make a good id, you can link [like this][] `[like this][]`, then on it's own line anywhere else in the file:
`[like this]: http://macdown.uranusjr.com`

[arbitrary_id]: http://macdown.uranusjr.com "Title"
[like this]: http://macdown.uranusjr.com

Option name         | Markup           | Result if enabled     |
--------------------|------------------|-----------------------|
Intra-word emphasis | So A\*maz\*ing   | So A<em>maz</em>ing   |
Strikethrough       | \~~Much wow\~~   | <del>Much wow</del>   |
Underline [^under]  | \_So doge\_      | <u>So doge</u>        |
Quote [^quote]      | \"Such editor\"  | <q>Such editor</q>    |
Highlight           | \==So good\==    | <mark>So good</mark>  |
Superscript         | hoge\^(fuga)     | hoge<sup>fuga</sup>   |
Autolink            | http://t.co      | <http://t.co>         |
Footnotes           | [\^4] and [\^4]: | [^4] and footnote 4   |

<div class="section-divider"></div>

## Markdown Extra
---

Canvas supports **Markdown Extra**, which extends traditional **Markdown** syntax with some nice features. If you need some help or just need a refresher, read more about [Markdown syntax](https://daringfireball.net/projects/markdown/syntax) and [Markdown Extra](https://michelf.ca/projects/php-markdown/extra/).

<div class="section-divider"></div>

## Tables
---

**Markdown Extra** has a special syntax for tables:
##### This input:
```
Key | Value
--- | ---
SSH Host | `example.com`
SSH User | `username`
SSH Password | `secret`
Database Host | `127.0.0.1`
Database User | `username`
Database Password | `secret`
```

<div class="section-divider"></div>

##### Becomes this output:
Key                 | Value
------------------- | ---
SSH Host            | `example.com`
SSH User            | `username`
SSH Password        | `secret`
Database Host       | `127.0.0.1`
Database User       | `username`
Database Password   | `secret`

<div class="section-divider"></div>

## Code Blocks
---

`Inline code` is indicated by surrounding it with backticks:
`` `Inline code` ``

If your ``code has `backticks` `` that need to be displayed, you can use double backticks:
```` ``Code with `backticks` `` ````  (mind the spaces preceding the final set of backticks)

GitHub's fenced code blocks are supported in Canvas:

```
namespace App;

class Blog extends Canvas
{

    /**
    * Dreaming of something more?
    *
    * @with Canvas
    */
    public function create()
    {
        // Make something awesome...
    }
}
```

You can also use waves (`~`) instead of back ticks (`` ` ``):

~~~
print('Hello world!')
~~~

<div class="section-divider"></div>

## Lists
---

* Lists must be preceded by a blank line (or block element)
* Unordered lists start each item with a `*`
- `-` Works too
  * Indent a level to make a nested list
    1. Ordered lists are supported.
    2. Start each item (number-period-space) like `1`
    3. It doesn't matter what number you use, it will render sequentially

Here is the code:

```
* Lists must be preceded by a blank line (or block element)
* Unordered lists start each item with a `*`
- `-` Works too
  * Indent a level to make a nested list
    1. Ordered lists are supported.
    2. Start each item (number-period-space) like `1.`
    42. It doesn't matter what number you use, it will render sequentially
```

### Block Quote

> Angle brackets `>` are used for block quotes.
Technically not every line needs to start with a `>` as long as
there are no empty lines between paragraphs.
> Looks kinda ugly though.
> > Block quotes can be nested.
> > > Multiple Levels
>
> Most markdown syntaxes work inside block quotes.
>
> * Lists
> * [Links][arbitrary_id]
> * Etc.

Here is the code:

```
> Angle brackets `>` are used for block quotes.
Technically not every line needs to start with a `>` as long as
there are no empty lines between paragraphs.
> Looks kinda ugly though.
> > Block quotes can be nested.
> > > Multiple Levels
>
> Most markdown syntaxes work inside block quotes.
>
> * Lists
> * [Links][arbitrary_id]
> * Etc.
```

### Horizontal Rules
If you type three asterisks `***` or three dashes `---` on a line, I'll display a horizontal rule:

***

### Document Formatting
The ***Smartypants*** extension automatically transforms straight quotes (`"` and `'`) in your text into typographer’s quotes (`“`, `”`, `‘`, and `’`) according to the context. Very useful if you’re a typography freak like I am. Quote and Smartypants are syntactically incompatible. If both are enabled, Quote takes precedence.

### Block Formatting

#### Table

This is a table:

First Header  | Second Header
------------- | -------------
Content Cell  | Content Cell
Content Cell  | Content Cell

You can align cell contents with syntax like this:

| Left Aligned  | Center Aligned  | Right Aligned |
|:------------- |:---------------:| -------------:|
| col 3 is      | some wordy text |         $1600 |
| col 2 is      | centered        |           $12 |
| zebra stripes | are neat        |            $1 |

The left- and right-most pipes (`|`) are only aesthetic, and can be omitted. The spaces don’t matter, either. Alignment depends solely on `:` marks.

You can add an optional language ID at the end of the first line. The language ID will only be used to highlight the code inside if you tick the ***Enable highlighting in code blocks*** option. This is what happens if you enable it:

I support many popular languages as well as some generic syntax descriptions that can be used if your language of choice is not supported. See [relevant sections on the official site](http://macdown.uranusjr.com/features/) for a full list of supported syntaxes.

### Task List Syntax
1. [x] Support for rendering checkbox list syntax
  * [x] Support for nesting
  * [x] Support for ordered *and* unordered lists
2. [ ] No support for clicking checkboxes directly in the html window

<div class="section-divider"></div>

## Hack On
---

That’s about it. Thanks for listening. I’ll be quiet from now on (unless there’s an update about the app — I’ll remind you for that!).

Happy writing!