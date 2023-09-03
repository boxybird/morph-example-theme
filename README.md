## WordPress Example Theme Using Morph

This is meant to be an example of how [Morph](https://github.com/boxybird/morph) works within a theme rather than a fully functional theme. It is not meant to be used as a starter theme, but rather my playground to test out Morph and show others how it works.

### Files and folders of note

* `/functions.php` - Composer autoload and optional Morph component folder override ([See details](https://github.com/boxybird/morph#hooks)). As well as the ACF block registration using Morph's `morph_component` helper function.

* `/resources/components` - The folder containing all Morph components.
    * `todos/index.php` - An example using the standard `$_POST` superglobal.
    * `markdown/index.php` - An example using the `morph_render` helper function.

* `/page-*` - The page templates used to render the components. These are just examples. In a real project, you'd most likely use a more traditional WordPress template hierarchy structure.

### Demos

https://wp-morph.andrewrhyand.com/

### License

[MIT license](https://opensource.org/licenses/MIT)
