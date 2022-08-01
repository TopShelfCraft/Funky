# Funky

_A `func`-y little Craft CMS extension to enable anonymous function definition in Twig._

**A (somewhat reluctant) [Top Shelf Craft](https://topshelfcraft.com) creation**  
[Michael Rog](https://michaelrog.com), Proprietor

### TL;DR.

Twig famously [prohibits defining functions in templates](https://github.com/twigphp/Twig/issues/3402) and only parses arrow syntax in the context of filter parameters.
Funky provides a workaround for this limitation, allowing you to create ad-hoc functions in your templates, using a special syntax.

* * *

## Installation

Install the package via Composer.
```
composer require topshelfcraft/funky
```

The extension is bootstrapped automatically.

## Usage

Once installed, Funky enables a special syntax for defining functions in your Twig templates: `funky|fn()`

You can create a function _inline_, by passing an arrow function as a solo argument:

```
funky|fn(x => x*2)
```

You can also _register_ a function to access later, by passing both a name _and_ the arrow function as arguments:

```twig
{% do funky|fn('double', x => x*2) %}
{% do funky|fn('triple', x => x*3) %}

{{ fns.double(42) }}
{{ fns.triple(42) }}
```

## I have a bad feeling about this...

Well, it's a hack. If you're using this, it might be a [code smell](https://en.wikipedia.org/wiki/Code_smell). Twig has resisted this functionality for good reason: Templates should only be concerned about _presentation_; ideally they should _not_ contain logic.

Of course, once you understand the rules, you can _break_ the rules... 

Used thoughtfully, there are some circumstances in which the ability to define ad-hoc functions might actually help DRY up your template code:
 - Your custom functions are not reused across multiple templates, so it doesn't make sense to define them in a [custom module](https://craftcms.com/docs/4.x/extend/module-guide.html).
 - You need to pass a custom function into a [Collection](https://craftcms.com/docs/4.x/dev/functions.html#collect) pipeline method.
 - You're using Twig's `filter`, `map`, or `reduce` [filters](https://twig.symfony.com/doc/3.x/filters/index.html), and you want to reuse the same arrow function for multiple invocations in the same template.

So, proceed with temperance... or, reckless abandon; Who am I to tell you what to do?

## How does it work?

Twig parses arrow function syntax in the context of filter parameters. So, Funky defines a `fn` filter, which either:
 - returns the Closure directly (if the first given argument is callable).
 - registers the function as a virtual property of the Funky class instance, making it available via the `fns` global (if the first given argument is a function _name_).

## What are the system requirements?

Craft 4.0+ and PHP 8.0.2+

## I found a bug.

For heaven's sake, really?!

**_Yes, I double-checked... It's a bug._**

Very well. Please open a [GitHub Issue](https://github.com/topshelfcraft/Funky/issues). If you're feeling ambitious, submit a PR to the `4.x.dev` branch.

* * *

### Contributors:

  - Extension development: [Michael Rog](https://michaelrog.com) / @michaelrog
